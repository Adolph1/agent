<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Agent */

$this->title = Yii::t('app', 'New Agent');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agents'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
