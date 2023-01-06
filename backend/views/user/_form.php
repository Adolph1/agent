<?php

use backend\models\User;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\ArrayHelper;



/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>

<div class="user-form">
    <div class="panel panel-primary">
        <div class="panel-heading">
            <?= Yii::t('app', 'User Form'); ?>
        </div>
        <div class="panel-body">


            <?= $form->field($model, 'full_name')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'username')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'repassword')->passwordInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'company_id')->dropDownList(\backend\models\Company::getAll(),['prompt' => '--Select--']) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

            <?= $form->field($model, 'role')->dropDownList(User::getArrayRole(),['prompt' => '--Select--']) ?>

            <?= $form->field($model, 'status')->dropDownList(User::getArrayStatus(),['prompt' => '--Select--']) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
