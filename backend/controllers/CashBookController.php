<?php

namespace backend\controllers;

use backend\models\Account;
use backend\models\Product;
use backend\models\User;
use Yii;
use backend\models\CashBook;
use backend\models\CashBookSearch;
use yii\base\UserException;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CashBookController implements the CRUD actions for CashBook model.
 */
class CashBookController extends Controller
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
     * Lists all CashBook models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CashBookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CashBook model.
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
     * Creates a new CashBook model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CashBook();

        if ($model->load(Yii::$app->request->post())) {
            $product = $_POST['CashBook']['product_id'];
            $branch_id = $_POST['CashBook']['branch_id'];
            $transaction_account = $_POST['CashBook']['transaction_account_id'];
            $transaction_amount = $_POST['CashBook']['transaction_amount'];
            if ($branch_id != null) {
                //fetch cash account by Id
                $cashAccount = Account::getMyCashAccount();
                if ($cashAccount != null && $transaction_account != null) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    if ($product == Product::WITHDRAW) {


                        try {
                            $model->money_in_account = $transaction_account;
                            $model->money_out_account = $cashAccount;
                            $model->product_code = 'WDR';
                            $model->in_amount = $transaction_amount;
                            $model->out_amount = $transaction_amount;
                            $model->period = date('m');
                            $model->year = date('Y');
                            $model->maker = User::getUsername();
                            $model->maker_time = User::getUserTime();
                            $model->save();
                            $flag = Account::UpdateBalances($model->money_in_account,$model->in_amount,$model->money_out_account,$model->out_amount);
                            if($flag == 1){
                                $transaction->commit();
                                return $this->redirect(['view', 'id' => $model->id]);
                            }else{
                                $transaction->rollBack();
                            }


                        }catch (Exception $e) {
                            $transaction->rollBack();
                        }

                    }elseif ($product == Product::DEPOSIT){

                        try {
                            $model->money_in_account = $cashAccount;
                            $model->money_out_account = $transaction_account;
                            $model->product_code = 'DST';
                            $model->in_amount = $transaction_amount;
                            $model->out_amount = $transaction_amount;
                            $model->period = date('m');
                            $model->year = date('Y');
                            $model->maker = User::getUsername();
                            $model->maker_time = User::getUserTime();
                            $model->save();
                            $flag = Account::UpdateBalances($model->money_in_account,$model->in_amount,$model->money_out_account,$model->out_amount);
                            if($flag == 1){
                                $transaction->commit();
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
                                return $this->render('create', [
                                    'model' => $model,
                                ]);
                            }

                            return $this->redirect(['view', 'id' => $model->id]);
                        }catch (Exception $e) {
                            $transaction->rollBack();
                            return $this->render('create', [
                                'model' => $model,
                            ]);
                        }
                    }
                }else{
                    throw new UserException(Yii::t('app', 'You dont have cash account please check with your business manager .'));
                }
            }else{
                // check well branch configuration with this user
                throw new NotFoundHttpException(Yii::t('app', 'You must be linked with branch to perform this.'));
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing CashBook model.
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
     * Deletes an existing CashBook model.
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
     * Finds the CashBook model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CashBook the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CashBook::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
