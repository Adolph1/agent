<?php

use backend\models\User;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */
/* @var $user backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="branch-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-primary">
        <div class="card-header">Branch Form</div>
        <div class="card-body">
            <h4>Branch Details</h4>
            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'initial_balance')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-md-6">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
    <?= $form->field($model, 'location')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'company_id')->hiddenInput(['value' => User::myCompanyID()])->label(false) ?>
    <h4>Branch Manager Details</h4>
            <?php if($model->isNewRecord || $model->branch_manager == 0){?>
            <div class="row">
                <div class="col-md-6">
    <?= $form->field($user, 'full_name')->textInput(['maxlength' => 255]) ?>
                </div>
                <div class="col-md-6">
    <?= $form->field($user, 'username')->textInput(['maxlength' => 255]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
    <?= $form->field($user, 'password')->passwordInput(['maxlength' => 255]) ?>
                </div>
                <div class="col-md-6">
    <?= $form->field($user, 'repassword')->passwordInput(['maxlength' => 255]) ?>
                </div>
            </div>
    <?= $form->field($user, 'role')->hiddenInput(['value' => 'BranchManager','readonly' => 'readyonly'])->label(false) ?>
   <?= $form->field($user, 'company_id')->hiddenInput(['value' => User::myCompanyID()])->label(false) ?>

<?php
}
?>


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
