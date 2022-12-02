<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Dia;
use common\models\MallaHorariaColegio;
use common\models\CursoAsignatura;
use common\models\SubRamo;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\TimePicker;
use kartik\checkbox\CheckboxX;
use common\models\MallaHorariaCurso;



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
                $template2 = ' <div class="input-group">
                    <span class=""> <i class="fa fa-angle-right"></i>   {label} </span>
                    {input}
                </div>';// falta {hint}\n{error}
                $inputSize = '60';
                ?>

                    <div class="card">
                        <div class="card-header">
                            <i class="icon-note"></i> 'Mantenedor de Curso'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Curso, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">

                                <div class="col-md-6">

                                    
                                    <?=  $form->field($model, 'dia_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Dia::getDiaCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Día', 'id'=>'id_dia'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 

                                    <?php
                                    
                                        if($MallaHorariaCurso > 0){
                                            echo $form->field($model, 'horarios_anteriores',['template' => $template])->widget(Select2::classname(), [
                                                'data' => MallaHorariaCurso::getHorariosAnterioresCombo(),
                                                'language' => 'es',
                                                'value' => 'red', // initial value
                                                'options' => ['placeholder' => 'Seleccione Asignatura', 'id'=>'id_horario_anterior'],
                                                'pluginOptions' => [
                                                    'allowClear' => true,
    
                                                ],
                                            ]);
                                        }

                                    ?> 

                                    <?= '<div class="form-group field-hora_desde required"><label>Hora Desde</label>' ?>
                                    <?= TimePicker::widget([
                                            'name' => 'hora_desde',
                                            'id' => 'hora_desde_timepicker_',
                                            //'disabled' => true,
                                            'value' => date('h:i', strtotime($model->hora_desde)),
                                            'pluginOptions' => [
                                                'showMeridian' => false,
                                            ]
                                        ]); 
                                    ?>

                                    <?= '</div>'  ?>
                                    
                                    <?= '<div class="form-group field-hora_hasta required"><label>Hora Hasta</label>' ?>
                                    <?= TimePicker::widget([
                                            'name' => 'hora_hasta',
                                            'id' => 'hora_hasta_timepicker_',
                                            //'disabled' => true,
                                            'value' => date('h:i', strtotime($model->hora_hasta)),
                                            'pluginOptions' => [
                                                'showMeridian' => false,
                                            ]
                                        ]); ?>
                                    <br>

                                    <?= '</div>'  ?>

                                </div>

                                <div class="col-md-6">

                                    <?=  $form->field($model, 'asignatura_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => SubRamo::getSubRamoCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Asignatura', 'id'=>'id_curso'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 

                                    
                                    <?= $form->field($model, 'usar_bloques')->checkbox() ?>

                                    <?=  $form->field($model, 'malla_horaria_colegio_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => MallaHorariaColegio::getMallaCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Malla', 'id'=>'id_malla'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 

                                    <?= Html::hiddenInput('curso_id', $curso->id); ?>

                                    <?= Html::hiddenInput('bloque_id_selected', $model->bloque_id, ['id'=>'bloque_id_selected']);?> 

                                    <?= $form->field($model, 'bloque_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_malla'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/curso/bloque']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Bloque',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['bloque_id_selected']
                                                
                                            ],
                                        ])->label('Bloque');
                                    ?>  
                                    

                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton($model->isNewRecord ? 'Crear <i class=\"iconomantenedor fa fa-plus\"></i>' : 'Guardar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>

                            <?php

                                if(!$model->isNewRecord){
                                    echo Html::a('Eliminar', ['delete-horario-curso', 'id' => $model->id, 'curso_id' => $curso_id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => '¿Realmente quieres eliminar el registro ?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }


                            ?>




                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>



<?php 

$usar_bloques_text = "";

if($model->usar_bloques == 1){

    $usar_bloques_text = "
    
        $('.field-id_malla').show();

        $('.field-mallahorariacurso-bloque_id').show();

        $('.field-hora_desde').hide();

        $('.field-hora_hasta').hide();

        $('input[name=\"MallaHorariaCurso[usar_bloques]\"]').val(1);
    
    ";

}

$texto_script = "

    $('.field-id_malla').hide();

    $('.field-mallahorariacurso-bloque_id').hide();

    " . $usar_bloques_text . "

    $('input[id=\"mallahorariacurso-usar_bloques\"]').change(function(e) {


        if( $(this).prop('checked') ) {

            
            $('.field-id_malla').show();

            $('.field-mallahorariacurso-bloque_id').show();

            $('.field-hora_desde').hide();

            $('.field-hora_hasta').hide();

            $('input[name=\"MallaHorariaCurso[usar_bloques]\"]').val(1);
        
        }else{

            $('.field-id_malla').hide();

            $('.field-mallahorariacurso-bloque_id').hide();

            $('.field-hora_desde').show();

            $('.field-hora_hasta').show();

            $('input[name=\"MallaHorariaCurso[usar_bloques]\"]').val(0);
            
        }

    });

    $('#id_horario_anterior').change(function() {
        if($('#id_horario_anterior').val() > 0){ 
            $('.field-hora_desde').hide();
            $('.field-hora_hasta').hide();
        }else{
            $('.field-hora_desde').show();
            $('.field-hora_hasta').show();
        }


    });




";

$this->registerJs($texto_script);

?>
