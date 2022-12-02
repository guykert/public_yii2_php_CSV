<?php

use yii\helpers\Html;

use common\models\PruebaSubEjeTematico;

?>

<div class=" isotope-item" style="">
    <div class="titulo2">
        <div class="">

        </div>
    </div>

    <div class="tab-content">
        <div class="tab-pane active">
            <div class="row">

                <div class="col-12">
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


                    ?>



                    <?php 



                        if (($model->combinar_ejes_ciencias == 1)) {

                            $PruebaSubEjeTematico = PruebaSubEjeTematico::find()->where(['activo'=>true])->orderBy('nombre')->all();

                    ?>
                        <div class="barratituloetiquetas">
                            Biología
                        </div>

                        <ul class="tags">

                            <?php 

                                // foreach($PruebaSubEjeTematico as $key => $PruebaEjeSub):

                                //     var_dump($key);
                                //     echo "<br>";

                                // endforeach; 

                                // exit;


                                $i = 0;
                                foreach($PruebaSubEjeTematico as $key => $PruebaEjeSub):

                                    if ($PruebaEjeSub->ramo_id == 4) {
                                        ?>
                                            <li><?= Html::a($PruebaEjeSub->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjeSub->id,'nombre_eje'=>$PruebaEjeSub->nombre]) ?></li>

                                        <?php
                                        $i++;
                                    }
                                endforeach; 


                            ?>
                            <br><br><br>

                        </ul>

                        <br><br><br>



                        <div class="barratituloetiquetas">
                            Física
                        </div>

                        <ul class="tags">

                            <?php 

                                

                                $i = 0;
                                foreach($PruebaSubEjeTematico as $key => $PruebaEjeSub):
                                    if ($PruebaEjeSub->ramo_id == 6) {
                                        ?>
                                            <li><?= Html::a($PruebaEjeSub->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjeSub->id,'nombre_eje'=>$PruebaEjeSub->nombre]) ?></li>

                                        <?php
                                        $i++;
                                    }
                                endforeach; 

                            ?>

                            
                            <br><br><br>

                        </ul>

                        <div class="barratituloetiquetas">
                            Qímica
                        </div>
                        <ul class="tags">

                            <?php 

                                

                                $i = 0;
                                foreach($PruebaSubEjeTematico as $key => $PruebaEjeSub):
                                    if ($PruebaEjeSub->ramo_id == 5) {
                                        ?>
                                            <li><?= Html::a($PruebaEjeSub->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjeSub->id,'nombre_eje'=>$PruebaEjeSub->nombre]) ?></li>

                                        <?php
                                        $i++;
                                    }
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
                                    foreach($PruebaSubEjeTematico as $key => $PruebaEjeSub):



                                        ?>
                                            <li><?= Html::a($PruebaEjeSub->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjeSub->id,'nombre_eje'=>$PruebaEjeSub->nombre]) ?></li>
                                        <?php



                                        $i++;

                                        if($i == 6){
                                            $i = 0;
                                        }


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

                                        if ($PruebaPauta_Eje->sub_eje_tematico == "" or $PruebaPauta_Eje->sub_eje_tematico == 0) {
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


                                            $asignar_clase = "";
                                            // Recorro los subRoles

                                            // Recorro los subRoles
                                            $i = 0;
                                            foreach($PruebaSubEjeTematico as $key => $PruebaEje):

                                                if ($PruebaEje->id == $PruebaPauta_Eje->sub_eje_tematico) {
                                                    $asignar_clase = $clases_destino[$i];
                                                }
                                                $i++;


                                                if($i == 6){
                                                    $i = 0;
                                                }

                                            endforeach; 


                                            ?>


                                                <div class="">                                                
                                                    <div class="">
                                                        <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                            <div class="row"> 
                                                                <div class="col-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                                </div>
                                                                <div class="col-8 ejeP"><?php echo substr($PruebaPauta_Eje->subEjes->nombre, 0, 15); ?></div>
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


                                    if ($PruebaPauta_Eje->sub_eje_tematico == "" or $PruebaPauta_Eje->sub_eje_tematico == 0) {
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


                                        $asignar_clase = "";
                                        // Recorro los subRoles
                                        $i = 0;



                                        foreach($PruebaSubEjeTematico as $key => $PruebaEje):

                                            if ($PruebaEje->id == $PruebaPauta_Eje->sub_eje_tematico) {
                                                $asignar_clase = $clases_destino[$i];
                                            }
                                            $i++;


                                            if($i == 6){
                                                $i = 0;
                                            }

                                        endforeach; 

                                        ?>

                                            <div class="">                                                
                                                <div class="">
                                                    <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                        <div class="row"> 
                                                            <div class="col-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                            </div>
                                                            <div class="col-8 ejeP"><?php echo substr($PruebaPauta_Eje->subEjes->nombre, 0, 15); ?></div>
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

                                    if ($PruebaPauta_Eje->sub_eje_tematico == "" or $PruebaPauta_Eje->sub_eje_tematico == 0) {
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


                                        $asignar_clase = "";
                                        // Recorro los subRoles
                                        $i = 0;
                                        foreach($PruebaSubEjeTematico as $key => $PruebaEje):

                                            if ($PruebaEje->id == $PruebaPauta_Eje->sub_eje_tematico) {
                                                $asignar_clase = $clases_destino[$i];
                                            }
                                            $i++;


                                            if($i == 6){
                                                $i = 0;
                                            }

                                        endforeach; 

                                        ?>

                                            <div class="">                                                
                                                <div class="">
                                                    <a class="btn tamano btn-<?php echo $asignar_clase; ?> tamano2 eje_final" idpauta="<?php echo $PruebaPauta_Eje->id; ?>" numeropregunta="<?php echo $PruebaPauta_Eje->numero_pregunta; ?>" textoprevio="P : <?php echo $PruebaPauta_Eje->numero_pregunta; ?> C : <?php echo $PruebaPauta_Eje->correcta; ?>">
                                                        <div class="row"> 
                                                            <div class="col-2 numeroP Pnumero<?php echo $asignar_clase; ?>"><?php echo $PruebaPauta_Eje->numero_pregunta; ?>
                                                            </div>
                                                            <div class="col-8 ejeP"><?php echo substr($PruebaPauta_Eje->subEjes->nombre, 0, 15); ?></div>
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









