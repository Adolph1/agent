<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Subscriber */

$this->title = $model->full_name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Subscribers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="subscriber-view">


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
            'id',
            'full_name',
            'date_of_birth',
            'service_type_id',
            'mobile_number',
            'email_address:email',
            'agent_code',
            'maker',
            'maker_time',
            'status',
        ],
    ]) ?>

</div>
