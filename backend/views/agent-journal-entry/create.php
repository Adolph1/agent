<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\AgentJournalEntry */
/* @var $items backend\models\AgentJournalLine */

$this->title = Yii::t('app', 'Money Transfer Form');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Agent Entries'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
?>
<div class="agent-journal-entry-create">

    <?= $this->render('_form', [
        'model' => $model, 'items' => $items
    ]) ?>

</div>
