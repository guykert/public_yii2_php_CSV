<?php

use yii\helpers\Html;


?>

<div class=" isotope-item" style="">
    <div class="titulo2">
        <div class="">

        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active">
            <div class="">
                <?php 

                    // creo un arreglo con las clases
                        $clases = [];
                        $clases[] = "tagamarillo eje_clase";
                        $clases[] = "tagrojo eje_clase";
                        $clases[] = "tagverde eje_clase";
                        $clases[] = "tagpur eje_clase";
                        $clases[] = "tagmora eje_clase";
                        $clases[] = "tagverde2 eje_clase";
                        $clases[] = "tagamarillo eje_clase";
                        $clases[] = "tagrojo eje_clase";
                        $clases[] = "tagverde eje_clase";
                        $clases[] = "tagpur eje_clase";
                        $clases[] = "tagmora eje_clase";
                        $clases[] = "tagverde2 eje_clase";
                        $clases[] = "tagamarillo eje_clase";
                        $clases[] = "tagrojo eje_clase";
                        $clases[] = "tagverde eje_clase";
                        $clases[] = "tagpur eje_clase";
                        $clases[] = "tagmora eje_clase";
                        $clases[] = "tagverde2 eje_clase";
                        $clases[] = "tagmora eje_clase";

                    // creo un arreglo con las clases 2
                    
                        $clases_destino = [];
                        $clases_destino[] = "amarillo";
                        $clases_destino[] = "rojo";
                        $clases_destino[] = "verde";
                        $clases_destino[] = "pur";
                        $clases_destino[] = "mora";
                        $clases_destino[] = "verde2";
                        $clases_destino[] = "amarillo";
                        $clases_destino[] = "rojo";
                        $clases_destino[] = "verde";
                        $clases_destino[] = "pur";
                        $clases_destino[] = "mora";
                        $clases_destino[] = "verde2";
                        $clases_destino[] = "amarillo";
                        $clases_destino[] = "rojo";
                        $clases_destino[] = "verde";
                        $clases_destino[] = "pur";
                        $clases_destino[] = "mora";
                        $clases_destino[] = "verde2";
                        $clases_destino[] = "mora";

                ?>

                <ul class="tags">

                    <?php 

                        $i = 0;
                        foreach($PruebaEjeTematico as $key => $PruebaEjetematico):
                            ?>
                                <li><?= Html::a($PruebaEjetematico->nombre, [''], ['class'=>$clases[$key],'clases_destino'=>$clases_destino[$key],'clase'=>$clases[$key],'id_eje'=>$PruebaEjetematico->id,'nombre_eje'=>$PruebaEjetematico->nombre]) ?></li>
                            <?php
                            $i++;

                        endforeach; 

                    ?>

                </ul>

            </div>                      
      
            <div class="col-md-12">

                <div class="col-md-4 espacio-tag2">
                 
                        <?php 

                            // Recorro los subRoles
                            $i_general = 0;
                            foreach($PruebaPauta as $PruebaPauta_Eje):
                                if ($i_general < round(count($PruebaPauta) / 3,0)) {
                                    ?>
                                        <div class="row">

                                                <?php 

                                                    if ($PruebaPauta_Eje->eje_tematico == "" or $PruebaPauta_Eje->eje_tematico == 0) {
                                                        ?>

                                                            <div class="col-md-12">

                                                                <a class="btn btn-inactivo2 tamano2 cero-pad eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" correcta="<?php echo $PruebaPauta_Eje->correcta; ?>" >
                                                                    <div class="col-xs-2 numeroP-inac">
                                                                        <?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                    </div>
                                                                    <div class="col-xs-8 respuestaP-inac">
                                                                        <?php echo $PruebaPauta_Eje->correcta; ?>
                                                                    </div>
                                                                    <div class="col-xs-2 ejeP-inac"> 
                                                                        <i class="fa fa-thumb-tack iconoT"></i>
                                                                    </div>


                                                                </a>

                                                            </div>

                                                        <?php
                                                    }else{

                                                        $clases_destino = [];
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";

                                                        $asignar_clase = "";
                                                        // Recorro los subRoles


                                                        ?>

                                                            <div class="col-md-12">
                                                                
                                                                <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                                    <div class="col-xs-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                    </div>
                                                                    <div class="col-xs-8 ejeP"><?php echo substr($PruebaPauta_Eje->ejes->nombre, 0, 15); ?></div>
                                                                    <div class="col-xs-2 respuestaP Prespuesta<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->correcta; ?></div>
                                                                  
                                                                </a>



                                                            </div>

                                                        <?php
                                                    }

                                                 ?>


                                        </div>




                                    <?php
                                    $i_general++;
                                }
                            endforeach; 

                        ?>

                </div>
                <div class="col-md-4 espacio-tag2">
                 
                        <?php 

                            // Recorro los subRoles
                            $i_general = 0;
                            foreach($PruebaPauta as $PruebaPauta_Eje):
                                if (($i_general >= round(count($PruebaPauta) / 3,0)) && $i_general < ((round(count($PruebaPauta) / 3,0) * 2))) {
                                    ?>
                                        <div class="row">

                                                <?php 

                                                    if ($PruebaPauta_Eje->eje_tematico == "" or $PruebaPauta_Eje->eje_tematico == 0) {
                                                        ?>

                                                            <div class="col-md-12">

                                                                <a class="btn btn-inactivo2 tamano2 cero-pad eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" correcta="<?php echo $PruebaPauta_Eje->correcta; ?>" >
                                                                    <div class="col-xs-2 numeroP-inac">
                                                                        <?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                    </div>
                                                                    <div class="col-xs-8 respuestaP-inac">
                                                                        <?php echo $PruebaPauta_Eje->correcta; ?>
                                                                    </div>
                                                                    <div class="col-xs-2 ejeP-inac"> 
                                                                        <i class="fa fa-thumb-tack iconoT"></i>
                                                                    </div>


                                                                </a>

                                                            </div>

                                                        <?php
                                                    }else{

                                                        $clases_destino = [];
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";

                                                        $asignar_clase = "";
                                                        // Recorro los subRoles
                                                        $i = 0;
                                                        foreach($PruebaEjetematicoRamo as $key => $PruebaEjetematico):

                                                            if ($PruebaEjetematico->id == $PruebaPauta_Eje->eje_tematico) {
                                                                $asignar_clase = $clases_destino[$key];
                                                            }
                                                            $i++;

                                                        endforeach; 

                                                        ?>

                                                            <div class="col-md-12">
                                                                
                                                                <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                                    <div class="col-xs-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                    </div>
                                                                    <div class="col-xs-8 ejeP"><?php echo substr($PruebaPauta_Eje->ejes->nombre, 0, 15); ?></div>
                                                                    <div class="col-xs-2 respuestaP Prespuesta<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->correcta; ?></div>
                                                                  
                                                                </a>



                                                            </div>

                                                        <?php
                                                    }

                                                 ?>


                                        </div>

                                    <?php
                                    
                                }
                                $i_general++;
                            endforeach; 

                        ?>

                </div>

                <div class="col-md-4 espacio-tag2">
                 
                        <?php 

                            // Recorro los subRoles
                            $i_general = 0;
                            foreach($PruebaPauta as $PruebaPauta_Eje):
                                if (($i_general >= ((round(count($PruebaPauta) / 3,0) * 2)))) {
                                    ?>
                                        <div class="row">

                                                <?php 

                                                    if ($PruebaPauta_Eje->eje_tematico == "" or $PruebaPauta_Eje->eje_tematico == 0) {
                                                        ?>

                                                            <div class="col-md-12">

                                                                <a class="btn btn-inactivo2 tamano2 cero-pad eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" correcta="<?php echo $PruebaPauta_Eje->correcta; ?>" >
                                                                    <div class="col-xs-2 numeroP-inac">
                                                                        <?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                    </div>
                                                                    <div class="col-xs-8 respuestaP-inac">
                                                                        <?php echo $PruebaPauta_Eje->correcta; ?>
                                                                    </div>
                                                                    <div class="col-xs-2 ejeP-inac"> 
                                                                        <i class="fa fa-thumb-tack iconoT"></i>
                                                                    </div>


                                                                </a>

                                                            </div>

                                                        <?php
                                                    }else{

                                                        $clases_destino = [];
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";
                                                        $clases_destino[] = "amarillo";
                                                        $clases_destino[] = "rojo";
                                                        $clases_destino[] = "verde";
                                                        $clases_destino[] = "pur";
                                                        $clases_destino[] = "mora";
                                                        $clases_destino[] = "verde2";

                                                        $asignar_clase = "";
                                                        // Recorro los subRoles
                                                        $i = 0;
                                                        foreach($PruebaEjetematicoRamo as $key => $PruebaEjetematico):

                                                            if ($PruebaEjetematico->id == $PruebaPauta_Eje->eje_tematico) {
                                                                $asignar_clase = $clases_destino[$key];
                                                            }
                                                            $i++;

                                                        endforeach; 

                                                        ?>

                                                            <div class="col-md-12">
                                                                
                                                                <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                                    <div class="col-xs-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                    </div>
                                                                    <div class="col-xs-8 ejeP"><?php echo substr($PruebaPauta_Eje->ejes->nombre, 0, 15); ?></div>
                                                                    <div class="col-xs-2 respuestaP Prespuesta<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->correcta; ?></div>
                                                                  
                                                                </a>



                                                            </div>

                                                        <?php
                                                    }

                                                 ?>


                                        </div>

                                    <?php
                                    
                                }
                                $i_general++;
                            endforeach; 

                        ?>

                </div>


                <div class="col-md-12" style="float: left;">

                </div>

            </div>
        


        </div>
    </div><!--isotope-->

</div>

<?php 

    $this->registerJs("

            $(\".eje_clase\").click(function(e){
                e.preventDefault();

                $(\".eje_clase\").removeClass().addClass('taggris eje_clase');
                $(this).removeClass().addClass($(this).attr( \"clase\" ) + ' eje_clase eje_seleccionado');
                
            
            });

            $(\".eje_final\").click(function(e){
                e.preventDefault();

                // pregunto si hay algúno de los ejes seleccionados


                if (!$(\".eje_clase\").hasClass('eje_seleccionado')){
                    alert('Tiene que seleccionar un Eje temático');
                }else{
                    

                    //pregunto si el boton ya tiene asignadas estas clases
                    if($(this).hasClass($(\".eje_seleccionado\").attr( \"clases_destino\" ))){
                        $(this).removeClass().addClass('btn btn-inactivo2 tamano2 cero-pad eje_final').html('<div class=\"col-xs-2 numeroP-inac\">' + $(this).attr( \"numeropregunta\" ) + '</div><div class=\"col-xs-8 respuestaP-inac\">' + $(this).attr( \"correcta\" ) + '</div><div class=\"col-xs-2 ejeP-inac\"><i class=\"fa fa-thumb-tack iconoT\"></i></div>' );

                        //por ajax le quito el eje a esta pregunta



                    }else{

                        if($(\".eje_seleccionado\").attr( \"nombre_eje\" ).length > 15){
                            // limpio la clase y asigno la nueva
                            $(this).removeClass().addClass('btn tamano eje_final btn-' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '  tamano2').html('<div class=\"col-xs-2 numeroP Pnumero' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\> ' + $(this).attr( \"numeropregunta\" ) + '</div><div class=\"col-xs-8 ejeP\">' + $(\".eje_seleccionado\").attr( \"nombre_eje\" ).substring(0, 15) + '</div><div class=\"col-xs-2 respuestaP Prespuesta' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\>' + $(this).attr( \"correcta\" ) + '</div>' );

                        }else{
                            // limpio la clase y asigno la nueva
                            $(this).removeClass().addClass('btn tamano eje_final btn-' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '  tamano2').html('<div class=\"col-xs-2 numeroP Pnumero' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\> ' + $(this).attr( \"numeropregunta\" ) + '</div><div class=\"col-xs-8 ejeP\">' + $(\".eje_seleccionado\").attr( \"nombre_eje\" ).substring(0, 15) + '</div><div class=\"col-xs-2 respuestaP Prespuesta' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\>' + $(this).attr( \"correcta\" ) + '</div>' );

                        }



                    }


                    //  en este por ajax le asigno este eje a esta pregunta 


                    var _url;
                    _url='asignar-eliminar-ejes-tematicos';
                    $.ajax({
                        url: _url,
                        data: {id_eje:$(\".eje_seleccionado\").attr( \"id_eje\" ),numero_pregunta:$(this).attr( \"numeropregunta\" ),pauta_id:$(this).attr( \"idpauta\" )},
                        'dataType':'json',
                        'type':'POST',
                        'success':function(data)
                        {
                            if(data.estado == 1 ){

                                //alert('OK');

                            }

                        } ,
                        'cache':false});
                    return false;


                }
                
            
            });


    "); 

?>







