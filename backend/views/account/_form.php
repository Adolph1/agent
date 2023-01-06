<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Account */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-purple">
        <div class="card-header">Account Form</div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'agent_no')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'service_provider_id')->dropDownList(\backend\models\ServiceProvider::getAll(),['prompt' => '--Select--']) ?>
                </div>
                <div class="col-md-6">

                    <?= $form->field($model, 'branch_id')->dropDownList(\backend\models\Branch::getMyBranches(),['prompt' => '--Select--']) ?>

                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'initial_balance')->textInput(['maxlength' => true]) ?>


                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'is_cash_account')->checkbox(['maxlength' => true])->label('Is cash account?') ?>
                    <?= $form->field($model, 'company_id')->hiddenInput(['value' => \backend\models\User::myCompanyID()])->label(false) ?>


                </div>
            </div>
            <div class="row">
                <div class="col-md-2">
            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
            </div>
                </div>
            </div>
        </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
