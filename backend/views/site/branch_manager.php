<?php

/* @var $this yii\web\View */

use backend\models\CashBookSearch;
use kartik\grid\GridView;

$this->title ='@'. \backend\models\Branch::myBranchName();
?>
<div class="site-index">

    <div class="row">
        <!-- /.col -->
        <div class="col-12 col-sm-8 col-md-8">


            <div class="card-purple">
                <div class="card-header">Today Transactions Summary</div>
                <div class="card-body">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>ACCOUNT NAME</th>
                            <th>TOTAL MONEY IN</th>
                            <th colspan="2" class="text-right">TOTAL MONEY OUT</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $accounts = \backend\models\Account::find()->where(['branch_id' => \backend\models\Branch::getMyBranchId()])->all();
                        if($accounts != null){
                            $i =1;
                            $sum = 0;
                            $withsum = 0;
                            $depsum = 0;
                            foreach ($accounts as $account){
                                $withdrawBalance =  \backend\models\CashBook::getTodayWithdrawByAccountID($account->id);
                                $depositBalance =  \backend\models\CashBook::getTodayDepositByAccountID($account->id);

                                ?>
                                <tr>
                                    <td><?= $i;?></td>
                                    <td><?= $account->name;?></td>
                                    <td><?= Yii::$app->formatter->asDecimal($depositBalance,2);?></td>
                                    <td colspan="2" class="text-right"><?= Yii::$app->formatter->asDecimal($withdrawBalance,2);?></td>


                                </tr>
                                <?php
                                $i++;
                                $withsum = $withsum + $withdrawBalance;
                                $depsum = $depsum + $depositBalance;

                            }

                        ?>
                        <tr>
                            <th colspan="2" class="text-right">ACCOUNTS TOTAL MONEY IN</th>
                            <th><?= Yii::$app->formatter->asDecimal($depsum,2);?></th>
                            <th class="text-right">ACCOUNTS TOTAL MONEY OUT</th>
                            <th class="text-right"><?= Yii::$app->formatter->asDecimal($withsum,2);?></th>
                        </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>


                </div>
            </div>
            <!-- /.info-box-content -->

            <!-- /.info-box -->

        </div>

        <div class="col-12 col-sm-4 col-md-4">


                <div class="card-orange">
                    <div class="card-header text-white">Account Balances</div>
                    <div class="card-body">
                        <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>ACCOUNT NAME</th>
                            <th>BALANCE</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $accounts = \backend\models\Account::find()->where(['branch_id' => \backend\models\Branch::getMyBranchId()])->all();
                        if($accounts != null){
                            $i =1;
                            $sum = 0;
                            foreach ($accounts as $account){
                        ?>
                        <tr>
                            <td><?= $i;?></td>
                            <td><?= $account->name;?></td>
                            <td><?= Yii::$app->formatter->asDecimal($account->initial_balance,2);?></td>
                        </tr>
                        <?php
                                $i++;
                                $sum = $sum + $account->initial_balance;
                            }

                        ?>
                        <tr>
                            <td></td>
                            <th class="text-right">Total</th>
                            <th><?= Yii::$app->formatter->asDecimal($sum,2);?></th>
                        </tr>
                            <?php
                        }
                        ?>
                        </tbody>

                    </table>


                    </div>
                </div>
                <!-- /.info-box-content -->

            <!-- /.info-box -->

        </div>

        <!-- /.col -->
    </div>



</div>
