<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;
use kartik\tabs\TabsX;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Alumno */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Alumnos', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
/*genera los botones update y delete */
?>


<main class="main">
        <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
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

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  MANTENEDOR DE PRUEBAS</div>
                            <div>

                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '??Realmente quieres eliminar el registro ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>

                            </div>

                        </div>
                        <div class="card-body">
                            En esta parte podr??s ver la informaci??n que tiene asignada el id

                            <div class="espacio-chico"></div>

                            <?= DetailView::widget([
                                'model' => $model,

                                'options'=>[
                                    'class' => 'table colortabalfondo table-bordered detail-view'
                                ],

                                'attributes' => [
                                

                                    'rut',
                                    'nombre',
                                    'apellido_paterno',
                                    'apellido_materno',
                                    'sexo.nombre',
                                    'edad',
                                    'email:email',
                                    'telefono1',
                                    'colegio.empresa.nombre',
                           ],
                            ]) ?>


                            <?php 

                                $cursos =  $this->render('cursos', [
                                        'model' => $model,
                                        'cursos' => $Cursos,
                                    ]);

                                $items = [
                                    [
                                        'label'=>'<i class="glyphicon glyphicon-home"></i> Cursos',
                                        'content'=>$cursos,
                                        'active'=>true
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


