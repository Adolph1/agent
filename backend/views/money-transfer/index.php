<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MoneyTransferSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Money Transfers');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-transfer-index">


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
                'attribute' => 'from_branch_id',
                'value' => function($model){
                    return $model->fromBranch->name;
                }
            ],
            [
                'attribute' => 'to_branch_id',
                'value' => function($model){
                    return $model->toBranch->name;
                }
            ],
            [
                'attribute' => 'amount',
                'format' => ['decimal',2]

            ],
            'description',
            'requested_by',
          //  'requested_time',
            'accepted_by',
           // 'accepted_time',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = ['money-transfer/view', 'id' => $model->id];
                        return Html::a('<span class="fas fa fa-money">View</span>', $url, [
                            'title' => 'Transfers',
                            'data-toggle' => 'tooltip', 'data-original-title' => 'Save',
                            'class' => 'btn btn-success',

                        ]);


                    },


                ]
            ]

        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
