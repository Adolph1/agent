<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\CashBookSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cash Transactions');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="cash-book-index">


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'trn_dt',
            //'branch_id',
            [
                'attribute' => 'product_id',
                'value' => function($model){
                    if($model->product_id == \backend\models\Product::DEPOSIT) {
                        return 'DEPOSIT';
                    }elseif ($model->product_id == \backend\models\Product::WITHDRAW){
                        return 'WITHDRAW';
                    }elseif ($model->product_id == \backend\models\Product::TRANSFER){
                        return 'TRANSFER';
                    }
                }
            ],
            [
                'attribute' => 'transaction_account_id',
                'label' => 'Account',
                'pageSummary' => 'Total',
                'value' => function($model){
                   return $model->account->name;
                }
            ],
            [
                'attribute' => 'transaction_amount',
                'label' => 'Amount',
                'pageSummary' => true,
                'format' => ['decimal',2],
            ],
            'description',
            'period',
            'year',
            'maker',
            //'maker_time',
            //'trn_stat',

            [
                'class' => 'yii\grid\ActionColumn',
                'header' => 'Actions',
                'template' => '{view}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        $url = ['view', 'id' => $model->id];
                        return Html::a('<span class="fas fa fa-money">View</span>', $url, [
                            'title' => 'Transfers',
                            'data-toggle' => 'tooltip', 'data-original-title' => 'Save',
                            'class' => 'btn btn-success',

                        ]);


                    },


                ]
            ]
        ],
        'showPageSummary' => true
    ]); ?>

    <?php Pjax::end(); ?>

</div>
