<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AgentJournalEntry */
/* @var $items backend\models\AgentJournalLine */

$this->title = Yii::t('app', 'Update Agent Journal Entry: {name}', [
    'name' => $model->id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agent Journal Entries'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
//$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="agent-journal-entry-update">

    <?= $this->render('_form', [
        'model' => $model, 'items' => $items
    ]) ?>

</div>
