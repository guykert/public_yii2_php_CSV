<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Sexo;
use common\models\Empresa;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\FileInput;
/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Alumno */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/


$model->prueba_id = $prueba_id;


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
                            <i class="icon-note"></i> 'Mantenedor de Pruebas'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'Este formulario es para subir el excel con la pauta de corrección'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    <?= $form->field($model, 'prueba_id')->hiddenInput()->label(false); ?>
                                                                       <!-- creo combobox con widget para un mejor diseño y le agrego la data de $Sede -->
                                    <?php

                                        echo $form->field($model, 'excel')
                                            ->widget(FileInput::classname(),
                                                    ['pluginOptions'=>['browseLabel' =>  'Buscar','removeLabel' =>  'Eliminar','uploadLabel' => 'Subir']])
                                            ->label('Cargar Base');

                                    ?>


                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton('Continuar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => 'btn btn-warning btn-flat']) ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


