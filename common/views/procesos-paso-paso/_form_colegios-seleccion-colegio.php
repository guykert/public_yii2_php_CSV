<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2; 
use common\models\Configuracion;
use kartik\widgets\FileInput;
use yii\helpers\Url;
use common\models\Empresa;

/* @var $this yii\web\View */
/* @var $model common\models\Configuracion */
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
                            <i class="icon-note"></i> <?php echo $this->title ?><div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                            Al seleccionaer un colegio se asignará este colegio como predeterminado a tú colegio para que sigas con las configuraciones<hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">



                                    <?php 

                                        echo $form->field($model, 'colegio_predeterminada',['template' => $template])->widget(Select2::classname(), [
                                            'data' => Empresa::getColegiosCombo(),
                                            'language' => 'es',
                                            'value' => 'red', // initial value
                                            'options' => ['placeholder' => 'Seleccione Colegio'],
                                            'pluginOptions' => [
                                                'placeholder' => 'Seleccione Colegio',

                                            ],
                                        ]);

                                    ?>




                                </div>
                                <div class="col-md-6">

                                </div>
                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <div class="row justify-content-between">
                                <div class="col-4">
                                    <?= Html::submitButton('Seleccionar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>
                                </div>
                                <div class="col-4">
                                    <?= Html::a(' Nuevo <i class="iconomantenedor fa fa-arrow-right"></i>', ['nuevo-colegio'], ['class'=>'btn btn-blue ',' style'=>'color:#fff;']) ?>
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


