<?php

use yii\helpers\Html;
use common\models\PruebaEjeTematico;

?>

<div class=" isotope-item" style="">
    <div class="titulo2">
        <div class="">

        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active">
            <div class="row">

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



                    <?php 
                        if (($model->combinar_ejes_ciencias == 1)) {

                    ?>
                        <div class="TituloDeAsignaturasTags">
                            Biología
                        </div>

                        <ul class="tags">

                            <?php 

                                $PruebaEjeTematicoBio = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>4])->orderBy('nombre')->all();

                                $i = 0;
                                foreach($PruebaEjeTematicoBio as $key => $PruebaEje):
                                    ?>
                                        <li><?= Html::a($PruebaEje->nombre, [''], ['class'=>$clases[$key],'clases_destino'=>$clases_destino[$key],'clase'=>$clases[$key],'id_eje'=>$PruebaEje->id,'nombre_eje'=>$PruebaEje->nombre]) ?></li>
                                    <?php
                                    $i++;

                                endforeach; 

                            ?>
                            <br><br><br>

                        </ul>



                        <div class="TituloDeAsignaturasTags">
                            Física
                        </div>

                        <ul class="tags">

                            <?php 

                                $PruebaEjeTematicoFis = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>6])->orderBy('nombre')->all();

                                $i = 0;
                                foreach($PruebaEjeTematicoFis as $key => $PruebaEje):
                                    ?>
                                        <li><?= Html::a($PruebaEje->nombre, [''], ['class'=>$clases[$key],'clases_destino'=>$clases_destino[$key],'clase'=>$clases[$key],'id_eje'=>$PruebaEje->id,'nombre_eje'=>$PruebaEje->nombre]) ?></li>
                                    <?php
                                    $i++;

                                endforeach; 

                            ?>

                            
                            <br><br><br>

                        </ul>

                        <div class="TituloDeAsignaturasTags">
                            Qímica
                        </div>
                        <ul class="tags">

                            <?php 

                                $PruebaEjeTematicoQui = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>5])->orderBy('nombre')->all();

                                $i = 0;
                                foreach($PruebaEjeTematicoQui as $key => $PruebaEje):
                                    ?>
                                        <li><?= Html::a($PruebaEje->nombre, [''], ['class'=>$clases[$key],'clases_destino'=>$clases_destino[$key],'clase'=>$clases[$key],'id_eje'=>$PruebaEje->id,'nombre_eje'=>$PruebaEje->nombre]) ?></li>
                                    <?php
                                    $i++;

                                endforeach; 

                            ?>
                            <br><br><br>
                        </ul>
                    <?php 

                        }else{

                    ?>

                        <div class="barratituloetiquetas">
                            <span> <?= $model->subRamo->nombre ?></span>                
                        </div>
                        <div class="">
                            <ul class="tags">

                                <?php 

                                    $i = 0;
                                    foreach($PruebaEjeTematico as $key => $PruebaEje):
                                        ?>
                                            <li><?= Html::a($PruebaEje->nombre, [''], ['class'=>$clases[$key],'clases_destino'=>$clases_destino[$key],'clase'=>$clases[$key],'id_eje'=>$PruebaEje->id,'nombre_eje'=>$PruebaEje->nombre]) ?></li>
                                        <?php
                                        $i++;

                                    endforeach; 

                                ?>

                            </ul>
                        </div>


                    <?php 
                            
                        }

                    ?>

                </div>  

            </div>                      
      
            <div class="row">
                <div class="col-12"></div>
                <div class="col-4 espacio-tag2">
                 
                        <?php 

                            // Recorro los subRoles
                            $i_general = 0;
                            foreach($PruebaPauta as $PruebaPauta_Eje):
                                if ($i_general < round(count($PruebaPauta) / 3,0)) {
                                    ?>


                                    <?php 

                                        if ($PruebaPauta_Eje->eje_tematico == "" or $PruebaPauta_Eje->eje_tematico == 0) {
                                            ?>

                                                <div class="">                                                
                                                    <div class="">
                                                    <a class="btn btn-inactivo2 tamano2 cero-pad eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" correcta="<?php echo $PruebaPauta_Eje->correcta; ?>" >
                                                            <div class="row"> 
                                                                <div class="col-2 numeroP Pnumeroverde2">
                                                                <?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                </div>
                                                                <div class="col-8 ejeP"></div>
                                                                <div class="col-2 respuestaP Prespuestaverde2">
                                                                    <?php echo $PruebaPauta_Eje->correcta; ?>
                                                                </div>
                                                            </div>
                                                        </a>
                                                    </div>
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


                                            if (($model->combinar_ejes_ciencias == 1)) {
                                                // Recorro los subRoles
                                                $i = 0;
                                                foreach($PruebaEjeTematicoBio as $key => $PruebaEje):

                                                    if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                        $asignar_clase = $clases_destino[$key];
                                                    }
                                                    $i++;

                                                endforeach; 

                                                // Recorro los subRoles
                                                $i = 0;
                                                foreach($PruebaEjeTematicoQui as $key => $PruebaEje):

                                                    if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                        $asignar_clase = $clases_destino[$key];
                                                    }
                                                    $i++;

                                                endforeach; 

                                                // Recorro los subRoles
                                                $i = 0;
                                                foreach($PruebaEjeTematicoFis as $key => $PruebaEje):

                                                    if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                        $asignar_clase = $clases_destino[$key];
                                                    }
                                                    $i++;

                                                endforeach; 

                                            }else{
                                                // Recorro los subRoles
                                                $i = 0;
                                                foreach($PruebaEjeTematico as $key => $PruebaEje):

                                                    if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                        $asignar_clase = $clases_destino[$key];
                                                    }
                                                    $i++;

                                                endforeach; 
                                            }


                                            

                                            ?>


                                                <div class="">                                                
                                                    <div class="">
                                                        <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                            <div class="row"> 
                                                                <div class="col-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                </div>
                                                                <div class="col-8 ejeP"><?php echo substr($PruebaPauta_Eje->ejes->nombre, 0, 15); ?></div>
                                                                <div class="col-2 respuestaP Prespuesta<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->correcta; ?></div>
                                                        
                                                            </div>
                                                        </a>
                                                    </div>
                                                </div>

                                            <?php
                                        }

                                    ?>



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


                                    if ($PruebaPauta_Eje->eje_tematico == "" or $PruebaPauta_Eje->eje_tematico == 0) {
                                        ?>

                                            <div class="">                                                
                                                <div class="">
                                                <a class="btn btn-inactivo2 tamano2 cero-pad eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" correcta="<?php echo $PruebaPauta_Eje->correcta; ?>" >
                                                        <div class="row"> 
                                                            <div class="col-2 numeroP Pnumeroverde2">
                                                            <?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                            </div>
                                                            <div class="col-8 ejeP"></div>
                                                            <div class="col-2 respuestaP Prespuestaverde2">
                                                                <?php echo $PruebaPauta_Eje->correcta; ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
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
                                        if (($model->combinar_ejes_ciencias == 1)) {
                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematicoBio as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 

                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematicoQui as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 

                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematicoFis as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 

                                        }else{
                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematico as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 
                                        }

                                        ?>

                                            <div class="">                                                
                                                <div class="">
                                                    <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                        <div class="row"> 
                                                            <div class="col-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                            </div>
                                                            <div class="col-8 ejeP"><?php echo substr($PruebaPauta_Eje->ejes->nombre, 0, 15); ?></div>
                                                            <div class="col-2 respuestaP Prespuesta<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->correcta; ?></div>
                                                    
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php
                                    }

                                    
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

                                    if ($PruebaPauta_Eje->eje_tematico == "" or $PruebaPauta_Eje->eje_tematico == 0) {
                                        ?>

                                            <div class="">                                                
                                                <div class="">
                                                <a class="btn btn-inactivo2 tamano2 cero-pad eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" correcta="<?php echo $PruebaPauta_Eje->correcta; ?>" >
                                                        <div class="row"> 
                                                            <div class="col-2 numeroP Pnumeroverde2">
                                                            <?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                            </div>
                                                            <div class="col-8 ejeP"></div>
                                                            <div class="col-2 respuestaP Prespuestaverde2">
                                                                <?php echo $PruebaPauta_Eje->correcta; ?>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
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
                                        if (($model->combinar_ejes_ciencias == 1)) {
                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematicoBio as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 

                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematicoQui as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 

                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematicoFis as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 

                                        }else{
                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaEjeTematico as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->eje_tematico) {
                                                    $asignar_clase = $clases_destino[$key];
                                                }
                                                $i++;

                                            endforeach; 
                                        }
                                        ?>

                                            <div class="">                                                
                                                <div class="">
                                                    <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                        <div class="row"> 
                                                            <div class="col-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                            </div>
                                                            <div class="col-8 ejeP"><?php echo substr($PruebaPauta_Eje->ejes->nombre, 0, 15); ?></div>
                                                            <div class="col-2 respuestaP Prespuesta<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->correcta; ?></div>
                                                    
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                        <?php
                                    }

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
                        $(this).removeClass().addClass('btn btn-inactivo2 tamano2 cero-pad eje_final').html('<div class=\"col-2 numeroP-inac\">' + $(this).attr( \"numeropregunta\" ) + '</div><div class=\"col-8 respuestaP-inac\">' + $(this).attr( \"correcta\" ) + '</div><div class=\"col-2 ejeP-inac\"><i class=\"fa fa-thumb-tack iconoT\"></i></div>' );

                        //por ajax le quito el eje a esta pregunta



                    }else{

                        if($(\".eje_seleccionado\").attr( \"nombre_eje\" ).length > 15){
                            // limpio la clase y asigno la nueva
                            $(this).removeClass().addClass('btn tamano eje_final btn-' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '  tamano2').html('<div class=\"row\"><div class=\"col-2 numeroP Pnumero' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\> ' + $(this).attr( \"numeropregunta\" ) + '</div><div class=\"col-8 ejeP\">' + $(\".eje_seleccionado\").attr( \"nombre_eje\" ).substring(0, 15) + '</div><div class=\"col-2 respuestaP Prespuesta' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\>' + $(this).attr( \"correcta\" ) + '</div></div>' );

                        }else{
                            // limpio la clase y asigno la nueva
                            $(this).removeClass().addClass('btn tamano eje_final btn-' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '  tamano2').html('<div class=\"row\"><div class=\"col-2 numeroP Pnumero' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\> ' + $(this).attr( \"numeropregunta\" ) + '</div><div class=\"col-8 ejeP\">' + $(\".eje_seleccionado\").attr( \"nombre_eje\" ).substring(0, 15) + '</div><div class=\"col-2 respuestaP Prespuesta' + $(\".eje_seleccionado\").attr( \"clases_destino\" ) + '\"\>' + $(this).attr( \"correcta\" ) + '</div></div>' );

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







