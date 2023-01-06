<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MoneyTransfer */

$this->title = Yii::t('app', 'Money Transfer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Money Transfers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="money-transfer-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
