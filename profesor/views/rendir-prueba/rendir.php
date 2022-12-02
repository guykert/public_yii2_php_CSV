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

                            <?= $form->field($PruebaAlumno, 'id')->hiddenInput()->label(false); ?>

                            <?php 

                                $i_preg = 0;
                                $i_cant_resp = 0;
                                $barra_de_progreso = "";

                                

                                foreach($Prueba_preguntas as $instancia_pregunta){



                                    





                                    $i_preg++;

                                    $modelAlumnoRespuesta = $PruebaAlumnoRespuesta[$instancia_pregunta->numero_pregunta];
                                    $modelAlumnoRespuesta->numero_pregunta = $instancia_pregunta->numero_pregunta;
                                    // generamos el nombre de la pregunta del modelo
                                    $respuesta = "respuesta{$instancia_pregunta->numero_pregunta}";



                                    
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

                                                                                                    $return = '<div style="vertical-align: text-top;">';
                                                                                                    if ($checked) {
                                                                                                        $return .= '<input id="'.$name.'_'.$index.'" type="radio" class="css-checkbox" name="' . $name . '" value="' . $value . '" checked tabindex="3">';
                                                                                                    }else{
                                                                                                        $return .= '<input id="'.$name.'_'.$index.'" type="radio" class="css-checkbox" name="' . $name . '" value="' . $value . '" tabindex="3">';
                                                                                                    }

                                                                                                    
                                                                                                    $return .= '<label class="css-label" for="'.$name.'_'.$index.'">';
                                                                                                    $return .= '<span>' . $label . '</span>';
                                                                                                    $return .= '</label></div>';
                                                                                                    return $return;
                                                                                                }
                                                                                            ]
                                                                                        )->label(false) ?>

                                                            <div>
                                                            <a id="omitir<?php echo $instancia_pregunta->numero_pregunta ?>" eliminardatos="<?php echo $instancia_pregunta->numero_pregunta ?>" class="btngris botonborrar" href="#"><i class="fa fa-remove "></i> Limpiar</a>
                                                        </div>

                                                        <?= $form->field($modelAlumnoRespuesta, '['.$instancia_pregunta->numero_pregunta.']numero_pregunta')->hiddenInput()->label(false); ?>
                                                        <?= $form->field($modelAlumnoRespuesta, '['.$instancia_pregunta->numero_pregunta.']pregunta_id')->hiddenInput()->label(false); ?>

                                                        

                                                    </div>          
                                                    </div>
                                                </div>

                                                <br>
                                                <div class="col-xs-12 col-md-12 container sombra2 sacarlineaaltura img-responsive">
                                                    <div class="separadorpreguntas"></div>
                                                </div>

                                            </div>

                                        <br>
                                        </div>

                                        <div class="col-xs-12 col-md-12 container sombra2 sacarlineaaltura img-responsive">
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
                                    <div class="col-xs-3 col-md-3"></div>                                        
                                    <div class="col-xs-3 col-md-3">

                                        <?php 

                                            echo Html::a('

                                            <i class="fa fa-check"></i> FINALIZAR

                                            ', [null], ['class'=>'btn-azul','id'=>'id_finalizar']);

                                        ?>

                                    </div>
                                    <div class="col-xs-3 col-md-3">

                                        <?php 

                                            if ($CPruebasAlumno == 0) {

                                                echo Html::a('<i class="fa fa-reply"></i> VOLVER

                                                    ', ['/home','curso_id'=>$curso_id], ['class'=>'btn-celeste']);

                                            }else{

                                                echo Html::a('<i class="fa fa-reply"></i> VOLVER

                                                    ', ['/rendir-prueba/previo','prueba_id'=>$prueba_id,'curso_id'=>$curso_id], ['class'=>'btn-celeste']);

                                            }

                                        ?>

                                    </div>
                                    <div class="col-xs-3 col-md-3"></div>
                                </div>
                            </div>

                            <br><br>


                            <?php 

                                $i_preg = 0;
                                $i_cant_resp = 0;


                                foreach($Prueba_preguntas as $instancia_pregunta){

                                    $i_preg++;

                                    $modelAlumnoRespuesta = $PruebaAlumnoRespuesta[$instancia_pregunta->numero_pregunta];

                                    if($modelAlumnoRespuesta->respuesta != ""){

                                        $i_cant_resp++;


                                    }

                                }

                            ?>


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

                                        $('#mini_pregunta_' + numero_pregunta).removeClass('numerodepreguntapanel2');
                                        $('#mini_pregunta_' + numero_pregunta).addClass('numerodepreguntapanelguion2');


                                        $('#pregunta_num_' + numero_pregunta).html(numero_pregunta);



                                        $(\".opcionesradio\" + $(this).attr(\"eliminardatos\") + \" input:radio\").prop('checked', false);

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

                                    $('.css-checkbox').click(function(e) {


                                        $( this ).attr('checked', true);



                                    });

                                    $('.css-checkbox').click(function() {

                                        var respuesta = $(this).val();

                                        var numero_pregunta = $( this ).parent().parent().parent().parent().find('[name*=\"][numero_pregunta]\"]').val();
                                        

                                        var id_prueba = " . $prueba_id . ";

                                        $('#mini_pregunta_' + numero_pregunta).removeClass('numerodepreguntapanelguion2');
                                        $('#mini_pregunta_' + numero_pregunta).addClass('numerodepreguntapanel2');

                                        $('#pregunta_num_' + numero_pregunta).html('');

                                        //guardamos el valor de la cookye
                                        var nombre_cookie = \"jornada\" + id_prueba + \"preg\" + numero_pregunta;

                                        i_cant_resp = $(\".numerodepreguntapanel2\").length;

                                        
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

                                    var austDay = new Date(),austDay2 = new Date(austDay);

                                    austDay2.setSeconds ( austDay.getSeconds() + " . $segundos . " );

                                    austDay3 = new Date(austDay2);

                                    $('#countdown').countdown({
                                        date: austDay3,
                                        render: function(data) {
                                        $(this.el).text(this.leadingZeros(data.hours, 1) + \" Horas \" + this.leadingZeros(data.min, 2) + \" min \" + this.leadingZeros(data.sec, 2) + \" seg\");
                                        },
                                        onEnd: function() {
                                            $(\"#zona-material-form\").attr(\"action\", \"finalizar-prueba?prueba_id=" . $prueba_id . "\");
                        
                                            //alert(\"accion 2 : \" + $(\"#zona-material-form\").attr(\"action\"));
                                            $( \"#zona-material-form\" ).submit();
                                        }
                                    })

                                    // $('#countdowntop').countdown({
                                    //     date: austDay3,
                                    //     render: function(data) {
                                    //     $(this.el).text(this.leadingZeros(data.hours, 1) + \" Horas \" + this.leadingZeros(data.min, 2) + \" min \" + this.leadingZeros(data.sec, 2) + \" seg\");
                                    //     },
                                    //     onEnd: function() {
                                    //         $(\"#zona-material-form\").attr(\"action\", \"finalizar-prueba?prueba_id=" . $prueba_id . "&curso_id=" . $curso_id . "\");
                        
                                    //         //alert(\"accion 2 : \" + $(\"#zona-material-form\").attr(\"action\"));
                                    //         $( \"#zona-material-form\" ).submit();
                                    //     }
                                    // })
                        
                                    var alertaustDay = new Date(),alertaustDay2 = new Date(austDay);
                        
                                    //alert(\"austDay : \" + austDay + \"  austDay2 : \" + austDay2);
                                    alertaustDay2.setSeconds ( alertaustDay.getSeconds() + " . $segundos2 . " );
                        
                                    alertaustDay3 = new Date(alertaustDay2);


                        
                        
                                    $('#countdown2').countdown({
                                        date: alertaustDay3,
                                        render: function(data) {
                                        $(this.el).text(this.leadingZeros(data.hours, 1) + \" Horas \" + this.leadingZeros(data.min, 2) + \" min \" + this.leadingZeros(data.sec, 2) + \" seg\");
                                        },
                                        onEnd: function() {
                                        " . $mostrar_alerta . "
                                        $('#cuadrotiempo').removeClass( \"cuadrotiempo\" ).addClass( \"cuadrotiemporojo\" );
                                        }
                                    })

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

                                            $PruebaAlumnoRespuestas = $PruebaAlumno->CorrectasVSRespuestas;

                                            foreach($Prueba_preguntas as $instancia_pregunta){

                                                $i_preg++;

                                                $modelAlumnoRespuesta = $PruebaAlumnoRespuesta[$instancia_pregunta->numero_pregunta];

                                                if($modelAlumnoRespuesta->respuesta != ""){

                                                    $i_cant_resp++;

                                                    ?>
                                                
                                                        <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $instancia_pregunta->numero_pregunta?>">
                                                            <a id="" eliminardatos ="" class="" href="#">
                                                                <div id="mini_pregunta_<?php echo $instancia_pregunta->numero_pregunta?>" class="numerodepreguntapanel2">
                                                                <?php echo $instancia_pregunta->numero_pregunta?>

                                                                </div>
                                                            </a>
                                                        </div>

                                                    <?php

                                                }else{

                                                    ?>
                                                
                                                        <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $instancia_pregunta->numero_pregunta?>">
                                                            <a id="" eliminardatos ="" class="" href="#">
                                                                <div id="mini_pregunta_<?php echo $instancia_pregunta->numero_pregunta?>" class="numerodepreguntapanelguion2">
                                                                <?php echo $instancia_pregunta->numero_pregunta?>

                                                                </div>
                                                            </a>
                                                        </div>
    
                                                    <?php
                                                    
                                                }

                                            }

                                        ?>

                                    </div>
               
                                    <div class="row ">
                                        <div class="col-xs-12 col-md-12 sacarpadingleftrightdos">
                                        
                                            <div class="tiemporestante cuadrotiempo" id="cuadrotiempo">
                                                <i class="fa fa-angle-right"></i> Tiempo restante: <span class="countdown callback" id="countdown">3 Horas 12 min 34 seg</span>  
                                            </div>
                                            <div class="countdown callback" id="countdown2" style="display:none;"></div>
                
                                        </div>
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
