<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\SalesAgentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Sales Agents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="sales-agent-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Sales Agent'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],


            'agent_name',
            'agent_code',
            'mobile_number',
            'email_address:email',


            ['class' => 'yii\grid\ActionColumn','header' => 'Actions'],
        ],
    ]); ?>

    <?php Pjax::end(); ?>

</div>
