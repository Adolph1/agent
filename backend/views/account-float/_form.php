<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountFloat */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="account-float-form">

    <?php $form = ActiveForm::begin(); ?>
    <div class="card-purple">
        <div class="card-header">New Float Form</div>
        <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <?= $form->field($model, 'trn_dt')->widget(DatePicker::classname(), [
                    'options' => ['placeholder' => 'Enter date','value' => date('Y-m-d')],
                    'pluginOptions' => [
                        'autoclose'=>true,
                        'format' => 'yyyy-mm-dd'
                    ]
                ])->label('Transaction Date');?>
            </div>
            <div class="col-md-6">
                <?= $form->field($model, 'account_id')->dropDownList(\backend\models\Account::getMyAccount(),['prompt' => '--Select--']) ?>
            </div>
        </div>
            <div class="row">
                <div class="col-md-4">
                    <?= $form->field($model, 'float_amount')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-md-3">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
