<?php

/* @var $this yii\web\View */

$this->title = 'DASHBOARD';
?>
<div class="site-index">

    <div class="row">
        <!-- /.col -->
        <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box mb-6">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-building"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Stations</span>
                    <span class="info-box-number">
                        <?=
                        \backend\models\Station::getCountByUserCompanyId(Yii::$app->user->identity->company_id);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box mb-6">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-fas fa-poll-h"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Sales</span>
                    <span class="info-box-number">
                        <?=
                        \backend\models\Sales::getTotalSalesByCompanyId(Yii::$app->user->identity->company_id);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box mb-6">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-fas fa-poll-h"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Total Bonus</span>
                    <span class="info-box-number">
                        <?=
                        \backend\models\BonusCardTransaction::getTotalBonusByCompanyId(Yii::$app->user->identity->company_id);
                        ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>

        <!-- /.col -->
    </div>
    <div class="row" style="margin-top: 10px">

        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <div class="card">
                <div class="card-header border-0 bg-primary">
                    <h3 class="card-title">Today sales per product</h3>
                    <span>&nbsp;&nbsp;
                        <?php
                        $date1 = date("Y-m-d 07:00");
                        $date2 = date("Y-m-d H:i:s",strtotime($date1."+23 hours +59 minutes"));
                        // echo $date1;
                        // echo $date2;
                        //$date2;
                        echo $date2;
                        ?>
                    </span>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-valign-middle">
                        <thead>
                        <tr>
                            <th>S/N</th>
                            <th>PRODUCT</th>
                            <th>LITERS</th>
                            <th>AMOUNT</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $productGradeids = \frontend\models\Grade::find()->all();
                        $sum = 0.00;
                        if($productGradeids != null){
                            foreach ($productGradeids as $key => $value) {
                                echo '<tr>
                                    <td>'.$value["id"].'</td>
                                    <td>'.$value["name"].'</td>
                                    <td>'.Yii::$app->formatter->asDecimal(\frontend\models\Sales::getTodayTotalSoldVolumeByGradeId($value["id"]),2).'</td>
                                    <td>'.Yii::$app->formatter->asDecimal(\frontend\models\Sales::getTodayTotalSalesByGradeId($value["id"]),2).'</td>
                                    </tr>';
                                $sum =$sum + \frontend\models\Sales::getTodayTotalSalesByGradeId($value["id"]);

                            }
                        }
                        ?>

                        </tbody>
                        <tr class="bg-gradient-gray">
                            <th></th>
                            <th></th>
                            <th class="text-right">Total</th>
                            <th><?= Yii::$app->formatter->asDecimal($sum,2);?></th>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="row">
        <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
            <?php
            $products = \frontend\models\Grade::find()->all();
            $sales = array();
            $data = array();
            if($products != null){
                foreach ($products as $product){
                    $sales[] = [
                        'name' => $product->name,
                        'data' => \frontend\models\Sales::getMonthlySalesByProductId($product->id),
                    ];
                }
            }
            $item_key_data = array_keys($sales);
            $itemsArraySize = count($sales);

            for($i=0; $i< $itemsArraySize; $i++){
                $data[] = $sales[$i];
            }




            echo \dosamigos\highcharts\HighCharts::widget([
                'clientOptions' => [
                    'chart' => [
                        'type' => 'line'
                    ],
                    'title' => [
                        'text' => 'Monthly sales'
                    ],
                    'xAxis' => [
                        'categories' => [
                            'Jan',
                            'Feb',
                            'Mar',
                            'Apr',
                            'May',
                            'Jun',
                            'Jul',
                            'Aug',
                            'Sep',
                            'Oct',
                            'Nov',
                            'Dec',
                        ]
                    ],
                    'yAxis' => [
                        'title' => [
                            'text' =>'Total Amount'
                        ]
                    ],
                    'series' => $data
                ]
            ]);
            ?>
        </div>
    </div>



    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">

            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">

            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>



    </div>


</div>
