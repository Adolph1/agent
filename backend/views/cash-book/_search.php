<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CashBookSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-book-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
        'options' => [
            'data-pjax' => 1
        ],
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'branch_id') ?>

    <?= $form->field($model, 'product_id') ?>

    <?= $form->field($model, 'product_code') ?>

    <?= $form->field($model, 'trn_dt') ?>

    <?php // echo $form->field($model, 'money_in_account') ?>

    <?php // echo $form->field($model, 'money_out_account') ?>

    <?php // echo $form->field($model, 'in_amount') ?>

    <?php // echo $form->field($model, 'out_amount') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'period') ?>

    <?php // echo $form->field($model, 'year') ?>

    <?php // echo $form->field($model, 'maker') ?>

    <?php // echo $form->field($model, 'maker_time') ?>

    <?php // echo $form->field($model, 'trn_stat') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
