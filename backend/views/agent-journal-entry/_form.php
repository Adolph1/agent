<?php

use yii\helpers\Html;
use kartik\select2\Select2;
use wbraganca\dynamicform\DynamicFormWidget;
use kartik\form\ActiveForm;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $model backend\models\AgentJournalEntry */
/* @var $items backend\models\AgentJournalLine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="agent-journal-entry-form">

    <?php $form = ActiveForm::begin(['id' => 'dynamic-form']); ?>
    <div class="row">
        <div class="col-sm-2">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Save') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-info' : 'btn btn-info']) ?>

            <?= Html::a(Yii::t('app', 'Cancel'), ['index'], ['class' => 'btn btn-warning']) ?>
        </div>
    </div>
    <hr>
    <div class="card-purple">
        <div class="card-header">Money Transfer Form</div>
        <div class="card-body">
                <div class="row">
                    <div class="col-md-1">
                        Agent
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, "agent_id")->widget(Select2::classname(), [
                            'data' => \backend\models\Agent::getAll(),
                            'language' => 'en',
                            'options' => ['prompt' => '--Select--'],
                            'pluginOptions' => [
                                'allowClear' => true
                            ],
                        ])->label(false);?>

                    </div>
                    <div class="col-md-2 text-right">
                        Order Date
                    </div>
                    <div class="col-md-4">
                        <?= $form->field($model, "trn_dt")->widget(DatePicker::ClassName(),
                            [
                                //'name' => 'purchase_date',
                                //'value' => date('d-M-Y', strtotime('+2 days')),
                                'options' => ['placeholder' => 'Enter date'],

                                'pluginOptions' => [
                                    'format' => 'yyyy-mm-dd',
                                    'todayHighlight' => true,
                                    'autoclose'=>true,
                                ]
                            ])->label(false);?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-1">
                        Branch
                    </div>
                    <div class="col-md-5">
                        <?= $form->field($model, "branch_id")->widget(Select2::classname(), [
                            'data' => \backend\models\Branch::getMyBranches(),
                            'language' => 'en',
                            'options' => ['prompt' => '--Select--'],
                            'pluginOptions' => [
                                'allowClear' => true,
                            ],
                        ])->label(false);?>

                    </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-5 text-right">
                        <?= $form->field($model, 'receipt')->fileInput(['maxlength' => true]) ?>

                    </div>
                </div>
                <hr/>
                <div class="row">
                    <div class="col-md-12">

                        <?php
                        DynamicFormWidget::begin([

                            'widgetContainer' => 'dynamicform_wrapper', // required: only alphanumeric characters plus "_" [A-Za-z0-9_]
                            'widgetBody' => '.container-items', // required: css class selector
                            'widgetItem' => '.item', // required: css class
                            'limit' => 500, // the maximum times, an element can be cloned (default 999)
                            'min' => 1, // 0 or 1 (default 1)
                            'insertButton' => '.add-item', // css class
                            'deleteButton' => '.remove-item', // css class
                            'model' => $items[0],
                            'formId' => 'dynamic-form',
                            'formFields' => [
                                'agent_id',
                                'branch_id',


                            ],
                        ]);
                        ?>

                        <div style="font-size: 0.85em"><!-- widgetContainer -->

                            <div>
                                <table class="container-items table table-striped">
                                    <thead >
                                    <tr>
                                        <th>Account</th>
                                        <th>Money In</th>
                                        <th>Money Out</th>

                                    </tr>

                                    </thead>


                                    <?php foreach ($items as $index=>$item): ?>


                                    <?php
                                    // necessary for update action.
                                    if (!$item->isNewRecord) {
                                        echo Html::activeHiddenInput($item, "[{$index}]id");
                                    }
                                    ?>
                                    <tbody>
                                    <tr class="item">

                                        <td>
                                            <?= $form->field($item, "[{$index}]account_id")->dropDownList(\backend\models\Account::getAll(),['prompt' => '--Account--'])->label(false) ?></td>
                                        <td><?= $form->field($item, "[{$index}]money_in")->textInput(['maxlength' => true,'options' => ['class' => 'col-sm-1'],'placeholder' => '','onkeyup' => 'totales($(this))',])->label(false) ?></td>
                                        <td><?= $form->field($item, "[{$index}]money_out")->textInput(['maxlength' => true,['options' => ['border'=> 'none']],'placeholder' => '','onkeyup' => 'totales($(this))',])->label(false) ?></td>

                                        <td colspan="3">
                                            <button type="button" class="add-item btn-xs text-blue"><i class="fa fa-plus"></i></button>
                                            <button type="button" class="remove-item btn-xs text-red"><i class="fa fa-minus"></i></button>
                                        </td>




                                    </tr>



                                    <?php endforeach; ?>

                                    </tbody>
                                </table>
                                <?php DynamicFormWidget::end(); ?>


                                    <div class="row">
                                        <div class="col-md-4 text-right">Total</div>
                                        <div class="col-md-4"><?= $form->field($model, 'total_money_in')->textInput(['maxlength' => true,'readonly' => 'readonly']) ?></div>
                                        <div class="col-md-4"><?= $form->field($model, 'total_money_out')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?></div>

                                    </div>

                            </div>



                        </div>
                    </div>


                </div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>

<script>
    function totales(item){
        var total_amount = 0;
        var tax_amount = 0;
        var index  = item.attr("id").replace(/[^0-9.]/g, "");
        var money_in = $('#agentjournalline-' + index + '-money_in').val();
        money_in = money_in == "" ? 0 : Number(money_in.split(",").join(""));
        var money_out = $('#agentjournalline-' + index + '-money_out').val();
        money_out = money_out == "" ? 0 : Number(money_out.split(",").join(""));

        id = 0;
        sumMoneyIn = 0;
        sumMoneyOut = 0;
        exist = true;
        while(exist){
            var idFull = "agentjournalline-"+id+"-money_in";
            var idFullTax = "agentjournalline-"+id+"-money_out";
            try{
                campo = document.getElementById(idFull);
                if(document.getElementById(idFull).value!=""){
                    sumMoneyIn = sumMoneyIn + parseInt(document.getElementById(idFull).value);
                }
                if(document.getElementById(idFullTax).value!=""){
                    sumMoneyOut = sumMoneyOut + parseInt(document.getElementById(idFullTax).value);
                }
                id = id+1;
            }catch(e){
                exist = false;
            }
        }
        document.getElementById("agentjournalentry-total_money_out").value=sumMoneyOut;
        document.getElementById("agentjournalentry-total_money_in").value=sumMoneyIn;




    }


</script>
