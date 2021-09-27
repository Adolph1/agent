<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\SalesAgent */

$this->title = Yii::t('app', 'Create Sales Agent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Sales Agents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-agent-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
