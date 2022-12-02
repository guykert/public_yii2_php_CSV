<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\FileInput;
use kartik\widgets\Select2;
use common\models\EmpresaTipo;
use yii\helpers\Url;

/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Empresa */
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
                            <i class="icon-note"></i> 'Mantenedor de Empresa'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Empresa, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                            <div class="row">
                                <div class="col-md-6">

                                    <?= $form->field($model, 'rut')->textInput(['maxlength' => true]) ?>
                                    
                                    <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

                                    <!-- creo combobox con widget para un mejor diseño y le agrego la data de $Sede -->
                                    <?=  $form->field($model, 'empresa_tipo_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => EmpresaTipo::getActivoTipoEmpresa(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Región', 'id'=>'id_region'],
                                        'pluginOptions' => [
                                            'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= $form->field($model, 'descripcion')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>



                                    <?php 

                                        // display the image uploaded or show a placeholder
                                        // you can also use this code below in your `view.php` file
                                        $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';

                                        if($model->imagen != ""){

                                            ?>
                                                <img src="<?php echo  Url::to(['/imagenes', 'ruta' => $model->imagen, 'tipo_imagen' => 'comun']) ; ?>" class="img-thumbnail" alt="<?=$title;?>"  title="<?=$title;?>">
                                            <?php

                                        }


                                        // your fileinput widget for single file upload
                                        echo $form->field($model, 'image')->widget(FileInput::classname(), [
                                            'options'=>['accept'=>'image/*'],
                                            'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png']]
                                        ]);


                                    ?>


                                </div>
                                <div class="col-md-6">

                                    <?= $form->field($model, 'rbd')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'sostenedor')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'director')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'encargadopw')->textInput(['maxlength' => true]) ?>

                                    <?= $form->field($model, 'telefonoepw')->textInput(['maxlength' => true]) ?>

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


