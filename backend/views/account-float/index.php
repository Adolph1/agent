<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\AccountFloatSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Account Floats');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-float-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

           // 'id',
            [
                'attribute' => 'branch_id',
                'value' => function($model){
                    return $model->branch->name;
                }
            ],
            'trn_dt',
            [
                'attribute' => 'account_id',
                'value' => function($model){
                    return $model->account->name;
                }
            ],
            [
                'attribute' => 'float_amount',
                'format' => ['decimal',2]
            ],
            [
                'attribute' => 'status',
                'value' => function($model){
                    if($model->status == 0){
                        return 'Pending';
                    }else{
                        return 'Posted';
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
    ]); ?>

    <?php Pjax::end(); ?>

</div>
