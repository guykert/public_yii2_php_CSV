<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Sexo;
use common\models\Empresa;
use common\models\Nivel;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Alumno */
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
                            <i class="icon-note"></i> 'Mantenedor de Alumno'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Alumno, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">


                                    <!-- creo combobox con widget para un mejor diseño y le agrego la data de $Sede -->
                                    <?=  $form->field($model, 'colegio_origen_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Empresa::getColegiosCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Colegio Origen', 'id'=>'id_empresa_origen'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?> 


                                </div>

                                <div class="col-md-6">

                                    <?= Html::hiddenInput('malla_horaria_id_selected', $model->malla_horaria_id, ['id'=>'malla_horaria_id_selected']); ?> 

                                    <?= $form->field($model, 'malla_horaria_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_empresa_origen'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/malla-horaria-clonar/mallas']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Malla',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['malla_horaria_id_selected']
                                                
                                            ],
                                        ]);
                                    ?> 

                                </div>

                                <div class="col-md-6">


                                                                       <!-- creo combobox con widget para un mejor diseño y le agrego la data de $Sede -->
                                   <?=  $form->field($model, 'colegio_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Empresa::getColegiosCombo(),
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


