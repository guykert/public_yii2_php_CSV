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
                           <?php echo  $model->nombre; ?>                       <hr>
                            <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->


                            <div class="row">

                                <div class="col-md-12">


                                    <?= \newerton\jcrop\jCrop::widget([
                                        // Image URL
                                        'url' => '/admin/img/uploads/templates/' . $TemplateRegion->imagen,
                                        // options for the IMG element
                                        'imageOptions' => [
                                            'id' => 'imageId',
                                            'width' => $width,
                                            'height' => $height,
                                            'alt' => 'Crop this image'
                                        ],
                                        // Jcrop options (see Jcrop documentation [http://deepliquid.com/content/Jcrop_Manual.html])
                                        'jsOptions' => array(
                                            'minSize' => [5, 1],
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
                                        'ajaxParams' => ['id_sub_region' => $id_sub_region,'id_region' => $TemplateRegion->id],
                                    ]); ?>


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


<?php

    if($x != ""){
        $this->registerJs("

            $(\"#imageId_x\").val(" . $x . ");
            $(\"#imageId_y\").val(" . $y . ");
            $(\"#imageId_w\").val(" . $w . ");
            $(\"#imageId_h\").val(" . $h . ");
            $(\"#imageId_x2\").val(" . $x2 . ");
            $(\"#imageId_y2\").val(" . $y2 . ");

        ");
    }




?>