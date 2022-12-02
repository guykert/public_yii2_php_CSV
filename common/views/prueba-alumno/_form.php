<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\PruebaAlumno */
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
                            <i class="icon-note"></i> 'Mantenedor de Prueba Alumno'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Prueba Alumno, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    
                                    <?= $form->field($model, 'sede_id')->textInput() ?>

                                    <?= $form->field($model, 'prueba_id')->textInput() ?>

                                    <?= $form->field($model, 'curso_id')->textInput() ?>

                                    <?= $form->field($model, 'rut')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'nota')->textInput() ?>

                                    <?= $form->field($model, 'buenas')->textInput() ?>

                                    <?= $form->field($model, 'malas')->textInput() ?>

                                    <?= $form->field($model, 'omitidas')->textInput() ?>

                                    <?= $form->field($model, 'fecha_termino')->textInput() ?>

                                    <?= $form->field($model, 'fecha_inicio')->textInput() ?>

                                    <?= $form->field($model, 'tiempo_pausa')->textInput() ?>

                                    <?= $form->field($model, 'fecha_pausa')->textInput() ?>

                                    <?= $form->field($model, 'detalle_malas')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'id_ensayo_desafio')->textInput() ?>

                                    <?= $form->field($model, 'id_tipo_desafio')->textInput() ?>

                                    <?= $form->field($model, 'observacion')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'mdl_quiz_id')->textInput() ?>

                                    <?= $form->field($model, 'mdl_attempt')->textInput() ?>

                                    <?= $form->field($model, 'empresa_id')->textInput() ?>

                                    <?= $form->field($model, 'neto')->textInput() ?>

                                    <?= $form->field($model, 'porcentaje_logro')->textInput() ?>

                                    <?= $form->field($model, 'nivel_logro')->textInput() ?>

                                    <?= $form->field($model, 'pond_buenas')->textInput() ?>

                                    <?= $form->field($model, 'pond_malas')->textInput() ?>

                                    <?= $form->field($model, 'pond_omitidas')->textInput() ?>

                                    <?= $form->field($model, 'preguntas_abiertas')->textInput() ?>

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


