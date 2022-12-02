<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use kartik\widgets\Select2;
use common\models\Ramo;
use kartik\widgets\FileInput;
use common\models\PruebaCategoria;

?>
    <div class="fondo-form col-md-12">
        <div class="materiales-form">
            <?php $form = ActiveForm::begin(
                    [
                    'enableAjaxValidation' => false,
                    'enableClientValidation' => false,
                    'options' => ['enctype' => 'multipart/form-data']
                    ]
                    
                ); 
            $template = ' <div class="form-group">
            {label}

                        {input}
                    </div>';// falta {hint}\n{error}
                $inputSize = '20';


            
            ?>  



        <div class="card">

            <div class="card-headermorado content-center">

                <div class="row">

                    <div class="col-md-10">
                        <h5> Sub Ejes Temáticos</h5>
                    </div>

                </div>

            </div>


            <div  id="resultado_ajax">

        


                <div>
                    <div>
                        <div class="row">

                            <div class="col-md-12">
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
                                    <div class="titulocajainterior">
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



                                    <div class="titulocajainterior">
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

                                    <div class="titulocajainterior">
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

                                    <div class="titulocajainterior">
                                        <span> <i class="fa fa-caret-right "></i> <?= $model->subRamo->nombre ?></span>                
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

            <div class="card-footer ">

                <div class="row vertical-middle text-center" >
                    <div class="col-sm-4 col-md-8 col-lg-4 text-center">

                        <?= Html::a('<i class="fa fa-chevron-left "></i> Volver', ['config-preguntas-sub-ejes-ver','prueba_id' => $model->id,'id' => $id,'fecha' => $fecha], ['class' => 'btn btnprimario1 float-left']);?>

                    </div>
                    <div class="col-sm-4 col-md-4 col-lg-4 text-center">
                        
                        <?= Html::a('<i class="fa fa-check "></i> Finalizar', ['index','id' => $id,'fecha' => $fecha], ['class' => 'btn btnfinalizar1']);?>

                    </div>
                    <div class="col-sm-4 hidden-md col-lg-4 text-center">
                        
                        <?= Html::a('Continuar <i class="fa fa-chevron-right "></i>', ['config-preguntas-habilidad','prueba_id' => $model->id,'id' => $id,'fecha' => $fecha], ['class' => 'btn btnprimario1 float-right']);?>
    
                    </div>
                </div>


                

                

            </div>

            <?php ActiveForm::end(); ?>
    


        </div>

    </div>
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
