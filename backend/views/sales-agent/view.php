<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesAgent */

$this->title = $model->agent_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="sales-agent-view">


    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php
        if($model->status != 1) {
           echo Html::a(Yii::t('app', 'Confirm'), ['register', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to confirm this sales?'),
                    'method' => 'post',
                ],
            ]);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'agent_name',
            'agent_code',
            'mobile_number',
            'email_address:email',
            [
                    'attribute' => 'status',
                    'value' => function($model){
                        if($model->status == 1){
                            return 'REGISTERED';
                        } else{
                            return 'NOT REGISTERED';
                        }
                    }
            ]
        ],
    ]) ?>

</div>
