<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?php echo Yii::$app->user->identity->adminname?></p>

                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search..."/>
              <span class="input-group-btn">
                <button type='submit' name='search' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->

        <?= dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => [
                    ['label' => 'Control Page', 'options' => ['class' => 'header']],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Function',
                        'icon' => 'dashboard',
                        'url' => '#',
                        'items' => [
                            [
                                'label' => 'Admin Controller' , 'url' => '#', 'icon' => 'dashboard',
                                'items' => [
                                        [ 'label' => 'Admin List', 'icon' => 'circle-o', 'url' => ['/admin/index']],
                                        [ 'label' => 'Add Admin', 'icon' => 'circle-o', 'url' => ['/admin/add']],
                                    ],
                                ],
  
                            [
                                'label' => 'User Controller', 'icon' => 'dashboard', 'url' => "#",
                                'items' => [
                                   [ 'label' => 'User List', 'icon' => 'circle-o', 'url' => ['/user/index']],
                                ]
                            ],
                            [
                                'label' => 'Package Controller', 'icon' => 'dashboard', 'url' => '#',
                                'items' => [
                                    ['label' => 'Package List', 'icon' => 'circle-o', 'url' => ['/package/index']],
                                    [ 'label' => 'Add Package', 'icon' => 'circle-o', 'url' => ['/package/add']],
                                ],
                            ],
                            [
                                'label' => 'User Controller', 'icon' => 'dashboard', 'url' => '#',
                                'items' => [
                                    ['label' => 'User List', 'icon' => 'circle-o', 'url' => ['/user/index']],
                                    [ 'label' => 'Add User Parcel', 'icon' => 'circle-o', 'url' => ['/user/user-parcel']],
                                ],
                            ],
                            [
                                'label' => 'Voucher Controller' , 'icon' => 'dashboard' ,'url' => '#',
                                'items' => [
                                    ['label' => 'Vouchers List' ,'icon' => 'circle-o' , 'url' => ['/vouchers/index'],
                                    ],
                                ],
                            ],
                            [
                                'label' => 'Auth Controller' , 'icon' => 'gamepad' ,'url' => '#',
                                'items' => [
                                    ['label' => 'Auth List' ,'icon' => 'circle-o' , 'url' => ['auth/index'],
                                    ],
                                ],
                            ],
                            
                        ],
                    ],
                ],
            ]
        ) ?>

    </section>

</aside>
