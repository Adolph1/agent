<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Accounts');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-index">

    <p>
        <?= Html::a(Yii::t('app', 'Create Account'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            //'id',
            'name',
            'account_no',
            'agent_no',
            [
                'attribute' => 'service_provider_id',
                'value' => function($model){
                    return $model->provider->name;
                }
            ],
            [
                'attribute' => 'company_id',
                'value' => function($model){
                    return $model->company->name;
                }
            ],
            [
                'attribute' => 'branch_id',
                'pageSummary'=>'Total',
                'value' => function($model){
                    return $model->branch->name;
                }
            ],
            [
                    'attribute' => 'initial_balance',
                    'pageSummary'=>true,
                    'format' => ['decimal',2]
            ],

            [
                'attribute' => 'is_cash_account',
                'value' => function ($model) {
                    if ($model->is_cash_account == 0) {
                        return 'No';
                    } elseif ($model->is_cash_account == 1) {
                        return 'Yes';
                    }
                }
            ],
            //'maker',
            //'maker_time',

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
        'showPageSummary' => true,
    ]); ?>

    <?php Pjax::end(); ?>

</div>
