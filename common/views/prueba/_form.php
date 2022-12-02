<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\PruebaCategoria;
use common\models\Ramo;
use common\models\Prueba;
use yii\helpers\Url;
use kartik\widgets\DepDrop;
use common\models\Nivel;
use common\models\PaginaAlumno;
use common\models\PruebaFormulaNota;
use common\models\PruebaTablaConversion;
use kartik\widgets\DatePicker;
use kartik\widgets\DateTimePicker;

/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Prueba */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/
?>
<div class="container-fluid">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
                <?php $form = ActiveForm::begin(
                        [
                            'id' => 'signup-form',
                            // 'enableAjaxValidation' => true,
                            //'action' => Url::toRoute('user/ajaxregistration'),
                            // 'validationUrl' => Url::toRoute('prueba/')
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
                            <i class="icon-note"></i> 'Mantenedor de Prueba'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Prueba, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    <?=  $form->field($model, 'ramo_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Ramo::getRamoColegio(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Ramo', 'id'=>'id_ramo'],
                                        'pluginOptions' => [
                                        'placeholder' => 'Seleccione Ramo',

                                        ],
                                    ]);?>

                                    <?= Html::hiddenInput('sub_ramo_id_selected', $model->sub_ramo_id, ['id'=>'sub_ramo_id_selected']); ?> 

                                    <?= $form->field($model, 'sub_ramo_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_ramo'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/prueba/sub-ramo']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione SubRamo',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['sub_ramo_id_selected']
                                                
                                            ],
                                        ]);
                                    ?>
                                    
                                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

 

                                    <?=  $form->field($model, 'codigo',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Prueba::getNumero(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Código', 'id'=>'listacodigos'],
                                        'pluginOptions' => [
                                            'placeholder' => 'Seleccione Código',

                                        ],
                                    ]);?>

                                    <?=  $form->field($model, 'pagina_alumno_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => PaginaAlumno::getActivoPaginaAlumno(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Página Alumno', 'id'=>'id_pagina_alumno'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= Html::hiddenInput('pagina_alumno_area_id_selected', $model->pagina_alumno_area_id, ['id'=>'pagina_alumno_area_id_selected']); ?> 

                                    <?= $form->field($model, 'pagina_alumno_area_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_pagina_alumno'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/prueba/pagina-alumno-area']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Página Alumno Area',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['pagina_alumno_area_id_selected']
                                                
                                            ],
                                        ]);
                                    ?>

                                    <?=  $form->field($model, 'muestra_resultados_web',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Prueba::getCondisional(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?=  $form->field($model, 'formula_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => PruebaFormulaNota::getformula(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>


                                    <?=  $form->field($model, 'tabla_conversion_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => PruebaTablaConversion::gettabaConversion(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>


                                    <?= $form->field($model, 'tiempo')->textInput() ?>

                                    <?= $form->field($model, 'externo_id')->textInput() ?>	

                                    <?php echo $form->field($model, 'fecha_mostrar_prueba')->widget(DateTimePicker::classname(), [
                                        'options' => ['placeholder' => 'Seleccione la fecha'],
                                        'readonly' => true,
                                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'autoclose' => true,

                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                        ]
                                    ]);?>

                                    <?php echo $form->field($model, 'fecha_mostrar_solucionario')->widget(DateTimePicker::classname(), [
                                        'options' => ['placeholder' => 'Seleccione la fecha'],
                                        'readonly' => true,
                                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'autoclose' => true,

                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                        ]
                                    ]);?>

                                </div>
                                <div class="col-md-6">

                                    <?=  $form->field($model, 'prueba_categoria_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => PruebaCategoria::getCategoria(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Categoría', 'id'=>'id_categoria_prueba'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?=  $form->field($model, 'nivel_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Nivel::getNivel(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Nivel', 'id'=>'id_nivel'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 

                                    <?=  $form->field($model, 'migrar',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Prueba::getCondisional(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= $form->field($model, 'solucionario_teorico_id')->textInput() ?>

                                    <?= $form->field($model, 'solucionario_id')->textInput() ?>

                                    <?= $form->field($model, 'numero_preguntas')->textInput() ?>

                                    <?=  $form->field($model, 'mostrar_escaner',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Prueba::getCondisional(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?=  $form->field($model, 'migrar_pauta',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Prueba::getCondisional(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= $form->field($model, 'cantidad_minutos')->textInput() ?>

                                    <?= $form->field($model, 'cantidad_intentos')->textInput() ?>

                                    <?php echo $form->field($model, 'fecha_terminar_prueba')->widget(DateTimePicker::classname(), [
                                        'options' => ['placeholder' => 'Seleccione la fecha'],
                                        'readonly' => true,
                                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'autoclose' => true,

                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                        ]
                                    ]);?>

                                    <?php echo $form->field($model, 'fecha_terminar_solucionario')->widget(DateTimePicker::classname(), [
                                        'options' => ['placeholder' => 'Seleccione la fecha'],
                                        'readonly' => true,
                                        'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                                        'pluginOptions' => [
                                            'autoclose' => true,

                                            'format' => 'yyyy-mm-dd hh:ii:ss'
                                        ]
                                    ]);?>


                                </div>
                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton($model->isNewRecord ? 'Crear <i class=\"iconomantenedor fa fa-plus\"></i>' : 'Modificar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>

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

$texto_formula_id_show = "";
$texto_tabla_conversion_id_show = "";

if($model->formula_id){
    $texto_formula_id_show = "$('.field-prueba-formula_id').show();$('.field-prueba-tabla_conversion_id').hide();";
}

if($model->tabla_conversion_id){
    $texto_tabla_conversion_id_show = "$('.field-prueba-tabla_conversion_id').show();$('.field-prueba-formula_id').hide();";
}

$this->registerJs("

    " . $texto_formula_id_show  . "

    " . $texto_tabla_conversion_id_show  . "

    $('#prueba-formula_id').change(function() {
        

        if($(\"#prueba-formula_id option:selected\").val() == ''){
            $('.field-prueba-tabla_conversion_id').show();
        }

        if($(\"#prueba-formula_id option:selected\").val() > 0){
            $('.field-prueba-tabla_conversion_id').hide();
        }

    });

    $('#prueba-tabla_conversion_id').change(function() {
        

        if($(\"#prueba-tabla_conversion_id option:selected\").val() == ''){
            $('.field-prueba-formula_id').show();
        }

        if($(\"#prueba-tabla_conversion_id option:selected\").val() > 0){
            $('.field-prueba-formula_id').hide();
        }

    });

"); 

?>

