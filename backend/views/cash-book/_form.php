<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\CashBook */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="cash-book-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="card-purple">
        <div class="card-header">Transaction Post Form</div>
        <div class="card-body">

    <?= $form->field($model, 'branch_id')->hiddenInput(['value' => \backend\models\Branch::getMyBranchId()])->label(false) ?>

    <div class="row">
        <div class="col-md-6">
    <?= $form->field($model, 'product_id')->dropDownList(\backend\models\Product::getArrayStatus(),['prompt' => '--Select--']) ?>

        </div>
        <div class="col-md-6">
    <?= $form->field($model, 'trn_dt')->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Enter date','value' => date('Y-m-d')],
        'pluginOptions' => [
            'autoclose'=>true,
            'format' => 'yyyy-mm-dd'
        ]
    ])->label('Transaction Date');?>
        </div>
    </div>

            <div class="row">
                <div class="col-md-6">
                    <?= $form->field($model, 'transaction_account_id')->dropDownList(\backend\models\Account::getMyAccount(),['prompt' => '--Select--']) ?>

                </div>
                <div class="col-md-6">
    <?= $form->field($model, 'transaction_amount')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>

<div class="row">
    <div class="col-md-9"></div>
    <div class="col-md-3">
    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-block btn-success']) ?>
    </div>
    </div>
</div>
    <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
