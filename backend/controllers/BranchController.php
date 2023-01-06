<?php

namespace backend\controllers;

use backend\models\User;
use Yii;
use backend\models\Branch;
use backend\models\BranchSearch;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BranchController implements the CRUD actions for Branch model.
 */
class BranchController extends Controller
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
     * Lists all Branch models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BranchSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Branch model.
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
     * Creates a new Branch model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if(Yii::$app->user->can('createBranch')) {
            $model = new Branch();
            $user = new User();
            $transaction = \Yii::$app->db->beginTransaction();
            if ($model->load(Yii::$app->request->post()) && $model->save() && $user->load(Yii::$app->request->post())) {
                $user->branch_id = $model->id;
                try {

                    if ($user->save(false)) {
                        Branch::updateAll(['branch_manager' => $user->id], ['id' => $model->id]);

                        $transaction->commit();
                    }
                    return $this->redirect(['view', 'id' => $model->id]);
                }catch (Exception $e) {
                    $transaction->rollBack();
                }
            }

            return $this->render('create', [
                'model' => $model, 'user' => $user
            ]);
        }else{
            Yii::$app->session->setFlash('', [
                'type' => 'danger',
                'duration' => 1500,
                'icon' => 'warning',
                'message' => 'You dont have permission to create a branch',
                'positonY' => 'bottom',
                'positonX' => 'right'
            ]);
            return $this->redirect(['index']);
        }
    }

    /**
     * Updates an existing Branch model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $user = new User();

        if ($model->load(Yii::$app->request->post()) && $user->load(Yii::$app->request->post()) && $model->save()) {
            $user->branch_id = $model->id;
            if($user->save(false)){
                Branch::updateAll(['branch_manager' => $user->id],['id' => $model->id]);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'user' => $user
        ]);
    }

    /**
     * Deletes an existing Branch model.
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
     * Finds the Branch model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Branch the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Branch::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
