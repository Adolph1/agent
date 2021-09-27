<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <span class="brand-text text-center font-weight-light" style="margin-left: 50px">AGENT</span>
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
                        'label' => 'Subscribers management',
                        'icon' => 'user',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'New Subscriber', 'url' => ['subscriber/create'], 'icon' => ''],
                            ['label' => 'Subscribers List', 'url' => ['subscriber/index'], 'icon' => ''],
                        ]
                    ],
                    [
                        'label' => 'Sales agents management',
                        'icon' => 'user',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'New Agent', 'url' => ['sales-agent/create'], 'icon' => ''],
                            ['label' => 'Agents List', 'url' => ['sales-agent/index'], 'icon' => ''],
                        ]
                    ],


                    [
                        'label' => 'System',
                        'icon' => 'fas fa-cogs',
                        'badge' => '<span class="right badge badge-info"></span>',
                        'items' => [
                            ['label' => 'User', 'url' => ['user/index'], 'icon' => 'user-friends'],
                            ['label' => 'Service Types', 'url' => ['service-type/index'], 'icon' => 'address-card'],

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