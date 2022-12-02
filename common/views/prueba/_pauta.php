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

        <div class="">
            <div class="row">
                <?php 


                    $template = ' <div class="input-group">
                    <span class="input-group-addon"><i class="fa fa-angle-right"></i> {label}</span>
                    {input}
                    </div>{error}';// falta {hint}\n{error}

                    $template_hidden = '{input}';// falta {hint}\n{error}

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
            </div>
            <div class="row">



                <div class="col-md-4 ">

                    <?php 
                
                        $contador_separador = 0;
                    
                        $i_general = 0;

                        foreach($PruebaPauta as $i=>$item): 

                            if ($i_general < round(count($PruebaPauta) / 3,0)) {
                        

                                
                                ?>


                                    
                                        <div class="">                                                
                                            <div class="cuadradoCompleto">
                                                <a class="" idpauta="188" numeropregunta="28" correcta="A">
                                                    <div class="row col-md-12"> 
                                                        <div class="col-md-2 numerotabla">
                                                        <?php 

                                                            $item->numero_pregunta = $i + 1;  

                                                            echo $i + 1;

                                                            echo $form->field($item, '['.$i.']prueba_id',['template' => $template_hidden])->hiddenInput()->label('');
                                                            echo $form->field($item, '['.$i.']numero_pregunta',['template' => $template_hidden])->hiddenInput()->label('');
                            

                                                        ?>  
                                                        </div>
                                                        <div class="col-md-8 numeroalt"> 
                                                        <span class="glyphicon glyphicon-pencil"><i class="fa fa-download icon-white"></i>Alternativa correcta:</span>
                                                        </div>
                                                        <div class="col-md-2 arregloingresocolumna">
                                                        <?= $form->field($item, '['.$i.']correcta')->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>  
                                    
                                    


                                <?php 
                            
                                    if($contador_separador == 2){
                                        echo "<div class=\"separadorpequeno\"></div>";
                                    }else{
                                        $contador_separador++;
                                    }

                                    
                                    
                                ?>

                            <?php 

                                

                                }

                                $i_general++;

                        endforeach; 

                        
                            
                    ?>

                </div>  
                
                <div class="col-md-4 ">

                    <?php 
                
                        $contador_separador = 0;
                    
                        $i_general = 0;

                        foreach($PruebaPauta as $i=>$item): 


                            if (($i_general >= round(count($PruebaPauta) / 3,0)) && $i_general < ((round(count($PruebaPauta) / 3,0) * 2))) {

                                ?>


                                    
                                        <div class="">                                                
                                            <div class="cuadradoCompleto">
                                                <a class="" idpauta="188" numeropregunta="28" correcta="A">
                                                    <div class="row col-md-12"> 
                                                        <div class="col-md-2 numerotabla">
                                                        <?php 

                                                            $item->numero_pregunta = $i + 1;  

                                                            echo $i + 1;

                                                            echo $form->field($item, '['.$i.']prueba_id',['template' => $template_hidden])->hiddenInput()->label('');
                                                            echo $form->field($item, '['.$i.']numero_pregunta',['template' => $template_hidden])->hiddenInput()->label('');

                                                        ?>  
                                                        </div>
                                                        <div class="col-md-8 numeroalt"> 
                                                        <span class="glyphicon glyphicon-pencil"><i class="fa fa-download icon-white"></i>Alternativa correcta:</span>
                                                        </div>
                                                        <div class="col-md-2 arregloingresocolumna">
                                                        <?= $form->field($item, '['.$i.']correcta')->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>  
                                    
                                    




                            <?php 

                                

                                }

                                $i_general++;

                        endforeach; 

                        
                            
                    ?>

                </div>  

                <div class="col-md-4 ">

                    <?php 
                
                        $contador_separador = 0;
                    
                        $i_general = 0;

                        foreach($PruebaPauta as $i=>$item): 

                            if (($i_general >= ((round(count($PruebaPauta) / 3,0) * 2)))) {
                        

                                
                                ?>


                                    
                                        <div class="">                                                
                                            <div class="cuadradoCompleto">
                                                <a class="" idpauta="188" numeropregunta="28" correcta="A">
                                                    <div class="row col-md-12"> 
                                                        <div class="col-md-2 numerotabla">
                                                        <?php 

                                                            $item->numero_pregunta = $i + 1;  

                                                            echo $i + 1;

                                                            echo $form->field($item, '['.$i.']prueba_id',['template' => $template_hidden])->hiddenInput()->label('');
                                                            echo $form->field($item, '['.$i.']numero_pregunta',['template' => $template_hidden])->hiddenInput()->label('');

                                                        ?>  
                                                        </div>
                                                        <div class="col-md-8 numeroalt"> 
                                                        <span class="glyphicon glyphicon-pencil"><i class="fa fa-download icon-white"></i>Alternativa correcta:</span>
                                                        </div>
                                                        <div class="col-md-2 arregloingresocolumna">
                                                        <?= $form->field($item, '['.$i.']correcta')->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label(false) ?>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>  
                                    
                                    




                            <?php 

                                

                                }
                                $i_general++;

                        endforeach; 
                            
                        

                    ?>

                </div>  

            </div>





        </div>
        
    <?php ActiveForm::end(); ?>
    
</div>









