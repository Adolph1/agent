<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text text-center font-weight-light" style="margin-left: 50px">WAKALA MMS</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">


        <!-- SidebarSearch Form -->
        <!-- href be escaped -->
        <!-- <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div> -->

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <?php
            echo \hail812\adminlte\widgets\Menu::widget([
                'items' => [
                    ['label' => 'Dashboard', 'url' => ['site/index'], 'icon' => 'tachometer-alt'],

                    [
                        'visible' => Yii::$app->user->can('viewBranches'),
                        "label" => "My Branches",
                        "url" => ["/branch"],
                        "icon" => "fa fa-building",
                    ],
                    [
                        'visible' => Yii::$app->user->can('viewAccounts'),
                        "label" => "My Accounts",
                        "url" => ["/account"],
                        "icon" => "fa fa-building",
                    ],
                    [
                        'visible' => Yii::$app->user->can('viewAgents'),
                        "label" => "My Agents",
                        "url" => ["/agent"],
                        "icon" => "fa fa-building",
                    ],

                    [
                        //'visible' => Yii::$app->User->can('createBranch'),
                        "label" => "Transactions",
                        "icon" => "fa fa-building",
                        'items' => [
                            [

                                "label" => "Post Transaction",
                                "url" => ["/cash-book/create"],
                                "icon" => "fa fa-file",
                            ],

                            [

                                "label" => "Transactions",
                                "url" => ["/cash-book"],
                                "icon" => "fa fa-folder",
                            ],

                            ],
                        ],

                    [
                        //'visible' => Yii::$app->User->can('createBranch'),
                        "label" => "Floats",
                        "icon" => "fa fa-building",
                        'items' => [

                                [

                                    "label" => "Add Float",
                                    "url" => ["/account-float/create"],
                                    "icon" => "fa fa-file",
                                ],

                                [

                                    "label" => "Float Transactions",
                                    "url" => ["/account-float"],
                                    "icon" => "fa fa-folder",
                                ],

                    ],
                    ],
                    [
                        //'visible' => Yii::$app->User->can('createBranch'),
                        "label" => "Internal Transfer",
                        "icon" => "fa fa-building",
                        'items' => [

                            [

                                "label" => "Transfer",
                                "url" => ["/money-transfer/create"],
                                "icon" => "fa fa-file",
                            ],

                            [

                                "label" => "Transfer history",
                                "url" => ["/money-transfer"],
                                "icon" => "fa fa-folder",
                            ],

                        ],
                    ],
                    [
                        //'visible' => Yii::$app->User->can('createBranch'),
                        "label" => "Agent Money Transfer",
                        "icon" => "fa fa-building",
                        'items' => [

                            [

                                "label" => "Transfer",
                                "url" => ["/agent-journal-entry/create"],
                                "icon" => "fa fa-file",
                            ],

                            [

                                "label" => "Transfer history",
                                "url" => ["/agent-journal-entry"],
                                "icon" => "fa fa-folder",
                            ],

                        ],
                    ],
                    [
                        'visible' => Yii::$app->user->can('viewProviders'),
                        "label" => "Service Providers",
                        "url" => ["/service-provider"],
                        "icon" => "fa fa-building",
                    ],
                    [
                        'visible' => Yii::$app->user->can('createService'),
                        "label" => "Services Types",
                        "url" => ["/service-type"],
                        "icon" => "fa fa-building",
                    ],


                    [
                        'label' => 'System',
                        'icon' => 'fas fa-cogs',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            [
                                'visible' => Yii::$app->user->can( 'admin'),
                                "label" => "Companies",
                                "url" => ["/company"],
                                "icon" => "fa fa-building",
                            ],



                            [
                                'visible' => Yii::$app->user->can('admin'),
                                "label" => "Users",
                                "url" => ["/user"],
                                "icon" => "fa fa-user",
                            ],

                            [
                                'visible' => Yii::$app->user->can('admin'),
                                'label' => Yii::t('app', 'Manager Permissions'),
                                'url' => ['/auth-item/index'],
                                'icon' => 'fa fa-lock',
                            ],
                            [
                                'visible' => (Yii::$app->user->identity->username == 'admin'),
                                'label' => Yii::t('app', 'Manage User Roles'),
                                'url' => ['/role/index'],
                                'icon' => 'fa fa-lock',
                            ],

                        ]
                    ],


                ],
            ]);
            ?>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>