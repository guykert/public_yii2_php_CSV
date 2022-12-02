<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2; 

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="container-fluid">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">

                <?php $form = ActiveForm::begin(); 
                $template =    '<div class="form-group">
                    <label class="col-form-label" for="firstname">{label}</label>
                    {input}
                </div>';// falta {hint}\n{error}
                $inputSize = '60';
                ?>

                    <div class="card">
                        <div class="card-header">
                            <i class="icon-note"></i> Mantenedor de Usuarios
                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                            En este mantenedor podrás administrar los usuarios de cada perfil, modificarlos o eliminarlos
                            <hr>
                            <?= $form->errorSummary($model, ['class' => 'alert alert-danger']) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Formulario</h6>

                                    <?= $form->field($model, 'rut',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'apellido_paterno',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'username',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'email',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>    

                                    <?= $form->field($model, 'telefono1',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'edad',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?> 

                                </div>

                                <div class="col-md-6">
                                    <h6>&nbsp;</h6>

                                    <?= $form->field($model, 'nombre',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'apellido_materno',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'password_hash',['template' => $template])->passwordInput(['size'=>$inputSize]); ?>
                                        
                                    <?= $form->field($model, 'email2',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?= $form->field($model, 'telefono2',['template' => $template])->textInput(['maxlength' => true,'size'=>$inputSize]) ?>
                                                    
                                </div>

                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton($model->isNewRecord ? 'Crear <i class="iconomantenedor fa fa-plus"></i>': '<i class="iconomantenedor fa fa-upload"></i> Modificar', ['class' =>  $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat' ]) ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


