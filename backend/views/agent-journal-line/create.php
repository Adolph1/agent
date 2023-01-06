<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AgentJournalLine */

$this->title = Yii::t('app', 'Create Agent Journal Line');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agent Journal Lines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-journal-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
