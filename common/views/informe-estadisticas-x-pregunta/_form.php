<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Nivel;
use common\models\Curso;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use common\models\Ramo;
use common\models\PruebaCategoria;
/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Dia */
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
                            <i class="icon-note"></i> 'Informe de Estadísticas por Pregunta'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En está página podrá descargar el Informe de Estadísticas por Pregunta'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    <?=  $form->field($model, 'nivel_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Nivel::getNivel(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Nivel', 'id'=>'id_nivel'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 

                                    <?=  $form->field($model, 'ramo_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Ramo::getRamoColegio(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Ramo', 'id'=>'id_ramo'],
                                        'pluginOptions' => [
                                        'placeholder' => 'Seleccione Ramo',

                                        ],
                                    ]);?>

                                </div>

                                <div class="col-md-6">

                                    <?= Html::hiddenInput('curso_id_selected', $model->curso_id, ['id'=>'curso_id_selected']); ?> 

                                    <?= $form->field($model, 'curso_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'options'=>['id'=>'id_curso'],
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_nivel'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/informe-estadisticas-x-pregunta/combo-curso']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Curso',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['curso_id_selected']
                                                
                                            ],
                                        ]);
                                    ?>

                                    <?=  $form->field($model, 'prueba_categoria_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => PruebaCategoria::getCategoria(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Categoría', 'id'=>'id_categoria_prueba'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                </div>

                                <div class="col-md-12">

                                    <?= Html::hiddenInput('prueba_id_selected', $model->prueba_id, ['id'=>'prueba_id_selected']); ?> 

                                    <?= $form->field($model, 'prueba_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_nivel','id_ramo','id_curso','id_categoria_prueba'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/informe-estadisticas-x-pregunta/prueba']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Prueba',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['prueba_id_selected']
                                                
                                            ],
                                        ]);
                                    ?>


                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton('Descargar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => 'btn btn-success btn-flat']) ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


