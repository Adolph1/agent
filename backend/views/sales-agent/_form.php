<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesAgent */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="sales-agent-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'agent_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'agent_code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'mobile_number')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'email_address')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
