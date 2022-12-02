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
                            <i class="icon-note"></i> Perfil del Usuario<div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                            Podras modificar tú información<hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    <?= $form->field($model, 'password',['template' => $template])->passwordInput(['maxlength' => true,'size'=>$inputSize]) ?>

                                    <?php 
                                    if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'cambioDeAnio')){


                                        echo $form->field($model, 'anio_predeterminado',['template' => $template])->widget(Select2::classname(), [
                                            'data' => Configuracion::getAnio(),
                                            'language' => 'es',
                                            'value' => 'red', // initial value
                                            'options' => ['placeholder' => 'Seleccione Año'],
                                            'pluginOptions' => [
                                                'placeholder' => 'Seleccione Año',

                                            ],
                                        ]);

                                    }



                                    



                                    ?>

                                    <?php 


                                        if(count($cantidadColegiosUsuario ) > 0){


                                            echo $form->field($model, 'colegio_predeterminada',['template' => $template])->widget(Select2::classname(), [
                                                'data' => Empresa::getColegiosAsignadosUsuarioCombo(Yii::$app->user->identity->id),
                                                'language' => 'es',
                                                'value' => 'red', // initial value
                                                'options' => ['placeholder' => 'Seleccione Año'],
                                                'pluginOptions' => [
                                                    'placeholder' => 'Seleccione Año',

                                                ],
                                            ]);

                                        }


                                    ?>

                                    <?php 


                                    if(Yii::$app->user->identity->image_name != ""){

                                        ?>
                                            <img src="<?php echo  Url::to(['/imagenes', 'ruta' => Yii::$app->user->identity->image_name, 'tipo_imagen' => 'personal']) ; ?>" class="img-avatar" alt="admin@bootstrapmaster.com">
                                        <?php

                                    }


                                    ?>


                                </div>
                                <div class="col-md-6">

                                    <?= $form->field($model, 'password_repeat',['template' => $template])->passwordInput(['maxlength' => true,'size'=>$inputSize]) ?>


                                    <?php 

                                        // display the image uploaded or show a placeholder
                                        // you can also use this code below in your `view.php` file
                                        $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';



                                        // your fileinput widget for single file upload
                                        echo $form->field($model, 'image')->widget(FileInput::classname(), [
                                            'options'=>['accept'=>'image/*'],
                                            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
                                        ]);


                                    ?>



                                </div>
                            </div>
                            
                        </div>

                        <div class="card-footer">

                            <?= Html::submitButton('Modificar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>

                        </div>
                        
                    </div>

                <?php ActiveForm::end(); ?>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>


