<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Ramo;
use kartik\widgets\FileInput;
use common\models\PruebaCategoria;
use yii\helpers\ArrayHelper; 

?>
    <div class="fondo-form col-md-12">
        <div class="materiales-form">




        <div class="card">


            <div class="card-headermorado content-center">

                <div class="row">

                    <div class="col-md-8">
                        <h5> Nueva Prueba</h5>
                    </div>
                    <div class="col-md-2">
                        <h5> Preguntas Con Respuesta : <span class="numerotituloprincipal">20 </span> <span class="listos"></span></h5>
                    </div>
                    <div class="col-md-2">
                        <h5> Preguntas Omitidas : <span class="numerotituloprincipal">  35</span> <span class="omitidas"></span></h5>
                    </div>

                </div>

            </div>
            
            <div class="card-body" id="resultado_ajax">

                <div class="row">   
     
                        <div class="col-md-4" >

                            <?php

                                for ($i=1; $i <= $Prueba->numero_preguntas; $i++) { 

                                    

                                    if ($i <= round($Prueba->numero_preguntas / 3,0)) {

                                        $checkedA='';
                                        $checkedB='';
                                        $checkedC='';
                                        $checkedD='';
                                        $checkedE='';
                                        if(ArrayHelper::keyExists($i, $PruebaPauta, false)){

                                            if($PruebaPauta[$i]["correcta"] == "A"){
                                                $checkedA = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "B"){
                                                $checkedB = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "C"){
                                                $checkedC = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "D"){
                                                $checkedD = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "E"){
                                                $checkedE = 'checked="checked"';
                                            }


                                        }
                                        



                                        ?>

                                            
                                            
                                                <div class="radio-toolbar">
                                                    <div class="numero-respuesta-pauta"><?= $i;?></div>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedA;?> id="<?='radio'.$i.'A'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="A">
                                                    <label for=<?='radio'.$i.'A'?>>A</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedB;?> id="<?='radio'.$i.'B'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="B">
                                                    <label for=<?='radio'.$i.'B'?>>B</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedC;?> id="<?='radio'.$i.'C'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="C">
                                                    <label  for=<?='radio'.$i.'C'?>>C</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedD;?> id="<?='radio'.$i.'D'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="D">
                                                    <label for=<?='radio'.$i.'D'?>>D</label>
                                                    
                                                    <input  type="radio" class="css-checkbox" <?=$checkedE;?> id="<?='radio'.$i.'E'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="E">
                                                    <label for=<?='radio'.$i.'E'?>>E</label>

                                                    <a class="btnlimpiar botonborrar" id="omitir<?php echo $i ?>" id_pregunta= <?=$i?>>Limpiar</a>
                                                    
                                                </div>
                                            

                                        <?php

                                    }


                                }

                            ?>

                        </div>

                        <div class="col-md-4" >

                            <?php

                                for ($i=1; $i <= $Prueba->numero_preguntas; $i++) { 


                                    if (($i > round($Prueba->numero_preguntas / 3,0)) && $i <= ((round($Prueba->numero_preguntas / 3,0) * 2))) {

                                        $checkedA='';
                                        $checkedB='';
                                        $checkedC='';
                                        $checkedD='';
                                        $checkedE='';
                                        if(ArrayHelper::keyExists($i, $PruebaPauta, false)){

                                            if($PruebaPauta[$i]["correcta"] == "A"){
                                                $checkedA = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "B"){
                                                $checkedB = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "C"){
                                                $checkedC = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "D"){
                                                $checkedD = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "E"){
                                                $checkedE = 'checked="checked"';
                                            }


                                        }

                                        ?>


                                            
                                                <div class="radio-toolbar">
                                                    <div class="numero-respuesta-pauta"><?= $i;?></div>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedA;?> id="<?='radio'.$i.'A'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="A">
                                                    <label for=<?='radio'.$i.'A'?>>A</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedB;?> id="<?='radio'.$i.'B'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="B">
                                                    <label for=<?='radio'.$i.'B'?>>B</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedC;?> id="<?='radio'.$i.'C'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="C">
                                                    <label  for=<?='radio'.$i.'C'?>>C</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedD;?> id="<?='radio'.$i.'D'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="D">
                                                    <label for=<?='radio'.$i.'D'?>>D</label>
                                                    
                                                    <input  type="radio" class="css-checkbox" <?=$checkedE;?> id="<?='radio'.$i.'E'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="E">
                                                    <label for=<?='radio'.$i.'E'?>>E</label>

                                                    <a class="btnlimpiar botonborrar" id="omitir<?php echo $i ?>" id_pregunta= <?=$i?>>Limpiar</a>
                                                    
                                                </div>


                                        <?php

                                    }

                                }

                            ?>

                        </div>
                    
                        <div class="col-md-4" >

                            <?php

                                for ($i=1; $i <= $Prueba->numero_preguntas; $i++) { 



                                    if (($i > ((round($Prueba->numero_preguntas / 3,0) * 2)))) {

                                        $checkedA='';
                                        $checkedB='';
                                        $checkedC='';
                                        $checkedD='';
                                        $checkedE='';
                                        if(ArrayHelper::keyExists($i, $PruebaPauta, false)){

                                            if($PruebaPauta[$i]["correcta"] == "A"){
                                                $checkedA = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "B"){
                                                $checkedB = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "C"){
                                                $checkedC = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "D"){
                                                $checkedD = 'checked="checked"';
                                            }
                                            if($PruebaPauta[$i]["correcta"] == "E"){
                                                $checkedE = 'checked="checked"';
                                            }


                                        }

                                        ?>


                                            
                                                <div class="radio-toolbar">
                                                    <div class="numero-respuesta-pauta"><?= $i;?></div>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedA;?> id="<?='radio'.$i.'A'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="A">
                                                    <label for=<?='radio'.$i.'A'?>>A</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedB;?> id="<?='radio'.$i.'B'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="B">
                                                    <label for=<?='radio'.$i.'B'?>>B</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedC;?> id="<?='radio'.$i.'C'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="C">
                                                    <label  for=<?='radio'.$i.'C'?>>C</label>

                                                    <input  type="radio" class="css-checkbox" <?=$checkedD;?> id="<?='radio'.$i.'D'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="D">
                                                    <label for=<?='radio'.$i.'D'?>>D</label>
                                                    
                                                    <input  type="radio" class="css-checkbox" <?=$checkedE;?> id="<?='radio'.$i.'E'?>" id_pregunta= <?=$i?> name="<?=$i?>"   value="E">
                                                    <label for=<?='radio'.$i.'E'?>>E</label>

                                                    <a class="btnlimpiar botonborrar" id="omitir<?php echo $i ?>" id_pregunta= <?=$i?>>Limpiar</a>
                                                    
                                                </div>


                                        <?php

                                    }

                                }

                            ?>

                        </div>


                    <br>
                </div>


                


                
            </div>

            <div class="card-footer ">

                <?= Html::a('<i class="fa fa-check "></i> Finalizar', ['index','id' => $id,'fecha' => $fecha], ['class' => 'btn btnfinalizar1 float-center']);?>


                <?= Html::a('Continuar <i class="fa fa-chevron-right "></i>', ['configuraciones','prueba_id' => $Prueba->id,'id' => $id,'fecha' => $fecha], ['class' => 'btn btnprimario1  float-right']);?>

            </div>


    


        </div>

    </div>
</div>

<?php 

    $this->registerJs("

        
        $('.css-checkbox').click(function() {


            var respuesta = $(this).val();
            var pregunta = $(this).attr('id_pregunta');
            var prueba_id = " . $Prueba->id . ";

            $(this).prop('checked',true);

            _url='guardar-respuesta-pauta';
            $.ajax({
                url: _url,
                data: {\"prueba_id\":prueba_id,\"respuesta\":respuesta,\"numero_pregunta\":pregunta},
                'dataType':'json',
                'type':'GET',
                'success':function(response)
                {
                    
                    if(data.estado == 1)
                    {   
                    
                        
                        $(\".omitidas\").text(data.restantes);
                        $(\".listos\").text(data.listos);
                    }else{
                    
                            alert('Error No se puedo guardar tu pregunta');
                    }
    
    
                } 
            });

        });
    
        $('.botonborrar').click(function(e) {

            e.preventDefault();
            
            

            var numero_pregunta = $(this).attr('id_pregunta');

            var id_prueba = " . $Prueba->id . ";

            var contenedor_superior_alternativas = $(this).parent()


            contenedor_superior_alternativas.children('.css-checkbox').prop('checked', false);


            var _url;
            _url='borrar-respuesta-pauta';
            jQuery.ajax({
                    url: _url,
                    data: {\"prueba_id\":id_prueba,\"numero_pregunta\":numero_pregunta},
                    'dataType':'json',
                    'type':'GET',
                    'success':function(data)
                            {

                            } ,
                    'cache':false});

        });


    ");


?>