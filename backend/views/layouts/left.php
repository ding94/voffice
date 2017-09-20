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
                    [   'label' => 'Admin Controller' , 'url' => '#', 'icon' => 'lock',
                        'items' =>  [
                                        [ 'label' => 'Admin List', 'icon' => 'circle-o', 'url' => ['/admin/index']],
                                    ],
                        'options' => ['class' => 'active'],
                        'visible'=> Yii::$app->user->can('admin/index'), 
                    ],
                    [   'label' => 'Banner Controller' , 'icon' => 'square' ,'url' => '#',
                        'items' =>  [
                                        ['label' => 'Banner List' ,'icon' => 'circle-o' , 'url' => ['/banner/index']],
                                        ['label' => 'Add Banner' ,'icon' => 'circle-o' , 'url' => ['/banner/addbanner']],
                                    ],
                        'options' => ['class' => 'active'],
                    ],
                    [   'label' => 'User Controller', 'icon' => 'user', 'url' => "#",
                        'items' =>  [
                                        [ 'label' => 'User List', 'icon' => 'circle-o', 'url' => ['/user/index']],
                                        [ 'label' => 'User Voucher', 'icon' => 'circle-o', 'url' => ['/user/uservoucherlist']],
                                    ],
                        'options' => ['class' => 'active'],
                        'visible'=> Yii::$app->user->can('user/index'), 
                    ],
                    [   'label' => 'Package Controller', 'icon' => 'dashboard', 'url' => '#',
                        'items' =>  [
                                        ['label' => 'Package List', 'icon' => 'circle-o', 'url' => ['/package/index']],
                                        [ 'label' => 'Add Package', 'icon' => 'circle-o', 'url' => ['/package/add']],
                                    ],
                        'options' => ['class' => 'active'],
                        'visible'=> Yii::$app->user->can('package/index'), 
                    ],
                    [   'label' => 'Voucher Controller' , 'icon' => 'dashboard' ,'url' => '#',
                        'items' =>  [
                                        ['label' => 'Vouchers List' ,'icon' => 'circle-o' , 'url' => ['/vouchers/index']],
                                    ],
                        'options' => ['class' => 'active'],
                        'visible'=> Yii::$app->user->can('vouchers/index'), 
                    
                    ],
					[   'label' => 'Finance Controller', 'icon' => 'money', 'url' => '#',
                        'items' =>  [
                                        ['label' => 'Offline Topup', 'icon' => 'circle-o', 'url' => ['/finance/topup/index']],
									    ['label' => 'User Withdraw', 'icon' => 'circle-o', 'url' => ['/finance/withdraw/index']],
                                    ],
                        'options' => ['class' => 'active'],
                        'visible'=> Yii::$app->user->can('topup/index'), 

                    ],
                    [   'label' => 'Logistic Controller', 'icon' => 'dashboard', 'url' => '#',
                        'items' =>  [
                                        ['label' => 'Add Mail', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/received-mail']],
                                        ['label' => 'Received Mail', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/type-mail' ,'status'=>1]],
                                        ['label' => 'Pending Pick Up', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/type-mail' ,'status'=>2]],
                                        ['label' => 'Sending Mail', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/type-mail' ,'status'=>3]],
                                        ['label' => 'Confirm received', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/type-mail' ,'status'=>4]],
                                        ['label' => 'Early postal', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/type-mail' ,'status'=>5]],
                                        ['label' => 'Pending early pickup', 'icon' => 'circle-o', 'url' => ['/logistics/parcel/type-mail' ,'status'=>6]],
                                    ],
                        'options' => ['class' => 'active'],
                        'visible'=> Yii::$app->user->can('parcel/type-mail'), 
                    ],
                    [   'label' => 'Auth Controller' , 'icon' => 'cog' ,'url' => '#',
                        'items' =>  [
                                        ['label' => 'Auth List' ,'icon' => 'circle-o' , 'url' => ['/auth/index']],
                                        ['label' => 'Permission List' ,'icon' => 'circle-o' , 'url' => ['/auth/permission']],
                                    ],
                        'options' => ['class' => 'active'],
                    ],
                            
                        
                ],
                
            ]
        ) ?>

    </section>

</aside>
