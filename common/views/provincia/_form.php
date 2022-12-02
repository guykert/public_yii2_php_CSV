<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Region;



/* @var $this yii\web\View */
/* @var $model common\models\Provincia */
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
                            <i class="icon-note"></i> 'Mantenedor de Provincia'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Provincia, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <!-- creo combobox con widget para un mejor diseño y le agrego la data de $Sede -->
                                    <?=  $form->field($model, 'region_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Region::getActivoRegiones(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Región'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-md-6">

                                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

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


