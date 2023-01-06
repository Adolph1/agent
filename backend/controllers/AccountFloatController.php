<?php

namespace backend\controllers;

use backend\models\Account;
use backend\models\Branch;
use backend\models\CashBook;
use backend\models\Product;
use backend\models\User;
use Yii;
use backend\models\AccountFloat;
use backend\models\AccountFloatSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountFloatController implements the CRUD actions for AccountFloat model.
 */
class AccountFloatController extends Controller
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
     * Lists all AccountFloat models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountFloatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AccountFloat model.
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
     * Creates a new AccountFloat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AccountFloat();
        $model->branch_id = Branch::getMyBranchId();
        $model->company_id = User::myCompanyID();
        $model->maker_time = User::getUserTime();
        $model->maker = User::getUsername();
        $model->status = 0;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    //confirm the transaction to be posted in cash book
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->status = 1;

            $transaction = \Yii::$app->db->beginTransaction();
            $cashbook = new CashBook();
            $cashbook->trn_dt = $model->trn_dt;
            $cashbook->transaction_account_id = $model->account_id;
            $cashbook->money_in_account = $model->account_id;
            $cashbook->branch_id = $model->branch_id;
            $cashbook->money_out_account = Account::getMyCashAccount();
            $cashbook->product_id = Product::WITHDRAW;
            $cashbook->product_code = 'WDR';
            $cashbook->in_amount = $model->float_amount;
            $cashbook->out_amount = $model->float_amount;
            $cashbook->transaction_amount = $model->float_amount;
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
                            'message' => 'Successfully confirmed, float added to ' . $model->account->name . ' account.',
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
     * Updates an existing AccountFloat model.
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
     * Deletes an existing AccountFloat model.
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
     * Finds the AccountFloat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AccountFloat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AccountFloat::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
