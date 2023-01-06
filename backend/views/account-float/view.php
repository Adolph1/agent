<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountFloat */

$this->title = 'Float Amount:'. Yii::$app->formatter->asDecimal($model->float_amount,2);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Floats'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="account-float-view">

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
                    'confirm' => Yii::t('app', 'Are you sure you want to confirm this transaction?'),
                    'method' => 'post',
                ],
            ]) ?>
        <?php
        }
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
           // 'id',
            'trn_dt',
            [
                    'attribute' => 'account_id',
                    'value' => function($model){
                        return $model->account->name;
                    }
            ],

            'float_amount',

        ],
    ]) ?>

</div>
