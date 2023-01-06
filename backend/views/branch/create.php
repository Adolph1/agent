<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Branch */
/* @var $user backend\models\User */

$this->title = Yii::t('app', 'New Branch');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Branches'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="branch-create">

    <?= $this->render('_form', [
        'model' => $model, 'user' => $user,
    ]) ?>

</div>
