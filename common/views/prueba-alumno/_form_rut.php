<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Prueba;
use kartik\widgets\Select2;

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


                                    <?= $form->field($model, 'rut')->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-md-6">

                                    <?=  $form->field($model, 'prueba_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Prueba::getPruebasColegioSearch(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Colegio', 'id'=>'id_empresa'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?>

                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton('Continuar <i class=\"iconomantenedor fa fa-plus\"></i>', ['btn btn-success btn-flat']) ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


