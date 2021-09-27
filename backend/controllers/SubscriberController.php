<?php

namespace backend\controllers;

use Yii;
use backend\models\Subscriber;
use backend\models\SubscriberSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SubscriberController implements the CRUD actions for Subscriber model.
 */
class SubscriberController extends Controller
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
     * Lists all Subscriber models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SubscriberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Subscriber model.
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
     * Creates a new Subscriber model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Subscriber();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionRegister($id)
    {

        $model = $this->findModel($id);
        $data = [
            'agent_name' => $model->full_name,
            'agent_code' => $model->agent_code,
            'email_address' => $model->email_address,
            'mobile_number' => $model->mobile_number,
            'date_of_birth' => $model->date_of_birth,
        ];


        try {

            // return Json
            $username = 'admin';
            $password = 'xyz123456';
//            $access_token = '313jFMbaD-mzBj-pWBgHQdcCdGHmJQe2';
            $url = "http://localhost/interview/frontend/web/index.php?r=api/register";

            $headers = array(
                "Content-Type: application/json; charset=utf-8",
                "Accept: application/json",
                "Authorization: Basic " . base64_encode($username . ":" . $password),
            );
            $datastring = json_encode($data);

            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $datastring);
            $result = curl_exec($curl);
            curl_close($curl);


            Yii::$app->session->setFlash('', [
                'type' => 'danger',
                'duration' => 5000,
                'icon' => 'fa fa-alert',
                'message' => 'You have been registered successfully',
                'positonY' => 'bottom',
                'positonX' => 'right'
            ]);
            Subscriber::updateAll(['status' => 1],['id' => $model->id]);



            return $this->redirect(['view', 'id' => $model->id]);
        } catch (\Exception $exception) {
            return $exception;
        }
    }



    /**
     * Updates an existing Subscriber model.
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
     * Deletes an existing Subscriber model.
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
     * Finds the Subscriber model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Subscriber the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Subscriber::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
