<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MoneyTransfer */

$this->title = Yii::t('app', 'Update Money Transfer: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Money Transfers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="money-transfer-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
