<?php


namespace backend\controllers;


use backend\models\IncomingSalesData;
use backend\models\Company;
use backend\models\Product;
use backend\models\PtsDevice;
use backend\models\SignedUnsignedZReport;
use backend\models\StationProductPrice;
use backend\models\UrlConfig;
use backend\models\WebVfdApi;
use common\models\LoginForm;
use common\models\User;
use Da\QrCode\QrCode;
use frontend\models\DailyCounter;
use frontend\models\GlobalCounter;
use frontend\models\ReceiptData;
use frontend\models\Sales;
use frontend\models\Taxconfig;
use frontend\models\TraLogs;
use frontend\models\ZReportData;
use kartik\mpdf\Pdf;
use Yii;
use yii\filters\AccessControl;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\ContentNegotiator;
use yii\rest\Controller;
use SimpleXMLElement;



class ApiController extends Controller
{
    public function behaviors()
    {

        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::className(),
            'auth' => function ($username, $password) {
                $user = User::findByUsername($username);
                return $user->validatePassword($password)
                    ? $user
                    : null;
            }
        ];
        $behaviors['contentNegotiator'] = [
            'class' => ContentNegotiator::className(),
            'formats' => [
                'application/json' => \yii\web\Response::FORMAT_JSON,
            ],
        ];
        $behaviors['access'] = [
            'class' => AccessControl::className(),
            'only' => ['dashboard', 'login'],
            'rules' => [
                [
                    'actions' => ['dashboard', 'login'],
                    'allow' => true,
                    'roles' => ['@'],
                ],
            ],
        ];
        return $behaviors;


    }

    public function actionLogin()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;
        $response = [

            'success'=>true,
            'access_token' => Yii::$app->user->identity->getAuthKey(),
            'username' => Yii::$app->user->identity->username,
//            'user_id' => Yii::$app->user->identity->user_id,
            'status' => Yii::$app->user->identity->status,

        ];
        return $response;

    }

    public function actionRegistration()
    {
        \Yii::$app->response->format = \yii\web\Response:: FORMAT_JSON;

        $data = file_get_contents('php://input');
        if ($data) {
            return $data;
        }

    }



}