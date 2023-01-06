<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\Account */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Accounts'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
//\yii\web\YiiAsset::register($this);
?>
<div class="account-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
         //   'id',
            'name',
            'account_no',
            'agent_no',
            [
                'attribute' => 'service_provider_id',
                'value' => function($model){
                    return $model->provider->name;
                }
            ],
            [
                'attribute' => 'company_id',
                'value' => function($model){
                    return $model->company->name;
                }
            ],
            [
                'attribute' => 'branch_id',
                'value' => function($model){
                    return $model->branch->name;
                }
            ],
            'initial_balance',
            [
                'attribute' => 'is_cash_account',
                'value' => function ($model) {
                    if ($model->is_cash_account == 0) {
                        return 'No';
                    } elseif ($model->is_cash_account == 1) {
                        return 'Yes';
                    }
                }
            ],

            'maker',
            'maker_time',
        ],
    ]) ?>

</div>
