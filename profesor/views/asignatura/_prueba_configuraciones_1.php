<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Ramo;
use kartik\widgets\FileInput;
use common\models\PruebaCategoria;

use common\models\PaginaAlumno;
use common\models\PruebaFormulaNota;
use kartik\widgets\DateTimePicker;

?>
    <div class="fondo-form col-md-12">
        <div class="materiales-form">
            <?php $form = ActiveForm::begin(
                    [
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                    ]
                    
                ); 
            $template = ' 
            <div>{label}</div>

                        {input}
                    ';// falta {hint}\n{error}
                $inputSize = '20';


            
            ?>  



        <div class="card">
            
            <div class="card-headermorado content-center">

                <div class="row">

                    <div class="col-md-10">
                        <h5> Configuraciones Adicionales</h5>
                    </div>

                </div>

            </div>


            <div class="card-body" id="resultado_ajax">

        
                <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                <div class="row col-md-12 quitar-padding">
                    <div class="col-md-6">

                        <?=  $form->field($model, 'prueba_categoria_id',['template' => $template])->widget(Select2::classname(), [
                            'data' => PruebaCategoria::getCategoria(),
                            'language' => 'es',
                            'value' => 'red', // initial value
                            'options' => ['placeholder' => 'Seleccione Categoría', 'id'=>'id_categoria_prueba'],
                            'pluginOptions' => [
                            'allowClear' => true,

                            ],
                        ])->label('<h6><i class="fa fa-caret-right "></i> Categoria</h6>',['class'=>'label-class']);?>

                        <?php echo $form->field($model, 'fecha_mostrar_prueba')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Seleccione la fecha'],
                            'readonly' => true,
                            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,

                                'format' => 'yyyy-mm-dd hh:ii:ss'
                            ]
                        ])->label('<h6><i class="fa fa-caret-right "></i> Fecha Mostrar Prueba</h6>',['class'=>'label-class']);?>

                        <?= $form->field($model, 'cantidad_intentos')->textInput(['maxlength' => true])->label('<h6><i class="fa fa-caret-right "></i> Cantidad de Intentos</h6>',['class'=>'label-class']) ?>

                    </div>
                    <div class="col-md-6">

                        <?= $form->field($model, 'cantidad_minutos')->textInput()->label('<h6><i class="fa fa-caret-right "></i> Cantidad de Minutos</h6>',['class'=>'label-class']) ?>

                        <!-- <?=  $form->field($model, 'pagina_alumno_id',['template' => $template])->widget(Select2::classname(), [
                            'data' => PaginaAlumno::getActivoPaginaAlumno(),
                            'language' => 'es',
                            'value' => 'red', // initial value
                            'options' => ['placeholder' => 'Seleccione Página Alumno', 'id'=>'id_pagina_alumno'],
                            'pluginOptions' => [
                                'allowClear' => true,

                            ],
                        ])->label('<h6><i class="fa fa-caret-right "></i> Sección despliegue</h6>',['class'=>'label-class']);?>

                        <?= Html::hiddenInput('pagina_alumno_area_id_selected', $model->pagina_alumno_area_id, ['id'=>'pagina_alumno_area_id_selected']); ?> 

                        <?= $form->field($model, 'pagina_alumno_area_id',['template' => $template])->widget(DepDrop::classname(), [
                                'type'=>DepDrop::TYPE_SELECT2,
                                'language' => 'es',
                                'pluginOptions' => [
                                    // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                    'depends'=>['id_pagina_alumno'],
                                    /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                    'url'=>Url::to(['/asignatura/pagina-alumno-area']),
                                    // Para definir si el campo está actibo o no
                                    'initialize'=>true,
                                    // valor por defecto si está nulo
                                    'placeholder' => 'Seleccione Página Alumno Area',
                                    // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                    'params'=>['pagina_alumno_area_id_selected']
                                    
                                ],
                            ])->label('<h6><i class="fa fa-caret-right "></i> Sección despliegue</h6>',['class'=>'label-class']);
                        ?> -->

                        <?php echo $form->field($model, 'fecha_terminar_prueba')->widget(DateTimePicker::classname(), [
                            'options' => ['placeholder' => 'Seleccione la fecha'],
                            'readonly' => true,
                            'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                            'pluginOptions' => [
                                'autoclose' => true,

                                'format' => 'yyyy-mm-dd hh:ii:ss'
                            ]
                        ])->label('<h6><i class="fa fa-caret-right "></i> Fecha Terminar Prueba</h6>',['class'=>'label-class']);?>

                    </div>

                </div>



                


                
            </div>

            <div class="card-footer ">

                <?= Html::submitButton('<i class="fa fa-check "></i> Finalizar', ['class' => 'btn btnfinalizar1 float-right']) ?>

            </div>

            <?php ActiveForm::end(); ?>
    


        </div>

    </div>
</div>