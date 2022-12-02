<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PruebaAlumno */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Prueba Alumnos', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];

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
                        <div class="card-header">
                            <i class="icon-note"></i> Ver Prueba del Alumno
                            <div class="card-actions">
                            </div>
                        </div>
                        
                        <div class="card-body">
                            En esta sección se desplegará la información con las respuestas del alumno a la prueba                        <hr>



                            <div class="contenedor-tabla">

                                <table class=" table table-hover tabla-colored table-striped table-bordered">
                                    <thead class="tabla<?=$model->prueba->ramo->codigo;?>">
                                        <tr>
                                            <th class="centro">Pregunta</th>
                                            <th class="centro">Tu respuesta</th>
                                            <th class="centro">Respuesta correcta</th>
                                            <th class="centro"></th>
                                        </tr>
                                    </thead>
                                    <tbody class="tablapreguntas">

                                    <?php 

                                        foreach ($model->correctasVSRespuestas as $key => $pregunta) {
                                            $imagen = "Piloto";
                                            if($pregunta["resultado_pregunta"] == 'correcta'){
                                                $imagen = "fa-check buena";
                                            }
                                            if($pregunta["resultado_pregunta"] == 'incorrecta' || $pregunta["resultado_pregunta"] == 'mala'){
                                                $imagen = "fa-times mala";
                                            }
                                            if($pregunta["resultado_pregunta"] == 'omitida'){
                                                $imagen = "fa-minus mala";
                                            }

                                            ?>
                                                <tr>
                                                    <td><span class="numero"><?= $pregunta["numero_pregunta"];?></span></td>
                                                    <td><?= strtoupper($pregunta["respuesta_alumno"]);?></td>
                                                    <td><?= $pregunta['correcta'] ? strtoupper($pregunta["correcta"]) : 'Piloto' ;?></td>
                                                    <td><i class="fa <?= $imagen;?>"></i></td>
                                                </tr>
                                            <?php

                                        }

                                    ?>


                                    </tbody>
                                </table>



                            </div>

                            <div class="row">

                                <div class="col-md-3">
                                    <?= Html::a('Reiniciar', ['reiniciar', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3">

                                </div>
                                <div class="col-md-3">
                                    <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => 'Se eliminarán todas las respuestas del alumno?',
                                            'method' => 'post',
                                        ],
                                    ]) ?>
                                </div>

                            </div>

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


