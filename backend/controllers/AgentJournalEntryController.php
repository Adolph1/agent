<?php

namespace backend\controllers;

use backend\models\Account;
use backend\models\AgentJournalLine;
use backend\models\CashBook;
use backend\models\Model;
use backend\models\Product;
use backend\models\User;
use kartik\form\ActiveForm;
use Yii;
use backend\models\AgentJournalEntry;
use backend\models\AgentJournalEntrySearch;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * AgentJournalEntryController implements the CRUD actions for AgentJournalEntry model.
 */
class AgentJournalEntryController extends Controller
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
     * Lists all AgentJournalEntry models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AgentJournalEntrySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AgentJournalEntry model.
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
     * Creates a new AgentJournalEntry model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new AgentJournalEntry();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('create', [
//            'model' => $model,
//        ]);
//    }


    public function actionCreate()
    {
        $model = new AgentJournalEntry();
        $items = [new AgentJournalLine()];
        $model->auth_stat = 'U';
        $model->company_id = User::myCompanyID();
        $model->maker_id = User::getUsername();
        $model->maker_time = User::getUserTime();


        if ($model->load(Yii::$app->request->post())) {
            $items = Model::createMultiple(AgentJournalLine::classname());
            Model::loadMultiple($items, Yii::$app->request->post());
            $transaction = \Yii::$app->db->beginTransaction();
            $flag = 0;
            try {
                if ($model->save(false)) {
                    foreach ($items as $item) {
                        $item->journal_id = $model->id;
                        $item->branch_id = $model->branch_id;
                        $item->trn_dt = $model->trn_dt;
                        if($item->money_in != 0.00){
                            $item->trn_type = 'D';
                        }elseif ($item->money_out != 0.00){
                            $item->trn_type = 'C';
                        }

                        if (!($item->save(false))) {

                            $transaction->rollBack();
                            $flag = 0;
                            break;
                        } else{
                            $flag = 1;
                        }

                    }

                }

                if ($flag == 1) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => 'You have successfully created a Journal entry',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);

                    return $this->redirect(['view', 'id' => $model->id]);
                }

            } catch (Exception $e) {
                $transaction->rollBack();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,'items' => (empty($items)) ? [new AgentJournalLine()] : $items
        ]);
    }

    /**
     * Updates an existing AgentJournalEntry model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
//    public function actionUpdate($id)
//    {
//        $model = $this->findModel($id);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        }
//
//        return $this->render('update', [
//            'model' => $model,
//        ]);
//    }

    public function actionUpdate($id)
    {

//        if(Yii::$app->user->can('createSponsorship')) {
        $model = $this->findModel($id);
        $items = $model->agentJournalLines;


        if($model->load(Yii::$app->request->post())){

            $oldIDs = ArrayHelper::map($items, 'id', 'id');
            $items = Model::createMultiple(AgentJournalLine::classname(), $items);
            Model::loadMultiple($items, Yii::$app->request->post());
            $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($items, 'id', 'id')));


            // ajax validation
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ArrayHelper::merge(
                    ActiveForm::validateMultiple($items),
                    ActiveForm::validate($items)
                );
            }

            $transaction = \Yii::$app->db->beginTransaction();
            // print_r($items);

            try
            {
                if ($model->save(false)) {
                    foreach ($items as $item) {
                        $item->journal_id = $model->id;
                        $item->branch_id = $model->branch_id;
                        $item->trn_dt = $model->trn_dt;
                        if($item->money_in != 0.00){
                            $item->trn_type = 'D';
                        }elseif ($item->money_out != 0.00){
                            $item->trn_type = 'C';
                        }

                        if (!($item->save(false))) {

                            $transaction->rollBack();
                            $flag = 0;
                            break;
                        } else{
                            $flag = 1;
                        }

                    }

                }

                if ($flag == 1) {
                    $transaction->commit();
                    Yii::$app->session->setFlash('', [
                        'type' => 'success',
                        'duration' => 3000,
                        'icon' => 'fa fa-success',
                        'message' => 'You have successfully created a Journal entry',
                        'positonY' => 'bottom',
                        'positonX' => 'right'
                    ]);

                    return $this->redirect(['view', 'id' => $model->id]);
                }

            } catch (Exception $e) {
                $transaction->rollBack();
            }

             return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,'items' => (empty($items)) ? [new AgentJournalLine()] : $items,
        ]);

    }



    //confirm the transaction to be posted in cash book
    public function actionConfirm($id)
    {
        $model = $this->findModel($id);
        $model->auth_stat = 'A';

        $agentTransactionsLines = AgentJournalLine::find()->where(['journal_id' => $model->id])->all();
        if($agentTransactionsLines != null) {
            $transaction = \Yii::$app->db->beginTransaction();
                try {
                    //$flag = 0;
                    $model->save();
                    foreach ($agentTransactionsLines as $line) {
                            $in = Account::UpdateMoneyIn($line->account_id, $line->money_in);
                            $out = Account::UpdateMoneyOut($line->account_id, $line->money_out);
                            if ($in != 1 || $out !=1) {
                                $transaction->rollBack();
                                Yii::$app->session->setFlash('', [
                                    'type' => 'danger',
                                    'duration' => 3000,
                                    'icon' => 'warning',
                                    'message' => 'Please check the account balance, or add float to '.$line->account->name,
                                    'positonY' => 'bottom',
                                    'positonX' => 'right'
                                ]);
                                return $this->redirect(['view', 'id' => $model->id]);
                            }

                    }
                    if($in == 1 && $out == 1){

                        $transaction->commit();
                        Yii::$app->session->setFlash('', [
                            'type' => 'success',
                            'duration' => 3000,
                            'icon' => 'warning',
                            'message' => 'Successfully confirmed',
                            'positonY' => 'bottom',
                            'positonX' => 'right'
                        ]);
                        return $this->redirect(['view', 'id' => $model->id]);
                    }else{

                        $transaction->rollBack();
                        Yii::$app->session->setFlash('', [
                            'type' => 'danger',
                            'duration' => 3000,
                            'icon' => 'warning',
                            'message' => 'Failed',
                            'positonY' => 'bottom',
                            'positonX' => 'right'
                        ]);
                        return $this->redirect(['view', 'id' => $model->id]);
                    }

                } catch (Exception $ex) {
                    $transaction->rollBack();
                    return $this->redirect(['view', 'id' => $model->id]);

                }

            }
        else{
                Yii::$app->session->setFlash('', [
                    'type' => 'danger',
                    'duration' => 3000,
                    'icon' => 'warning',
                    'message' => 'Nothing to confirm',
                    'positonY' => 'bottom',
                    'positonX' => 'right'
                ]);
                return $this->redirect(['view', 'id' => $model->id]);
            }


    }

    /**
     * Deletes an existing AgentJournalEntry model.
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
     * Finds the AgentJournalEntry model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AgentJournalEntry the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AgentJournalEntry::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }
}
