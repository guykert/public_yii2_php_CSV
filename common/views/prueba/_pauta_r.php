<?php




use yii\helpers\Html;
use yii\data\ArrayDataProvider;
use kartik\builder\TabularForm;
use kartik\grid\GridView;
use yii\bootstrap\Modal;   
use yii\helpers\Url;
use yii\widgets\ActiveForm;


?>




<div class="">
    
    <?php 



        $form = ActiveForm::begin(
            [
                'id' => 'signup-form',
                'enableAjaxValidation' => true,
                //'action' => Url::toRoute('user/ajaxregistration'),
                'validationUrl' => Url::toRoute('prueba/pauta?id=' . $model->id)
            ]
            
        ); 


    ?>

        <div class="row-fluid" style="" >

            <?php 


                $template = ' <div class="input-group">
                <span class="input-group-addon"><i class="fa fa-angle-right"></i> {label}</span>
                {input}
                </div>{error}';// falta {hint}\n{error}
                $inputSize = '60'; 

            ?>
            <div>
            <br>    
            </div> 

            <p style="float: right;">

            <?= Html::submitButton('<i class="fa fa-star pad-right"></i> GUARDAR ' , ['class' => 'btn btn-success btn-flat']) ?>


 
            <p style="float: left;">
                <?= Html::a('<i class="fa fa-star pad-left"></i> CARGAR PLANTILLA', ['cargar', 'prueba_id' => $model->id], ['class' => 'btn btn-md  btn-guardar','id' => 'cargar_plantilla']) ?>
            </p>

            <br>
            <div class="col-md-12 quitar-padding">


                <?php 
                

                
                    foreach($PruebaPauta as $i=>$item): ?>

                    <div class="col-md-4">
                        <div style="width: 0;height: 0">
                        
                            <?php 

                                $item->numero_pregunta = $i + 1;  

                                echo $form->field($item, '['.$i.']prueba_id')->hiddenInput()->label('');
                                echo $form->field($item, '['.$i.']numero_pregunta')->hiddenInput()->label('');

                            ?>  

                        </div>

                        <div class="col-md-2 numerotabla"> 

                            <?php echo $i + 1; ?> 

                        </div>

                        <div class="col-md-10 sin-padding">

                            <div class="form-group field-pruebaconversiondetalle-0-puntaje required">

                                <?= $form->field($item, '['.$i.']correcta',['template' => $template])->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label('Alternativa Correcta') ?>

                                <div class="help-block"></div>
                            </div>     
                                            
                        </div>

                    </div>

                <?php endforeach; ?>
                
            </div>





        </div>
        
    <?php ActiveForm::end(); ?>
    
</div>









