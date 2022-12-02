
<aside class="main-sidebar">

    <section class="sidebar">

        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="<?= $directoryAsset ?>/img/user2-160x160.jpg" class="img-circle" alt="User Image"/>
            </div>
            <div class="pull-left info">
                <p><?= Yii::$app->user->identity->nombre.' '. Yii::$app->user->identity->apellido_paterno ?></p>
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
                'options' => ['class' => 'sidebar-menu tree', 'data-widget'=> 'tree'],
                'items' => [
                    
                    ['label' => 'Accesos', 'options' => ['class' => 'header']],
                    ['label' => 'Usuario', 'icon' => 'file-code-o', 'url' => ['/usuario']],

                    // [
                    //     'label' => 'Contacto',
                    //     'icon' => 'address-book',
                    //     'url' => '/contacto',
                    //     'items' => [
                    //         [
                    //             'label' => 'Consultas',
                    //             'icon' => 'envelope-o',
                    //             'url' => ['/mailbox'],
                    //             'template'=>'<a href="{url}">  {icon} {label}<span class="pull-right-container"><small class="label label-warning">'.Yii::$app->session->get('mensajes')['mensajes_sr'].'</small></span></a>'
                    //         ],
                    //         [
                    //             'label' => 'Historial',
                    //             'icon' => 'history',
                    //             'url' => ['/mailbox'],
                    //             'template'=>'<a href="{url}">  {icon} {label}<span class="pull-right-container"><small class="label label-success">'.Yii::$app->session->get('mensajes')['mensajes_cr'].'</small></span></a>'
                    //         ],
                    //     ],
                    // ],
                    ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii']],
                    ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug']],
                    ['label' => 'Login', 'url' => ['site/login'], 'visible' => Yii::$app->user->isGuest],
                    [
                        'label' => 'Some tools',
                        'icon' => 'share',
                        'url' => '#',
                        'items' => [
                            ['label' => 'Gii', 'icon' => 'file-code-o', 'url' => ['/gii'],],
                            ['label' => 'Debug', 'icon' => 'dashboard', 'url' => ['/debug'],],
                            [
                                'label' => 'Level One',
                                'icon' => 'circle-o',
                                'url' => '#',
                                'items' => [
                                    ['label' => 'Level Two', 'icon' => 'circle-o', 'url' => '#',],
                                    [
                                        'label' => 'Level Two',
                                        'icon' => 'circle-o',
                                        'url' => '#',
                                        'items' => [
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                            ['label' => 'Level Three', 'icon' => 'circle-o', 'url' => '#',],
                                        ],
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
