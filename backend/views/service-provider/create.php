<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ServiceProvider */

$this->title = Yii::t('app', 'Create Provider');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Service Providers'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="service-provider-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
