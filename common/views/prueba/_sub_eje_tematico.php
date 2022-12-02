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

                            $PruebaEjeTematico = PruebaEjeTematico::find()->where(['activo'=>true])->orderBy('nombre')->all();

                    ?>
                        <div class="barratituloetiquetas">
                            Biología
                        </div>

                        <ul class="tags">

                            <?php 

                                $i = 0;
                                foreach($PruebaEjeTematico as $key => $PruebaEjetematico):
                                    if ($PruebaEjetematico->ramo_id == 4) {
                                        ?>
                                            <li><?= Html::a($PruebaEjetematico->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjetematico->id,'nombre_eje'=>$PruebaEjetematico->nombre]) ?></li>

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
                                foreach($PruebaEjeTematico as $key => $PruebaEjetematico):
                                    if ($PruebaEjetematico->ramo_id == 6) {
                                        ?>
                                            <li><?= Html::a($PruebaEjetematico->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjetematico->id,'nombre_eje'=>$PruebaEjetematico->nombre]) ?></li>
                                        <?php
                                        $i++;
                                    }
                                endforeach; 

                            ?>

                            
                            <br><br><br>

                        </ul>
                        <br><br><br>

                        <div class="barratituloetiquetas">
                            Qímica
                        </div>
                        <ul class="tags">

                            <?php 

                                $i = 0;
                                foreach($PruebaEjeTematico as $key => $PruebaEjetematico):
                                    if ($PruebaEjetematico->ramo_id == 5) {
                                        ?>
                                            <li><?= Html::a($PruebaEjetematico->nombre, [''], ['class'=>$clases[$i],'clases_destino'=>$clases_destino[$i],'clase'=>$clases[$i],'id_eje'=>$PruebaEjetematico->id,'nombre_eje'=>$PruebaEjetematico->nombre]) ?></li>
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
                                    foreach($PruebaEjeTematico as $key => $PruebaEjetematico):
                                        ?>
                                            <li><?= Html::a($PruebaEjetematico->nombre, [''], ['class'=>$clases[$key],'clases_destino'=>$clases_destino[$key],'clase'=>$clases[$key],'id_eje'=>$PruebaEjetematico->id,'nombre_eje'=>$PruebaEjetematico->nombre]) ?></li>
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
      

      
            <div class="row contenedor_preguntas">


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

                cargarEstructuraTab('sub-eje-tematico-preguntas','#contenedor_preguntas');
                
            
            });

            function cargarEstructuraTab(tabNombre,activeTab) {

                $(activeTab).fadeOut().empty();

                $.ajax({
                    url: tabNombre,
                    data:{id:" . $model->id . ",id_eje:$(\".eje_seleccionado\").attr( \"id_eje\" )},
                    beforeSend:function(){
                        $('.contenedor_preguntas').html('<div class=\"sk-circle11 sk-child\"></div>');
                    },
                    success: function(data) {
                        $('.contenedor_preguntas').html('');
                        $('.contenedor_preguntas').fadeOut().empty();
                        $('.contenedor_preguntas').append(data).fadeIn();

                        return true;
                    }
                });


            }

    "); 

?>







