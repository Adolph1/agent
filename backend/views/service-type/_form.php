<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\ServiceType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="service-type-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-purple">
        <div class="card-header">New Float Form</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
