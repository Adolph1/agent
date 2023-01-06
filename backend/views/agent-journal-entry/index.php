<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AgentJournalEntrySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Agent Entries');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-journal-entry-index">


    <p>
        <?= Html::a(Yii::t('app', 'Transfer Money'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'trn_dt',
            [
                'attribute' => 'agent_id',
                'value' => function($model){
                        return $model->agent->name;
                }
            ],
            [
                'attribute' => 'branch_id',
                'value' => function($model){
                    return $model->branch->name;
                }
            ],
            [
                    'attribute' => 'total_money_in',
                    'format' => ['decimal',2]
            ],
            [
                'attribute' => 'total_money_out',
                'format' => ['decimal',2]
            ],
            'maker_id',
            'maker_time',
            'auth_stat',
            //'is_reversed',
//            'checker_id',
//            'checker_time',

            ['class' => 'yii\grid\ActionColumn','header' => 'Actions'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
