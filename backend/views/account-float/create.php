<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AccountFloat */

$this->title = Yii::t('app', 'Add Float');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Account Floats'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="account-float-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
