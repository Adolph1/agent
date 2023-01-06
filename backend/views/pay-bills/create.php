<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\PayBills */

$this->title = Yii::t('app', 'Create Pay Bills');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Pay Bills'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pay-bills-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
