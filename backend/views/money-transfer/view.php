<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MoneyTransfer */

$this->title = 'Amount to transfer '.Yii::$app->formatter->asDecimal($model->amount,2);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Money Transfers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="money-transfer-view">


    <p>
        <?php
        if($model->status == 0){
        ?>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
            <?= Html::a(Yii::t('app', 'Confirm'), ['confirm', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to confirm this transfer?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php
        }elseif ($model->status == 1 && $model->to_branch_id == \backend\models\Branch::getMyBranchId()){
            echo Html::a(Yii::t('app', 'Accept Transfer'), ['accept', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to accept this transfer?'),
                    'method' => 'post',
                ],]);
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
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
            'requested_time',
            'accepted_by',
            'accepted_time',
        ],
    ]) ?>

</div>
