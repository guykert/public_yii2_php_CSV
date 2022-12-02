<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Curso;
use common\models\MallaHorariaColegio;
use common\models\CursoAsignatura;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\TimePicker;
use kartik\checkbox\CheckboxX;
use common\models\MallaHorariaCurso;



/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Curso */
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
                $template2 = ' <div class="input-group">
                    <span class=""> <i class="fa fa-angle-right"></i>   {label} </span>
                    {input}
                </div>';// falta {hint}\n{error}
                $inputSize = '60';
                ?>

                    <div class="card">
                        <div class="card-header">
                            <i class="icon-note"></i> 'Mantenedor de Curso'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Curso, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">

                                <div class="col-md-6">

                                    
                                    <?=  $form->field($model, 'curso_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Curso::getCursosColegioCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Curso', 'id'=>'id_curso'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?> 



                                </div>

                                <div class="col-md-6">


                                    


                                    <?= Html::hiddenInput('profesor_id', $profesor->id); ?>

                                    <?= Html::hiddenInput('asignatura_id_selected', $model->asignatura_id, ['id'=>'asignatura_id_selected']);?> 

                                    <?= $form->field($model, 'asignatura_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_curso'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/profesor/asignatura']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Asignatura',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['asignatura_id_selected']
                                                
                                            ],
                                        ])->label('Asignatura');
                                    ?>  
                                    

                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton($model->isNewRecord ? 'Crear <i class=\"iconomantenedor fa fa-plus\"></i>' : 'Modificar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>

                            <?php

                                if(!$model->isNewRecord){
                                    echo Html::a('Eliminar', ['delete-horario-profesor', 'id' => $model->id], [
                                        'class' => 'btn btn-danger',
                                        'data' => [
                                            'confirm' => '¿Realmente quieres eliminar el registro ?',
                                            'method' => 'post',
                                        ],
                                    ]);
                                }


                            ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>




