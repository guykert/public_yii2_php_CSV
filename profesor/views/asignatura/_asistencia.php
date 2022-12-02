<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Ramo;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use common\models\Nivel;
use common\models\Letra;
use common\models\Empresa;
use yii\helpers\ArrayHelper;
use kartik\popover\PopoverX;
use kartik\widgets\SwitchInput;


/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Curso */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/
?>
<div class="container-fluid">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">

                    <div class="card">
                        <div class="cabeceradecurso">

                            <div class="row">
                                <div class="col-md-9">
                                    <h5>Curso : <?= $model['nombre_curso'];?>  -  Asignatura : <?= $model['nombre_sub_ramo'];?> <div class="card-actions"></h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="float-right">
                                    
                                        

                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="card-body">
                            <div class="card-deck">

                                <div class="card">
                                    <div class="card-headermorado content-center">

                                        <div class="row">

                                            <div class="col-md-10">
                                                <h5> Asistencia</h5>
                                            </div>

                                        </div>

                                    </div>
                                    
                                    <div class="card-body" id="resultado_ajax">

                                        <?= $this->render('_asistencia_todos', [
                                            'model' => $model,
                                            'Alumnos' => $Alumnos,
                                            'fecha' => $fecha,
                                            'Asistencia' => $Asistencia,
                                            'asistencia_botton' => $asistencia_botton,
                                        ]) ?>

                                    </div>

                                    <div class="card-footer">

                                        <?= Html::a('Volver', ['/asignatura','id' => $model["id"],'fecha' => $fecha], ['class' => 'btn btnprimario1']);?>
                                    </div>
                                    
                                </div>


                            </div>

                        </div>


                        
                    </div>
                    <br>


            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


 

