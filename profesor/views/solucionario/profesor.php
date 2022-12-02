<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\models\Prueba;
use common\models\PruebaAlumnoRespuesta;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = $this->title;

?>


<div class="main">

    <?=  Breadcrumbs::widget([
        'class'=>'breadcrumb',
        'itemTemplate' => "<li  class=\"breadcrumb-item\">{link}</li>\n", 
        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/seleccionar-curso'],
            'template' => "<li  class=\"breadcrumb-item\">{link}</li>\n", // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <div class="app-body" style="margin-top:0px; display: block;">

        <main class="">

        <div class="cajafondoprincipal">

            <div class="contenedorcajaparatodo">

                <div class="row">

                    <div class="col-md-9 sacarpadingleftdoscolumnas">

                        <div class="">

                            <div class="cajatitulopreguntas">
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                    <?php echo $nombre; ?> 

                                </span>
                            </div>

                            <?php 
                            
                                $form = ActiveForm::begin(
                                    [
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => false,
                                        'id'=>'zona-material-form',
                                    ]
                                ); 
                                $template = ' <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-angle-right"></i> {label}</span>
                                {input}
                                </div>';// falta {hint}\n{error}
                                $inputSize = '60'; 





                            ?>

                                <?php 

                                    $i_preg = 0;
                                    $i_cant_resp = 0;
                                    $barra_de_progreso = "";


                                    $PruebaRespuestasCorrectas = $Prueba->PreguntasCorrectas;

                                    foreach($Prueba_preguntas as $instancia_pregunta){

                                        $i_preg++;

                                        $modelAlumnoRespuesta = new PruebaAlumnoRespuesta();
                
                                        $modelAlumnoRespuesta->respuesta = $PruebaRespuestasCorrectas[$instancia_pregunta->numero_pregunta];
                
                                        $modelAlumnoRespuesta->numero_pregunta = $instancia_pregunta->numero_pregunta;
                
                                        $modelAlumnoRespuesta->correcta = $PruebaRespuestasCorrectas[$instancia_pregunta->numero_pregunta]["correcta"];
                
                                        // generamos el nombre de la pregunta del modelo
                                        $respuesta = "respuesta{$instancia_pregunta->numero_pregunta}";
                
                                        $correcto = "<i class=\"fa fa-times-circle preguntamalaicono\"></i>";
                
                                        
                                        ?>
                                            
                                            <div class="cajapreguntas">
                                                <div class="" style="">
                                                    <div class="row ">
                                                        <div class="col-xs-12 col-md-12 preguntanumero">
                                                            <span class="">


                                                            <a name="ancla_pregunta_<?php echo $instancia_pregunta->numero_pregunta; ?>"><i class="fa fa-list-ul"></i></a> Pregunta <?php echo $instancia_pregunta->numero_pregunta; ?>:</a> 
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="row ">
                                                        <div class="col-xs-12 col-md-12 pregunta">
                                                            <div class="">
                                                                <span>

                                                                    <?php 
                                                                    
                                                                        echo $instancia_pregunta->pregunta->questiontext; 

                                                                    ?>

                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row " id="div_radios">
                                                        <div class="col-xs-12 col-md-12">                                        
                                                        <div class="opcionesradio<?php echo $i_preg ?>" style=" ">
                                                            <br>
                                                            <br>
                                                            <?php 

                                                                $i = 1;
                                                                $data = array();
                                                                foreach($instancia_pregunta->pregunta->alternativas as $alternativa): 



                                                                    //print_r($alternativa->answer);
                                                                    if($i == 1){$letra = " &nbsp; A)";$letra2 = "A";}
                                                                    if($i == 2){$letra = " &nbsp; B)";$letra2 = "B";}
                                                                    if($i == 3){$letra = " &nbsp; C)";$letra2 = "C";}
                                                                    if($i == 4){$letra = " &nbsp; D)";$letra2 = "D";}
                                                                    if($i == 5){$letra = " &nbsp; E)";$letra2 = "E";}
                                                                    if($i == 6){$letra = " &nbsp; F)";$letra2 = "F";}
                                                                    if($i == 7){$letra = " &nbsp; G)";$letra2 = "G";}
                                                                    $data[$letra2] = $letra . " " . $alternativa->answer;


                                                                    
                                                                    $i++;
                                                                    endforeach;

                                                                ?>



                                                                <?= $form->field($modelAlumnoRespuesta, '['.$instancia_pregunta->numero_pregunta.']respuesta')->radioList($data,
                                                                                                [   
                                                                                                    'item' => function($index, $label, $name, $checked, $value) {

                                                                                                        $return = '<div class="radiobutontextos">';
                                                                                                        if ($checked) {
                                                                                                            $return .= '<input id="'.$name.'_'.$index.'" type="radio" class="css-checkbox" name="' . $name . '" value="' . $value . '" disabled checked tabindex="3">';
                                                                                                        }else{
                                                                                                            $return .= '<input id="'.$name.'_'.$index.'" type="radio" class="css-checkbox" name="' . $name . '" value="' . $value . '" disabled tabindex="3">';
                                                                                                        }

                                                                                                        
                                                                                                        $return .= '<label class="css-label" for="'.$name.'_'.$index.'">';
                                                                                                        $return .= '<span class="textocolorpreguntas">' . $label . '</span>';
                                                                                                        $return .= '</label></div>';
                                                                                                        return $return;
                                                                                                    }
                                                                                                ]
                                                                                        )->label(false) ?>



                                                                <?= $form->field($modelAlumnoRespuesta, '['.$instancia_pregunta->numero_pregunta.']numero_pregunta')->hiddenInput()->label(false); ?>
                                                                <?= $form->field($modelAlumnoRespuesta, '['.$instancia_pregunta->numero_pregunta.']pregunta_id')->hiddenInput()->label(false); ?>


                                                            

                                                        </div>          
                                                        </div>
                                                    </div>

                                                    <br>
                                                    <div class="col-xs-12 col-md-12 container sombra2 sacarlineaaltura img-responsive ">
                                                        <div class="separadorpreguntas"></div>
                                                    </div>

                                                    <?php 
                                                                    
                                                        if(count($Prueba_solucionario) > 0){
                                                    
                                                    ?>                                                  

                                                        <div class="cuadrorespuestasolucionario">
                                                            <div class="">
                                                                <div class="">
                                                                    <span><i class="fa fa-check-circle"></i>  SOLUCIONARIO</span>
                                                                </div>
                                                                <div class="separadorsolucionario">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>







                                                        <div class="row cuadro">
                                                            <div class="col-md-12">
                                                                <div class="desarrollosolucionario">
                                                                    <span >
                                                                        <?php 
                                                                        
                                                                            if(count($Prueba_solucionario) > 0){
                                                                                echo $Prueba_solucionario[$instancia_pregunta->numero_pregunta - 1]->pregunta->questiontext; 
                                                                            }

                                                                        
                                                                        
                                                                        ?>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php 
                                                                    
                                                                }
                                                    
                                                    ?> 

                                                </div>

                                            <br>
                                            </div>

                                            <div class="col-xs-12 col-md-12 container sombra2  sacarlineaaltura img-responsive">
                                                <div class="separadorpreguntas">
                                                </div>

                                            </div>

                                        <?php

                                    }

                                ?>





                                <?php 

                                    $this->registerJs("

                                        var i_cant_resp = " . $i_cant_resp . ";
                                        $('#cont_barra_abance').addClass( \"mostrarcuadrotiempo\" );
                                        $('#cont_barra_abance').removeClass('ocultarcuadrotiempo');
                                        $('#nav_bar').addClass( \"navbar_jornada\" );
                                        

                                    "); 

                                ?>


                            <?php ActiveForm::end(); ?>

                            <div class="">
                                <hr> 
                                <br>
                                <div class="row">
                                    <div class="col-xs-3 col-md-5"></div>                                        

                                    <div class="col-xs-3 col-md-2">

                                        <?php 

                                            echo Html::a('<i class="fa fa-reply"></i> VOLVER

                                            ', ['/seleccionar-curso'], ['class'=>'btn btnprimario1']);


                                        ?>

                                    </div>
                                    <div class="col-xs-3 col-md-5"></div>
                                </div>
                            </div>

                            <br><br>

                        </div>

                    </div>

                    <div class="col-md-3 sacarpadingrightdoscolumnas">
                        
                        <div class="">
                                    
                            <div class="cajatitulopanelderespuestas">
                                <span>
                                    <i class="fa fa-angle-right"></i>
                                    Estado de preguntas
                                </span>
                            </div>    
                            
                
                            <div class="cajappanelrespuestas">
                                <div class="" style="">
                                    
                                    <div class="row ">
                                        <div class="col-xs-12 col-md-12 preguntanumero">
                                            <span class="">
                                                <a name="ancla_pregunta_1">&nbsp;</a> </a>
                                            </span>
                                        </div>
                                    </div>
                
                                    <div class="paddinggeneraldecaja">
                
                
                                        <div class="row ">

                                            <?php 

                                                $i_preg = 0;
                                                $i_cant_resp = 0;
                                                $barra_de_progreso = "";

                                                foreach($Prueba_preguntas as $instancia_pregunta){

                                                    $i_preg++;

                                                    ?>
                                                    
                                                        <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $instancia_pregunta->numero_pregunta?>">
                                                            <a id="" eliminardatos ="" class="" href="#">
                                                                <div class="numerodepreguntapanelguion">
                                                                <?php echo $instancia_pregunta->numero_pregunta?>
                                                                <div class="divisionbtnpregunta"></div>
                                                                <i class="fa fa-check"></i>
                                                                </div>
                                                            </a>
                                                        </div>

                                                    <?php

                                                }

                                            ?>

                                        </div>
                

                
                                    </div>
                
                                </div>
                            </div>
            
                        </div>
            
                        <br><br>
                
                    </div>
                    <br>


                </div>

            </div>

        </div>

        <br>

        </main>

    </div>


</div>


