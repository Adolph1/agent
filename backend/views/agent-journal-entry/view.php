<?php

use kartik\date\DatePicker;
use kartik\form\ActiveForm;
use kartik\number\NumberControl;
use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap4\Modal;

/* @var $this yii\web\View */
/* @var $model backend\models\AgentJournalEntry */

$this->title = 'Transferred amount: ' .Yii::$app->formatter->asDecimal($model->total_money_out,2);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Purchase Orders'), 'url' => ['index']];
//$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="purchase-order-view">


    <?php
    if($model->auth_stat == 'U') {
        echo Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ])
            .' '.
            Html::a(Yii::t('app', 'Confirm'), ['confirm', 'id' => $model->id], [
                'class' => 'btn btn-warning',
                'data' => [
                    'confirm' => Yii::t('app', 'Are you sure you want to confirm this item?'),
                    'method' => 'post',
                ],
            ]);
        echo ' ';
        echo Html::a(Yii::t('app', 'Edit'), ['update', 'id' => $model->id], [
            'class' => 'btn btn-primary',
        ]);
    }?>
    <hr/>
    <div id="agent-journal-entry">
        <hr/>
        <div class="row">
            <div class="col-md-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        //'id',
                        [
                            'attribute' => 'agent_id',
                            'value' => function($model){
                                return $model->agent->name;
                            }
                        ],
                        'trn_dt',
                    ],
                ]) ?>
            </div>
            <div class="col-md-6">
                <?= DetailView::widget([
                    'model' => $model,
                    'attributes' => [
                        [
                            'attribute' => 'branch_id',
                            'value' => function($model){
                                return $model->branch->name;
                            }
                        ],
                        [
                                'attribute' => 'total_money_out',
                                'format' => ['decimal',2]

                        ],


                    ],
                ]) ?>
            </div>
        </div>
        <hr/>
        <table class="table table-bordered">
            <thead style="background: darkgrey">
            <tr>
                <th>#</th>
                <th>Account</th>
                <th>Money In</th>
                <th>Money Out</th>
            </tr>

            </thead>
            <tbody>
            <?php
            $items = \backend\models\AgentJournalLine::find()->where(['journal_id' => $model->id])->all();
            $fmt = Yii::$app->formatter;
            if($items != null){
                $i=1;
                foreach ($items as $item){
                    echo '<tr>
                      <td>'.$i.'</td>
                      <td>'.$item->account->name.'('.$item->account->branch->name.')</td>
                      <td>'.$fmt->asDecimal($item->money_in,2).'</td>
       
                      <td>'.$fmt->asDecimal($item->money_out,2).'</td>
                  
              

                    </tr>';
                    $i++;
                }
            }
            ?>
            <tr style="background: #dee2e6">
                <td colspan="2"></td>
                <th class="text-right">Total Money In:</th>
                <th><?= $fmt->asDecimal($model->total_money_in,2) ?></th>

            </tr>
            <tr  style="background: #dee2e6">
                <td colspan="2"></td>
                <th class="text-right">Total Money Out:</th>
                <th><?= $fmt->asDecimal($model->total_money_out,2) ?></th>

            </tr>
            <tr  style="background: #dee2e6">
                <td colspan="2"></td>
                <th class="text-right">Difference:</th>
                <th ><?= $fmt->asDecimal($model->total_money_out - $model->total_money_in,2) ?></th>

            </tr>
            </tbody>
        </table>
    </div>
</div>
