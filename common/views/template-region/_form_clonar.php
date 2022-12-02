<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Template;
use kartik\widgets\DepDrop;
use yii\helpers\Url;

/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\TemplateRegion */
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
                            <i class="icon-note"></i> 'Mantenedor de Template Region'                            <div class="card-actions">

                            </div>
                        </div>
                        
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-6">

                                    <?=  $form->field($model_principal, 'template_id',['template' => $template])->widget(Select2::classname(), [
                                        'data' => Template::getTemplateCombo(),
                                        'language' => 'es',
                                        'value' => 'red', // initial value
                                        'options' => ['placeholder' => 'Seleccione Categoría', 'id'=>'id_template'],
                                        'pluginOptions' => [
                                        'allowClear' => true,

                                        ],
                                    ]);?>

                                    <?= Html::hiddenInput('template_region_general_id_selected', $model_principal->template_region_general_id, ['id'=>'template_region_general_id_selected']); ?> 

                                    <?= $form->field($model_principal, 'template_region_general_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'options' => ['id'=>'id_template_region_general',],
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_template'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/template-region/region-general']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Region General',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['template_region_general_id_selected']
                                                
                                            ],
                                        ]);
                                    ?>

                                    <?= Html::hiddenInput('template_region_id_selected', $model_principal->template_region_id, ['id'=>'template_region_id_selected']); ?> 

                                    <?= $form->field($model_principal, 'template_region_id',['template' => $template])->widget(DepDrop::classname(), [
                                            'type'=>DepDrop::TYPE_SELECT2,
                                            'language' => 'es',
                                            'pluginOptions' => [
                                                // esta es la dependencia en la base de datos que tiene este campo con el valor anterior
                                                'depends'=>['id_template','id_template_region_general'],
                                                /* dirije a la acción al controlador y ejecuta la acción ActionSubRamo,en este caso se debe colocar en la llamada sub-ramo, la mayúscula se cambia por - */
                                                'url'=>Url::to(['/template-sub-region/region']),
                                                // Para definir si el campo está actibo o no
                                                'initialize'=>true,
                                                // valor por defecto si está nulo
                                                'placeholder' => 'Seleccione Region',
                                                // parametros que se enviarán en caso de que el combo ya tenga un dato seleccionado se obtiene del campo hidden definido anteriormente
                                                'params'=>['template_region_id_selected']
                                                
                                            ],
                                        ]);
                                    ?>


                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6">

                                <?= Html::submitButton($model_principal->isNewRecord ? 'Crear <i class=\"iconomantenedor fa fa-plus\"></i>' : 'Modificar <i class=\"iconomantenedor fa fa-plus\"></i>', ['class' => $model_principal->isNewRecord ? 'btn btn-success btn-flat' : 'btn btn-warning btn-flat']) ?>


                                    <div id="resultado" class="tituloprimer" align="center"></div>




                                </div>

                            </div>

                            <br />

                            <br />

                            <br />

<br />

                        <?php foreach ($multiple['form_multiple'] as $i=>$item) {

                            ?>

                                <div class="row">

                                    <div class="col-md-6">

                                        <?= $form->field($item, '['.$i.']nombre')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($item, '['.$i.']descripcion')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($item, '['.$i.']valor')->textInput(['maxlength' => true]) ?>

                                    </div>

                                    <div class="col-md-6">

                                        <?= $form->field($item, '['.$i.']x')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($item, '['.$i.']y')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($item, '['.$i.']width')->textInput(['maxlength' => true]) ?>

                                        <?= $form->field($item, '['.$i.']height')->textInput(['maxlength' => true]) ?>

                                    </div>
                                </div>

                                <br />

                                <br />

                            <?php
                        } ?>


                            
                        </div>

                        <div class="card-footer">


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

        $this->registerJs("



            $('#templatesubregion-template_region_id').change(function() {

                if($(\"#templatesubregion-template_region_id option:selected\").val() > 0){

                    var region_id = $(\"#templatesubregion-template_region_id option:selected\").val();

                        $.ajax({
                            url: 'data-region',
                            type: 'get',
                            dataType:'html',
                            data: {id:region_id},
                            success: function (response) {

                                $(\"#resultado\").append(response);

                                $(\"#templatesubregion-0-nombre\").append(response);
                                
                            }
                        });

                        $.ajax({
                            url: 'data-sub-regiones',
                            type: 'get',
                            dataType:'json',
                            data: {id:region_id,id_anterior:" . $TemplateRegion->id . "},
                            success: function (response) {

                                $(\"#resultado\").append(response);

                                $.each( response.TemplateSubRegiones, function( key, value ) {

                                    $('#templatesubregion-' + key + '-nombre').val(response.TemplateRegion.nombre + '_' + value.valor);

                                    $('#templatesubregion-' + key + '-descripcion').val(response.TemplateRegion.nombre + '_' + value.valor);

                                });

                                $(\"#templatesubregion-0-nombre\").append(response);
                                
                            }
                        });

                }
            });




        "); 

?>

