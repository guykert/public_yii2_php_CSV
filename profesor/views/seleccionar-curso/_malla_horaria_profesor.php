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
use kartik\widgets\DatePicker;
use common\models\Asistencia;

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
                    'id' => 'my-form-id',
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

    <?php


    echo $form->field($model, 'fecha',['template' => $template])->widget(DatePicker::classname(), [
        'options' => ['placeholder' => 'Seleccione la fecha'],
        'readonly' => true,
        'language' => 'es',
        'type' => DatePicker::TYPE_COMPONENT_APPEND,
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'yyyy-mm-dd',
            'endDate' => $FechasComponent->fecha_hoy

        ]
    ]);

    ?>



                    <br><br>

                    <div class="card">

                        
                        <div class="card-body">

                            <div class="table-responsive-xl">
                                <table class="table table-responsive-sm table-hover table-bordered mb-0 tabla-calendario">
                                    <thead class="thead-light">
                                    <tr>
                                        <th scope="col" class="text-left">Horario</th>

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
                                                        }else{
                                                            
                                                        }

                                                        ?>

                                                            <?php 

                                                                if(count($MatrizDias) == 0){
                                                                    
                                                                    ?>

                                                                        <td>

                                                                        </td>

                                                                    <?php

                                                                }else{



                                                                    foreach ($MatrizDias as $key => $MatrizDia) {

                                                                        $Asistencia = Asistencia::getConfirmarAsistenciaCursoAsignatura($MatrizDia["id"],$FechasComponent->array_fechas_semana[($MatrizDia["dia_id"] - 1)]);

                                                                        if($Asistencia){
                                                                            $clase = 'btn btn-success';
                                                                        }else{
                                                                            $clase = 'btn btn-warning';
                                                                        }



                                                                        echo '<td>';



                                                                        echo Html::a('<div class="cardhorariotop"><div class="cardhorario"><div class="nombreasignaturacard"><i class="fa fa-circle asignaturaicon">&nbsp;</i>&nbsp;'.$MatrizDia["nombre_sub_ramo"] . '</div><div class="bajadaasignaturacard">'.$MatrizDia["nombre_curso"] . '</div></div></div>', ['/asignatura','id' => $MatrizDia["id"],'curso_id' => $MatrizDia["curso_id"],'fecha'=>$FechasComponent->array_fechas_semana[($MatrizDia["dia_id"] - 1)]], []);
                                                                        echo '</td>';


                                                                        // echo PopoverX::widget([
                                                                        //     'header' => '<i class="glyphicon glyphicon-edit"></i> Rango de Hora  : ' . $MatrizDia["nombre_sub_ramo"],
                                                                        //     'placement' => $dia->id > 4 ? PopoverX::ALIGN_LEFT : PopoverX::ALIGN_RIGHT,
                                                                        //     'size' => PopoverX::SIZE_LARGE,
                                                                        //     'options' => [
                                                                        //         'id' => 'PopoverX_'.$horario[0]['id'].'_'.$dia->id,
                                                                        //     ],
                                                                        //     'content' => $this->render('_form_horario',array('id'=>$MatrizDia["id"],'model'=>$model,'bloque'=>$horario[0]['id'],'dia'=>$dia->id,'hora_desde'=>$horario[0]['hora_desde'],'hora_hasta'=>$horario[0]['hora_hasta'],'boton_limpiar'=>true), false, true),

                                                                        //     'toggleButton' => ['label'=>'<i class="fa fa-clock-o"></i> ' . $MatrizDia["nombre_sub_ramo"], 'class'=>'btngrisChico'],
                                                                        // ]);


                                                                    }

                                                                }



                                                            ?>

                                                        <?php 

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
                    <br>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>

<?php

$this->registerJs("

    /*esta funcion sirve para dibujar el datepicker al momento de seleccionar un día actualiza el horario y marca los cursos que tengan asistencia y esten ubicados en el mismo día con color verde
    tienen asistencia*/



    $(\"input[id='profesor-fecha']\").change(function(e){

        $('#my-form-id').submit();

    });



");

?>

