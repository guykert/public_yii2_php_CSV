<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Region;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Comuna */
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
                            <i class="icon-note"></i> 'Mantenedor de Comuna'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Comuna, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">

                                <div class="col-md-6">
                                    
                                    <!-- creo combobox con widget para un mejor diseño y le agrego la data de $Sede -->
                                    <?=  $form->field($model, 'region_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Region::getActivoRegiones(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Región', 'id'=>'id_region'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

                                </div>
                                <div class="col-md-6">

                                    <?= Html::hiddenInput('provincia_id_selected', $model->provincia_id, ['id'=>'provincia_id_selected']);?> 

                                    <?= $form->field($model, 'provincia_id',['template' => '<div class="input-group" id="div-provincia_id">
                                                <span class="input-group-addon"><i class="fa fa-angle-right"></i> {label}</span>
                                                {input}
                                            </div>'])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_region'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/comuna/provincia']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Provincia',
                                                
                                                'id'=>'id_curso_moodle',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['provincia_id_selected']
                                                
                                            ],
                                        ])->label('provincia_id');
                                    ?>

                                    <?= $form->field($model, 'provincia_id')->textInput(['maxlength' => true]) ?>

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


