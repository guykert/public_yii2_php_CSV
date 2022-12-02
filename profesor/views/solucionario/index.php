<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/home','curso_id'=>$curso_id]];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="cabecerafondo">
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


    </div>
</div>




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

                                $PruebaAlumnoRespuestas = $PruebaAlumno->CorrectasVSRespuestas;

                                

                                foreach($Prueba_preguntas as $instancia_pregunta){



                                    





                                    $i_preg++;

                                    $modelAlumnoRespuesta = $PruebaAlumnoRespuesta[$instancia_pregunta->numero_pregunta];
                                    $modelAlumnoRespuesta->numero_pregunta = $instancia_pregunta->numero_pregunta;
                                    // generamos el nombre de la pregunta del modelo
                                    $respuesta = "respuesta{$instancia_pregunta->numero_pregunta}";

                                    $correcto = "<i class=\"fa fa-times-circle preguntamalaicono\"></i>";


                                    if ($PruebaAlumnoRespuestas[$instancia_pregunta->numero_pregunta - 1]['resultado_pregunta'] == "correcta") {
                                        $correcto = "<i class=\"fa fa-check-circle preguntabuenaicono\"></i>";
                                    }


                                    
                                    ?>
                                        
                                        <div class="cajapreguntas">
                                            <div class="" style="">
                                                <div class="row ">
                                                    <div class="col-xs-12 col-md-12 preguntanumero">
                                                        <span class="">


                                                        <a name="ancla_pregunta_<?php echo $instancia_pregunta->numero_pregunta; ?>"><i class="fa fa-list-ul"></i></a> Pregunta <?php echo $instancia_pregunta->numero_pregunta; ?>:</a>  <?php echo $correcto;?>
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

                                                                if($letra2 == $modelAlumnoRespuesta->respuesta){

                                                                    if($PruebaAlumnoRespuestas[$instancia_pregunta->numero_pregunta - 1]["correcta"] == $modelAlumnoRespuesta->respuesta){
                                                                        $data[$letra2] = $letra . " " . $alternativa->answer . "   <i class=\"fa fa-check-circle preguntabuenaiconorespuesta\"></i>";
                                                                    }else{
                                                                        $data[$letra2] = $letra . " " . $alternativa->answer . "   <i class=\"fa fa-times-circle preguntamalaiconorespuesta\"></i>";
                                                                    }
                                                                }else{


                                                                    if($letra2 == $PruebaAlumnoRespuestas[$instancia_pregunta->numero_pregunta - 1]["correcta"]){
                                                                        $data[$letra2] = $letra . " " . $alternativa->answer . "   <i class=\"fa fa-check-circle preguntabuenaiconorespuesta\"></i>";
                                                                    }else{
                                                                        $data[$letra2] = $letra . " " . $alternativa->answer;
                                                                    }
                                                                    
                                                                }
                                                                 
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


                            <div class="">
                                <hr> 
                                <br>
                                <div class="row">
                                    <div class="col-xs-3 col-md-5"></div>                                        

                                    <div class="col-xs-3 col-md-2">

                                        <?php 

                                            echo Html::a('<i class="fa fa-reply"></i> VOLVER

                                            ', ['/rendir-prueba/previo','prueba_id'=>$prueba_id,'curso_id'=>$curso_id], ['class'=>'btn-celeste']);


                                        ?>

                                    </div>
                                    <div class="col-xs-3 col-md-5"></div>
                                </div>
                            </div>

                            <br><br>


                            <?php 

                                $this->registerJs("

                                    var i_cant_resp = " . $i_cant_resp . ";
                                    $('#cont_barra_abance').addClass( \"mostrarcuadrotiempo\" );
                                    $('#cont_barra_abance').removeClass('ocultarcuadrotiempo');
                                    $('#nav_bar').addClass( \"navbar_jornada\" );
                                    
                                    " . $barra_de_progreso . "

                                    $('.botonborrar').click(function(e) {

                                        e.preventDefault();

                                        var numero_pregunta = $( this ).parent().parent().parent().parent().find('[name*=\"][numero_pregunta]\"]').val();

                                        var id_prueba = " . $prueba_id . ";

                                        $('#pregunta_' + numero_pregunta).removeClass('progress-bar-success');
                                        $('#pregunta_' + numero_pregunta).addClass('progress-bar-danger');

                                        $('#pregunta_num_' + numero_pregunta).html(numero_pregunta);

                                        $(\".opcionesradio\" + $(this).attr(\"eliminardatos\") + \" input:radio\").attr('checked', false);

                                        var nombre_cookie = \"jornada\" + id_prueba + \"preg\" + numero_pregunta;

                                        i_cant_resp--;

                                        var _url;
                                        _url='borrar-respuesta';
                                        jQuery.ajax({
                                                url: _url,
                                                data: {\"prueba_id\":id_prueba,'prueba_alumno':" . $PruebaAlumno->id . ",\"numero_pregunta\":numero_pregunta},
                                                'dataType':'json',
                                                'type':'GET',
                                                'success':function(data)
                                                        {

                                                        } ,
                                                'cache':false});

                                    });

                                    $('.css-checkbox').click(function() {

                                        var respuesta = $(this).val();

                                        var numero_pregunta = $( this ).parent().parent().parent().parent().find('[name*=\"][numero_pregunta]\"]').val();
                                        

                                        var id_prueba = " . $prueba_id . ";

                                        $('#pregunta_' + numero_pregunta).removeClass('progress-bar-danger');
                                        $('#pregunta_' + numero_pregunta).addClass('progress-bar-success');

                                        $('#pregunta_num_' + numero_pregunta).html('');

                                        //guardamos el valor de la cookye
                                        var nombre_cookie = \"jornada\" + id_prueba + \"preg\" + numero_pregunta;

                                        i_cant_resp = $(\".progress-bar-success\").length;

                                        
                                        var _url;
                                        _url='guardar-respuesta';
                                        jQuery.ajax({
                                                url: _url,
                                                data: {\"prueba_id\":id_prueba,'prueba_alumno':" . $PruebaAlumno->id . ",\"respuesta\":respuesta,\"numero_pregunta\":numero_pregunta},
                                                'dataType':'json',
                                                'type':'GET',
                                                'success':function(data)
                                                        {

                                                        } ,
                                                'cache':false});  

                                    });

                                    $('.progress-bar-click').click(function() {


                                        //$('.opcionesradio'  + $(this).attr(\"num_pregunta\")).focus();

                                        window.location.hash = '#ancla_pregunta_' + $(this).attr(\"num_pregunta\");

                                    });


                                    $('#id_finalizar').click(function(e){
                                    
                                        e.preventDefault();
                                        var pagina_actual = $('#ZonaTalleresPregunta_nmero_pregunta').val();



                                        

                                        var preguntas_restantes = " . $i_preg . " - i_cant_resp;




                                        var texto_mostrar;
                                        if(preguntas_restantes == 0){
                                            texto_mostrar = \"¿Estás seguro que quieres finalizar : " . $nombre . "?\";
                                        }else{
                                            texto_mostrar = \"¿Estás seguro que quieres finalizar : " . $nombre . "? Te quedan \" + preguntas_restantes + \" preguntas sin responder.\";
                                        }
                                        if (confirm(texto_mostrar)) {
                                            // alert(\"accion 1 : \" + $(\"#zona-material-form\").attr(\"action\"));

                                            $(\"#zona-material-form\").attr(\"action\", \"finalizar-prueba?prueba_id=" . $prueba_id . "&prueba_alumno=" . $PruebaAlumno->id . "&curso_id=" . $curso_id . "&taller=1\");

                                            //alert(\"accion 2 : \" + $(\"#zona-material-form\").attr(\"action\"));
                                            $( \"#zona-material-form\" ).submit();
                                        }

                                        

                                    });


                                "); 

                            ?>


                        <?php ActiveForm::end(); ?>

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
                                                $modelAlumnoRespuesta = $PruebaAlumnoRespuesta[$instancia_pregunta->numero_pregunta];

                                                if($modelAlumnoRespuesta->respuesta != ""){

                                                    if($PruebaAlumnoRespuestas[$instancia_pregunta->numero_pregunta - 1]["correcta"] == $modelAlumnoRespuesta->respuesta){

                                                        ?>
                                                
                                                            <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $instancia_pregunta->numero_pregunta?>">
                                                                <a id="" eliminardatos ="" class="" href="#">
                                                                    <div class="numerodepreguntapanel">
                                                                    <?php echo $instancia_pregunta->numero_pregunta?>
                                                                    <div class="divisionbtnpregunta"></div>
                                                                    <i class="fa fa-check"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
        
                                                        <?php

                                                    }else{

                                                        ?>
                                                
                                                            <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $instancia_pregunta->numero_pregunta?>">
                                                                <a id="" eliminardatos ="" class="" href="#">
                                                                    <div class="numerodepreguntapanelmala">
                                                                    <?php echo $instancia_pregunta->numero_pregunta?>
                                                                    <div class="divisionbtnpregunta"></div>
                                                                    <i class="fa fa-times"></i>
                                                                    </div>
                                                                </a>
                                                            </div>
        
                                                        <?php
                                                        
                                                    }

                                                }else{

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
