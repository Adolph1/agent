<?php

namespace backend\controllers;

use backend\models\User;
use Yii;
use backend\models\Account;
use backend\models\AccountSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AccountController implements the CRUD actions for Account model.
 */
class AccountController extends Controller
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
     * Lists all Account models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AccountSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Account model.
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
     * Creates a new Account model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Account();
        $model->maker_time = User::getUserTime();
        $model->maker = User::getUsername();

        if ($model->load(Yii::$app->request->post())) {
            $posted_cash_account = $_POST['Account']['is_cash_account'];
            $branch_id = $_POST['Account']['branch_id'];
            $model->account_no = Account::getAccount().$branch_id;
            $exist = Account::find()->where(['branch_id' => $branch_id,'is_cash_account' => 1])->count();
            if($exist == 0){
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                if($posted_cash_account == 1) {
                    Yii::$app->session->setFlash('', [
                        'type' => 'danger',
                        'duration' => 1500,
                        'icon' => 'warning',
                        'message' => 'Only One cash account is allowed per branch',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }else{
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Account model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->maker_time = User::getUserTime();
        $model->maker = User::getUsername();

        if ($model->load(Yii::$app->request->post())) {

            $posted_cash_account = $_POST['Account']['is_cash_account'];
            $branch_id = $_POST['Account']['branch_id'];
            $exist = Account::find()->where(['branch_id' => $branch_id,'is_cash_account' => 1])->count();
            if($exist == 0){
                $model->save();
                return $this->redirect(['view', 'id' => $model->id]);
            }else {
                if($posted_cash_account == 1) {
                    Yii::$app->session->setFlash('', [
                        'type' => 'danger',
                        'duration' => 1500,
                        'icon' => 'warning',
                        'message' => 'Only One cash account is allowed per branch',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);
                    return $this->render('create', [
                        'model' => $model,
                    ]);
                }else{
                    $model->save();
                    return $this->redirect(['view', 'id' => $model->id]);
                }

            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Account model.
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
     * Finds the Account model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Account the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Account::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
