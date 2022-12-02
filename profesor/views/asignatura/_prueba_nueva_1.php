<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Ramo;
use kartik\widgets\FileInput;
use common\models\PruebaCategoria;

?>
    <div class="fondo-form col-md-12">
        <div class="materiales-form">
            <?php $form = ActiveForm::begin(
                    [
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                    ]
                    
                ); 
            $template = ' <div class="form-group">
            {label}

                        {input}
                    </div>';// falta {hint}\n{error}
                $inputSize = '20';


            
            ?>  



        <div class="card">

            <div class="card-headermorado content-center">

                <div class="row">

                    <div class="col-md-10">
                        <h5> Nueva Prueba</h5>
                    </div>

                </div>

            </div>

            <div class="card-body" id="resultado_ajax">

        
                <?= $form->errorSummary($model) ?> <!-- ADDED HERE -->
                <div class="row col-md-12 quitar-padding">
                    <div class="col-md-6">

                        <?= $form->field($model, 'nombre',['template' => $template])->textInput(['maxlength' => true])->label('<h6><i class="fa fa-caret-right "></i> Nombre</h6>',['class'=>'label-class']) ?>



                    
                        <?php 

                            if (!$model->isNewRecord) {

                                echo  Html::a('<i class="fa fa-arrow-circle-down "  style="font-size:20px;color:red">&nbsp</i> ' , ['descargas/index','ruta'=>'/files/carta_apoderado', 'ruta_archivo'=>$model->prueba_ruta_archivo ] , ['class'=>'btntamano btn-block']);

                            }
                            echo $form->field($model, 'ruta_archivo1')->widget(FileInput::classname())->label('<h6><i class="fa fa-caret-right "></i> Materiales</h6>',['class'=>'label-class']);

                        
                            // if ($area == 13 || $area == 14) {var
                            //  echo $form->field($model, 'ruta_archivo1')->widget(FileInput::classname())->label('Material');
                                //echo $form->field($model, 'ruta_archivo1')->label('Materiales o Pdf')->textInput(['readonly' => !$model->isNewRecord]);
                            // }elseif(!$model->isNewRecord){
                            //     echo $form->field($model, 'ruta_archivo1')->label('Materiales o Pdf')->textInput(['readonly' => !$model->isNewRecord]);
                            // }else{
                            //     echo $form->field($model, 'ruta_archivo1')->widget(FileInput::classname())->label('Materiales o Pdf');
                            // }

                        ?>

                    </div>
                    <div class="col-md-6">



                        <?= $form->field($model, 'numero_preguntas',['template' => $template])->textInput()->label('<h6><i class="fa fa-caret-right "></i> Número de Preguntas</h6>',['class'=>'label-class']) ?>


                        <?php 
                            // echo $form->field($model, 'fecha_publicar')->widget(DateTimePicker::classname(), [
                            //     'options' => ['placeholder' => 'Enter event time ...'],
                            //     'readonly' => true,
                            //     'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
                            //     'pluginOptions' => [
                            //         'autoclose' => true,

                            //         'format' => 'yyyy-mm-dd hh:ii:ss'
                            //     ]
                            // ]);
                        ?>

                    </div>

                </div>



                


                
            </div>

            <div class="card-footer ">

                <?= Html::submitButton('Continuar <i class="fa fa-chevron-right "></i>', ['class' => 'btn btnprimario1 float-right']) ?>

            </div>

            <?php ActiveForm::end(); ?>
    


        </div>

    </div>
</div>

