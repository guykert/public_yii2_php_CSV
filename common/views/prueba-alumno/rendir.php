<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper; 
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Prueba Alumnos', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];

?>

<div class="main">

    <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',

    ]) ?>





    <div class="app-body" style="margin-top:0px; display: block;">

        <main class="">

        <div class="cajafondoprincipal">

            <div class="contenedorcajaparatodo">

                <div class="row">

                    <div class="col-md-9 sacarpadingleftdoscolumnas">

                        <div class="cajatitulopreguntas">
                            <span>
                                <i class="fa fa-angle-right"></i>
                                <?php echo $nombre; ?> 

                            </span>
                        </div>

                        <div class="cajappanelrespuestasuno">

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


                                <div class="row">   

                                <?php 

                                    $i_preg = 0;
                                    $i_cant_resp = 0;
                                    $barra_de_progreso = "";

                                    
                                    echo '<div class="col-md-4" >';


                                    for ($i=1; $i <= $Prueba->numero_preguntas; $i++) { 

                            

                                        if ($i <= round($Prueba->numero_preguntas / 3,0)) {

                                            $checkedA='';
                                            $checkedB='';
                                            $checkedC='';
                                            $checkedD='';
                                            $checkedE='';
                                            if(ArrayHelper::keyExists($i, $PruebaPauta, false)){

                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "A"){
                                                    $checkedA = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "B"){
                                                    $checkedB = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "C"){
                                                    $checkedC = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "D"){
                                                    $checkedD = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "E"){
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

                                                        <a class="limpiar botonborrar" id="omitir<?php echo $i ?>" id_pregunta= <?=$i?>>Borrar</a>

                                                        
                                                    </div>
                                                

                                            <?php

                                        }


                                    }

                                    echo '</div>';

                                    echo '<div class="col-md-4" >';


                                    for ($i=1; $i <= $Prueba->numero_preguntas; $i++) { 

                            

                                        if (($i > round($Prueba->numero_preguntas / 3,0)) && $i <= ((round($Prueba->numero_preguntas / 3,0) * 2))) {

                                            $checkedA='';
                                            $checkedB='';
                                            $checkedC='';
                                            $checkedD='';
                                            $checkedE='';
                                            if(ArrayHelper::keyExists($i, $PruebaPauta, false)){

                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "A"){
                                                    $checkedA = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "B"){
                                                    $checkedB = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "C"){
                                                    $checkedC = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "D"){
                                                    $checkedD = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "E"){
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

                                                        <a class="limpiar botonborrar" id="omitir<?php echo $i ?>" id_pregunta= <?=$i?>>Borrar</a>


                                                        
                                                    </div>
                                                

                                            <?php

                                        }


                                    }

                                    echo '</div>';

                                    echo '<div class="col-md-4" >';


                                    for ($i=1; $i <= $Prueba->numero_preguntas; $i++) { 

                            

                                        if (($i > ((round($Prueba->numero_preguntas / 3,0) * 2)))) {

                                            $checkedA='';
                                            $checkedB='';
                                            $checkedC='';
                                            $checkedD='';
                                            $checkedE='';
                                            if(ArrayHelper::keyExists($i, $PruebaPauta, false)){

                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "A"){
                                                    $checkedA = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "B"){
                                                    $checkedB = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "C"){
                                                    $checkedC = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "D"){
                                                    $checkedD = 'checked="checked"';
                                                }
                                                if($PruebaAlumnoRespuesta[$i]->respuesta == "E"){
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

                                                        <a class="limpiar botonborrar" id="omitir<?php echo $i ?>" id_pregunta= <?=$i?>>Borrar</a>

                                                        
                                                    </div>
                                                

                                            <?php

                                        }


                                    }

                                    echo '</div>';

                                ?>

                                </div>


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

                                                echo Html::a('<i class="fa fa-reply"></i> VOLVER

                                                ', ['/prueba-alumno/create-respuesta'], ['class'=>'btn-celeste']);

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



                                            var numero_pregunta = $(this).attr('id_pregunta');

                                            var id_prueba = " . $prueba_id . ";

                                            $('#mini_pregunta_' + numero_pregunta).removeClass('numerodepreguntapanel2');
                                            $('#mini_pregunta_' + numero_pregunta).addClass('numerodepreguntapanelguion2');


                                            $('#pregunta_num_' + numero_pregunta).html(numero_pregunta);

                                            var contenedor_superior_alternativas = $(this).parent()




                                            contenedor_superior_alternativas.children('.css-checkbox').prop('checked', false);

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

                                            var numero_pregunta = $(this).attr('id_pregunta');
                                            

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
                                                    data: {\"prueba_id\":id_prueba,'prueba_alumno':" . $PruebaAlumno->id . ",'rut':'" . $rut . "',\"respuesta\":respuesta,\"numero_pregunta\":numero_pregunta},
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

                                                $(\"#zona-material-form\").attr(\"action\", \"finalizar-prueba-pdf?prueba_id=" . $prueba_id . "&prueba_alumno=" . $PruebaAlumno->id . "&curso_id=" . $curso_id . "&rut=" . $rut . "&taller=1\");

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
                                    

                
                                    <div class="paddinggeneraldecaja">
                
                
                                        <div class="row ">

                                            <?php 

                                                $i_preg = 0;
                                                $i_cant_resp = 0;
                                                $barra_de_progreso = "";

                                                $PruebaAlumnoRespuestas = $PruebaAlumno->CorrectasVSRespuestas;


                                                for ($i=1; $i <= $Prueba->numero_preguntas; $i++) {

                                                    $i_preg++;

                                                    $modelAlumnoRespuesta = $PruebaAlumnoRespuesta[$i];

                                                    if($modelAlumnoRespuesta->respuesta != ""){

                                                        $i_cant_resp++;

                                                        ?>
                                                    
                                                            <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $i?>">
                                                                <a id="" eliminardatos ="" class="" href="#">
                                                                    <div id="mini_pregunta_<?php echo $i?>" class="numerodepreguntapanel2">
                                                                    <?php echo $i?>

                                                                    </div>
                                                                </a>
                                                            </div>

                                                        <?php

                                                    }else{

                                                        ?>
                                                    
                                                            <div class="col-xs-2 col-md-2 progress-bar-click sacarpadingleftrightdos" num_pregunta="<?php echo $i?>">
                                                                <a id="" eliminardatos ="" class="" href="#">
                                                                    <div id="mini_pregunta_<?php echo $i?>" class="numerodepreguntapanelguion2">
                                                                    <?php echo $i?>

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

</div>