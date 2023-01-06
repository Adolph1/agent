<?php

namespace backend\controllers;

use backend\models\Account;
use backend\models\Branch;
use backend\models\CashBook;
use backend\models\Product;
use backend\models\User;
use Yii;
use backend\models\MoneyTransfer;
use backend\models\MoneyTransferSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MoneyTransferController implements the CRUD actions for MoneyTransfer model.
 */
class MoneyTransferController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all MoneyTransfer models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MoneyTransferSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MoneyTransfer model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MoneyTransfer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MoneyTransfer();
        $model->requested_by = User::getUsername();
        $model->requested_time = User::getUserTime();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing MoneyTransfer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing MoneyTransfer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * confirms money transfer
     */
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;

        $transaction = \Yii::$app->db->beginTransaction();
        $cashbook = new CashBook();
        $cashbook->trn_dt = $model->trn_dt;
        $cashbook->transaction_account_id = $model->account_id;
        $cashbook->money_out_account = $model->account_id;
        $cashbook->branch_id = $model->from_branch_id;
        $cashbook->money_in_account = Account::getMyCashAccount();
        $cashbook->product_id = Product::TRANSFER;
        $cashbook->product_code = 'TRF';
        $cashbook->in_amount = $model->amount;
        $cashbook->out_amount = $model->amount;
        $cashbook->transaction_amount = $model->amount;
        $cashbook->period = date('m');
        $cashbook->year = date('Y');
        $cashbook->maker = User::getUsername();
        $cashbook->maker_time = User::getUserTime();
        try {



            if($cashbook->save() && $model->save()){
                $flag = Account::UpdateBalances($cashbook->money_in_account,$cashbook->in_amount,$cashbook->money_out_account,$cashbook->out_amount);
                if($flag == 1) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa-tick',
                        'message' => 'Successfully confirmed, amount transferred to ' . $model->toBranch->name . ' branch.',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }elseif($flag == 0){
                    Yii::$app->session->setFlash('', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'warning',
                        'message' => 'Please check the account balance, or add float to your account',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);
                    $transaction->rollBack();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                Yii::$app->session->setFlash('', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'warning',
                    'message' => 'Failed to save data, please contact system administrator',
                    'positonY' => 'bottom',
                    'positonX' => 'right'
                ]);
                $transaction->rollBack();
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }catch (Exception $ex){
            $transaction->rollBack();
            return $this->redirect(['view', 'id' => $model->id]);

        }
    }


    /**
     * confirms money transfer
     */
    public function actionAccept($id)
    {
        $model = $this->findModel($id);
        $model->status = 2;
        $model->accepted_by = User::getUsername();
        $model->accepted_time = User::getUserTime();
        $myreceivingAccount = Account::find()->where(['service_provider_id' => $model->account->service_provider_id,'branch_id' => Branch::getMyBranchId()])->one();


        $transaction = \Yii::$app->db->beginTransaction();
        $cashbook = new CashBook();
        $cashbook->trn_dt = $model->trn_dt;
        $cashbook->transaction_account_id = $myreceivingAccount->id;
        $cashbook->money_out_account = Account::getMyCashAccount();
        $cashbook->branch_id = $model->to_branch_id;
        $cashbook->money_in_account = $myreceivingAccount->id;
        $cashbook->product_id = Product::TRANSFER;
        $cashbook->product_code = 'TRF';
        $cashbook->in_amount = $model->amount;
        $cashbook->out_amount = $model->amount;
        $cashbook->transaction_amount = $model->amount;
        $cashbook->period = date('m');
        $cashbook->year = date('Y');
        $cashbook->maker = User::getUsername();
        $cashbook->maker_time = User::getUserTime();
        try {



            if($cashbook->save() && $model->save()){
                $flag = Account::UpdateBalances($cashbook->money_in_account,$cashbook->in_amount,$cashbook->money_out_account,$cashbook->out_amount);
                if($flag == 1) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa-tick',
                        'message' => 'Successfully confirmed, amount transferred to ' . $model->toBranch->name . ' branch.',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);
                    return $this->redirect(['view', 'id' => $model->id]);
                }elseif($flag == 0){
                    Yii::$app->session->setFlash('', [
                        'type' => 'danger',
                        'duration' => 3000,
                        'icon' => 'warning',
                        'message' => 'Please check the account balance, or add float to your account',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);
                    $transaction->rollBack();
                    return $this->redirect(['view', 'id' => $model->id]);
                }
            }else{
                Yii::$app->session->setFlash('', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'warning',
                    'message' => 'Failed to save data, please contact system administrator',
                    'positonY' => 'bottom',
                    'positonX' => 'right'
                ]);
                $transaction->rollBack();
                return $this->redirect(['view', 'id' => $model->id]);
            }

        }catch (Exception $ex){
            $transaction->rollBack();
            return $this->redirect(['view', 'id' => $model->id]);

        }
    }

    /**
     * Finds the MoneyTransfer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MoneyTransfer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MoneyTransfer::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
