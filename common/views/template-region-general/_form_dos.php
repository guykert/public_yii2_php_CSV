<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Template;


/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\TemplateRegionGeneral */
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
                            <i class="icon-note"></i> 'Mantenedor de Template Region General'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">
                        'En este mantenedor podrás administrar los Template Region General, modificarlos o eliminarlos'                            <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->


                            <div class="row">

                                <div class="col-md-12">

                                    <!-- <img src="<?= '/admin/img/uploads/templates/' . $Template->imagen;?>" id="image_template" style='width: 800px;height: 1100;' alt="admin@bootstrapmaster.com"> -->
                                    

                                    <?= \newerton\jcrop\jCrop::widget([
                                        // Image URL
                                        'url' => '/admin/img/uploads/templates/' . $Template->imagen,
                                        // options for the IMG element
                                        'imageOptions' => [
                                            'id' => 'imageId',
                                            'width' => 800,
                                            'height' => 1100,
                                            'alt' => 'Crop this image'
                                        ],
                                        // Jcrop options (see Jcrop documentation [http://deepliquid.com/content/Jcrop_Manual.html])
                                        'jsOptions' => array(
                                            'minSize' => [10, 10],
                                            // 'aspectRatio' => 2,
                                            'onRelease' => new yii\web\JsExpression("function() {ejcrop_cancelCrop(this);}"),
                                            //customization
                                            'bgColor' => '#FF0000',
                                            'bgOpacity' => 0.4,
                                            'selection' => true,
                                            'theme' => 'light',
                                        ),
                                        // if this array is empty, buttons will not be added
                                        'buttons' => array(
                                            'start' => array(
                                                'label' => 'Adjust thumbnail cropping',
                                                'htmlOptions' => array(
                                                    'class' => 'myClass',
                                                    'style' => 'color:red;'
                                                )
                                            ),
                                            'crop' => array(
                                                'label' => 'Apply cropping',
                                            ),
                                            'cancel' => array(
                                                'label' => 'Cancel cropping'
                                            )
                                        ),
                                        // URL to send request to (unused if no buttons)
                                        'ajaxUrl' => 'guardar-imagen',
                                        // Additional parameters to send to the AJAX call (unused if no buttons)
                                        'ajaxParams' => ['id_template_general' => $id_template_general,'id_template' => $Template->id],
                                    ]); ?>


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


