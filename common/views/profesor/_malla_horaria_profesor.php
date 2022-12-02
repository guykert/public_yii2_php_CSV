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
                <?php $form = ActiveForm::begin(
                    [
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                    ]
                    
                );  
                
                $template =    '<div class="form-group">
                    <label class="col-form-label" for="firstname">{label}</label>
                    {input}
                </div>';// falta {hint}\n{error}
                $inputSize = '60';
                ?>

                    <div class="card">
                        <div class="card-header">
                            <i class="icon-note"></i> Malla Horaria Profesor                            <div class="card-actions">

                            </div>
                            <?= Html::a('Asignar Nuevo', ['asignar-asignatura-curso','id' => $model->id], ['class' => 'btn btn-success']) ?>

                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Curso, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                            
                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-responsive-sm table-hover table-bordered mb-0 tabla-calendario">

                                        <thead class="thead-light">
                                            <tr>
                                                <th class="text-left"> Horario</th>

                                                <?php 

                                                    foreach ($dias as $key => $dia) {

                                                        ?>

                                                            <th class="text-center">
                                                                <i class="fa fa-angle-right "></i> 
                                                                <?php echo $dia->nombre; ?>
                                                            </th>



                                                        <?php 

                                                    }

                                                ?>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            <?php




                                                $MallaHoraria = ArrayHelper::index($MallaHoraria,null, 'hora_desde');

                                                foreach ($MallaHoraria as $key => $horario) {

                                                    

                                                    ?>

                                                        <tr>

                                                            <td class="fondobloque">
                                                                <div class="titulocalendario">
                                                                    <i class="fa fa-calendar"></i> 
                                                                    <?php echo date('H:i', strtotime($horario[0]['hora_desde'])); ?> - <?php echo date('H:i', strtotime($horario[0]['hora_hasta'])) ?>
                                                                </div>
                                                            </td>

                                                            <?php 

                                                                $horario_dia = ArrayHelper::index($horario,null, 'dia_id');

                                                                foreach ($dias as $key => $dia) {

                                                                    $MatrizDias = [];
                                                                    if(ArrayHelper::keyExists($dia->id, $horario_dia, false)){
                                                                        $MatrizDias = $horario_dia[$dia->id];
                                                                    }


                                                                    if(count($MatrizDias) > 0){

                                                                        foreach ($MatrizDias as $key => $MatrizDia) {

                                                                            ?>

                                                                                <td>

                                                                                            <?php

                                                                                                echo Html::a('<div class="cardhorariotop"><div class="cardhorario"><div class="nombreasignaturacard"><i class="fa fa-circle asignaturaicon">&nbsp;</i>&nbsp;'.$MatrizDia["nombre_sub_ramo"] . '</div><div class="bajadaasignaturacard">'.$MatrizDia["nombre_curso"] . '</div></div></div>', ['update-horario-profesor','id_horario'=>$MatrizDia["id_maya_horaria"]], []);

                                                                                            ?>

                                                                                </td>

                                                                            <?php

                                                                        }

                                                                    }else{
                                                                        
                                                                        ?>

                                                                            <td>

                                                                            </td>

                                                                        <?php

                                                                    }

                                                                    
                                                                    
                                                                }

                                                            ?>


                                                        </tr>



                                                    <?php
                                                }

                                            ?>

                                        </tbody>

                                    </table>

                                </div>
                            </div>


                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


