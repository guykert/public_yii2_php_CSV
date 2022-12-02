<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\Rol;
use kartik\tabs\TabsX;
use yii\widgets\Breadcrumbs;

use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = $model->nombre.' '.$model->apellido_paterno;
$this->params['breadcrumbs'][] = ['label' => 'Usuarios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$this->title = 'Ver Usuario';
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Usuarios",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n", 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];

?>

<main class="main">

    <?=  Breadcrumbs::widget([
        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => "<li class=\"breadcrumb-item\">{link}</li>\n", // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',
    ]) ?>

    <div class="container-fluid">

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="alineadototal">

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  Ver información del id</div>
                            <div>

                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '¿Realmente quieres eliminar el registro ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>

                            </div>

                        </div>
                        
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada el Rol
                            
                            <div class="espacio-chico"></div>

                            <?= DetailView::widget([
                                'options'=>[
                                    'class' => 'table colortabalfondo table-bordered detail-view'
                                ],
                                'model' => $model,
                                'attributes' => [
                                    'rut',
                                    'nombre',
                                    'apellido_paterno',
                                    'apellido_materno',
                                    'username',
                                    'email',
                                ],
                            ]) ?>


                            <br>

                            <?php 

                                $roles =  $this->render('roles', [
                                        'Roles' => $Roles,
                                        'model' => $model,
                                        'subRoles' => $subRoles,
                                    ]);

                                $templates =  $this->render('templates', [
                                    'Templates' => $Templates,
                                    'model' => $model,
                                ]);

                                $Empresa =  $this->render('empresa', [
                                    'Empresas' => $Empresas,
                                    'Corporaciones' => $Corporaciones,
                                    'Colegios' => $Colegios,
                                    'model' => $model,
                                ]);

                                $items = [
                                    [
                                        'label'=>'<i class="glyphicon glyphicon-home"></i> Roles',
                                        'content'=>$roles,
                                        'active'=>true
                                    ],
                                    [
                                        'label'=>'<i class="glyphicon glyphicon-home"></i> Templates',
                                        'content'=>$templates,
                                        'active'=>false
                                    ],

                                    [
                                        'label'=>'<i class="glyphicon glyphicon-home"></i> Empresa',
                                        'content'=>$Empresa,
                                        'active'=>false
                                    ],

                                ];
                                 ?>

                                <?= TabsX::widget([
                                    'items'=>$items,
                                    'position'=>TabsX::POS_ABOVE,
                                    'encodeLabels'=>false
                                ]);

                            ?>

                        </div>

                        <div class="card-footer">



                        </div>
                        
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>









</main>


