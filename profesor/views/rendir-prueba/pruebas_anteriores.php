<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/home']];
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

            <div class="row ">
                <div class="col-xs-12 col-md-12 sacarpadingleftright">

                    <div class="Titulocajaparatodo">
                        <span>
                            <i class="fa fa-file"></i> 
                            Prueba: <?php echo $nombre; ?> 
                        </span>
                    </div>

                    <?php
                        $i2=1;
                        $prueba_incompleta = 0;
                        foreach ($PruebasAlumno as $key => $PruebaAlumno) {

                            if(!$PruebaAlumno->fecha_termino){

                                $prueba_incompleta = $PruebaAlumno->id;

                            }

                            ?>

                                <div class="row fondocuerpoindicadores">

                                    <div class="col-md-1 sacarpadingleftrightmenos">
                                        <div class="ensayocarpeta">

                                            <?php
                                                if($PruebaAlumno->fecha_termino){
                                                    ?>

                                                        <img src="/alumno/img/iconos/intentos.svg" class="img" alt="#">

                                                    <?php
                                                }else{

                                                    ?>

                                                        <img src="/alumno/img/iconos/intentos2.svg" class="img" alt="#">

                                                    <?php

                                                }
                                            ?>
                                            
                                        </div>
                                        <div class="cajatitulocontenedores">
                                            <span class="bajadacarpetastextosuperior"> Intentos:</span>
                                            <div class="separadorfinocarpetas"></div>
                                            <div class="bajadacarpetastexto"><?php echo $i2; ?></div>
                                        </div>
                                    </div>

                                    <div class="row col-md-8 sacarpadingleftright sacarpadingleftrightmenos">

                                        <div class="col-md-2 sacarpadingleftrightmenos">
                                            <div class="ensayocarpeta">
                                                <img src="/alumno/img/iconos/calendarioinicio.svg" class="img" alt="#">
                                            </div>
                                            <div class="cajatitulocontenedoresfecha">
                                                <span class="bajadacarpetastextosuperior"> inicio:</span>
                                                <div class="separadorfinocarpetas"></div>
                                                <div class="bajadacarpetastextofecha"> 

                                                    <?php 
                                                        
                                                        if($PruebaAlumno->fecha_inicio){ 
                                                        
                                                            echo date('d/m/Y', strtotime($PruebaAlumno->fecha_inicio));

                                                            echo "<br>";

                                                            echo date('H:i:s', strtotime($PruebaAlumno->fecha_inicio));

                                                        }else{

                                                            echo "-";

                                                        }
                                                        
                                                    ?>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-2 sacarpadingleftrightmenos">
                                            <div class="ensayocarpeta">

                                                <?php

                                                    if($PruebaAlumno->fecha_termino){
                                                        ?>

                                                            <img src="/alumno/img/iconos/calendariofinal.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/alumno/img/iconos/calendariofinal2.svg" class="img" alt="#">

                                                        <?php

                                                    }
                                                ?>

                                            </div>

                                            <?php 
                                            
                                                if($PruebaAlumno->fecha_termino){ 
                                                
                                                    ?>

                                                        <div class="cajatitulocontenedoresfecha">
                                                            <span class="bajadacarpetastextosuperior"> Termino:</span>
                                                            <div class="separadorfinocarpetas"></div>
                                                            <div class="bajadacarpetastextofecha"> 

                                                                <?php

                                                                    echo date('d/m/Y', strtotime($PruebaAlumno->fecha_termino));

                                                                    echo "<br>";

                                                                    echo date('H:i:s', strtotime($PruebaAlumno->fecha_termino));

                                                                ?>

                                                            </div>
                                                        </div>
                                                        
                                                    <?php


                                                }else{
                                                    ?>

                                                        <div class="cajatitulocontenedores">
                                                            <span class="bajadacarpetastextosuperior"> Termino:</span>
                                                            <div class="separadorfinocarpetas"></div>
                                                            <div class="bajadacarpetastexto"> 

                                                                <?php
                                                                    echo "-";
                                                                ?>

                                                            </div>
                                                        </div>
                                                        
                                                    <?php
                                                }
                                                
                                            ?>


                                        </div> 

                                        <div class="col-xs-2 col-md-2 sacarpadingleftrightmenos">
                                            <div class="ensayocarpeta">

                                            <?php

                                                if($PruebaAlumno->fecha_termino){
                                                    ?>

                                                        <img src="/alumno/img/iconos/ensayo.svg" class="img" alt="#">

                                                    <?php
                                                }else{

                                                    ?>

                                                        <img src="/alumno/img/iconos/ensayo2.svg" class="img" alt="#">

                                                    <?php

                                                }
                                                
                                            ?>

                                            </div>
                                            <div class="cajatitulocontenedores">
                                                <span class="bajadacarpetastextosuperior"> Tu Puntaje:</span>
                                                <div class="separadorfinocarpetas"></div>
                                                <div class="bajadacarpetastexto"> 
                                                    
                                                    <?php 

                                                        if($PruebaAlumno->fecha_termino && $PruebaAlumno->nota){ 
                                                            
                                                            echo $PruebaAlumno->nota;

                                                        }else{

                                                            echo "-";

                                                        }
                                                        
                                                        
                                                    ?>

                                                </div>
                                            </div>

                                        </div>  

                                        <div class="col-xs-2 col-md-2 sacarpadingleftrightmenos">
                                            <div class="buenascarpeta">

                                            <?php

                                                if($PruebaAlumno->fecha_termino){
                                                    ?>

                                                        <img src="/alumno/img/iconos/lupabuena.svg" class="img" alt="#">

                                                    <?php
                                                }else{

                                                    ?>

                                                        <img src="/alumno/img/iconos/lupabuena2.svg" class="img" alt="#">

                                                    <?php

                                                }
                                                
                                            ?>

                                            </div>
                                            <div class="cajatitulocontenedores">
                                                <span class="bajadacarpetastextosuperior">  Buenas:</span>
                                            <div class="separadorfinocarpetas"></div>
                                                <div class="bajadacarpetastexto">

                                                    <?php 

                                                        if($PruebaAlumno->fecha_termino){ 

                                                            echo $PruebaAlumno->buenas;

                                                        }else{

                                                            echo "-";

                                                        }

                                                    ?>

                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xs-2 col-md-2 sacarpadingleftrightmenos">

                                            <div class="malascarpeta">

                                                <?php

                                                    if($PruebaAlumno->fecha_termino){
                                                        ?>

                                                            <img src="/alumno/img/iconos/lupamala.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/alumno/img/iconos/lupamala2.svg" class="img" alt="#">

                                                        <?php

                                                    }
                                                    
                                                ?>

                                            </div>
                                            <div class="cajatitulocontenedores">
                                            <span class="bajadacarpetastextosuperior"> Malas:</span>
                                            <div class="separadorfinocarpetas"></div>
                                                <div class="bajadacarpetastexto"> 

                                                    <?php 

                                                        if($PruebaAlumno->fecha_termino){ 

                                                            echo $PruebaAlumno->malas;

                                                        }else{

                                                            echo "-";

                                                        }

                                                    ?>

                                                </div>
                                            </div>
                                        </div> 

                                        <div class="col-xs-2 col-md-2 sacarpadingleftrightmenos">
                                            <div class="omitidascarpeta">

                                                <?php

                                                    if($PruebaAlumno->fecha_termino){
                                                        ?>

                                                            <img src="/alumno/img/iconos/lupaomitida.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/alumno/img/iconos/lupaomitida2.svg" class="img" alt="#">

                                                        <?php

                                                    }

                                                ?>

                                            </div>
                                            <div class="cajatitulocontenedores">
                                                <span class="bajadacarpetastextosuperior"> Omitidas:</span>
                                                <div class="separadorfinocarpetas"></div>
                                                <div class="bajadacarpetastexto">

                                                    <?php 

                                                        if($PruebaAlumno->fecha_termino){ 

                                                            echo $PruebaAlumno->omitidas;

                                                        }else{

                                                            echo "-";

                                                        }

                                                    ?>

                                                </div>
                                            </div>

                                        </div>  

                                    </div>

                                    <div class="row col-md-3 sacarpadingleftcarpetas sacarpadingleftrightmenos">

                                        <div class="col-xs-6 col-md-6 sacarpadingleftrightmenos">
                                            <div class="solucionariocarpeta">

                                                <?php

                                                    if($PruebaAlumno->fecha_termino){
                                                        ?>

                                                            <img src="/alumno/img/iconos/solucionario.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/alumno/img/iconos/solucionario2.svg" class="img" alt="#">

                                                        <?php

                                                    }

                                                ?>

                                            </div>

                                            <?php 
                                            
                                                if($PruebaAlumno->fecha_termino){ 
                                                
                                                    ?>

                                                        <div class="cajatitulocontenedores">
                                                            <span class="bajadacarpetastextosuperior"> Solucionarios:</span>
                                                            <div class="separadorfinocarpetas"></div>

                                                            <?php 

                                                                if($PruebaAlumno->fecha_termino){

                                                                    echo Html::a('

                                                                    <i class="fa fa-angle-right"></i>  Ver

                                                                    ', ['/solucionario','prueba_id'=>$prueba_id,'prueba_alumno'=>$PruebaAlumno->id,'curso_id'=>$curso_id], ['class'=>'marginbtngris btngris']);


                                                                }else{

                                                                    echo "-";

                                                                }

                                                            ?>

                                                        </div>
                                                        
                                                    <?php


                                                }else{
                                                    ?>

                                                        <div class="cajatitulocontenedores">
                                                            <span class="bajadacarpetastextosuperior"> Solucionarios:</span>
                                                            <div class="separadorfinocarpetas"></div>
                                                            <div class="bajadacarpetastexto"> 

                                                                <?php
                                                                    echo "-";
                                                                ?>

                                                            </div>
                                                        </div>
                                                        
                                                    <?php
                                                }
                                                
                                            ?>



                                            
                                        </div>  

                                        <div class="col-xs-6 col-md-6 sacarpadingleftrightmenos">
                                            <div class="ejetematicocarpeta">

                                                <?php

                                                    if($PruebaAlumno->fecha_termino){
                                                        ?>

                                                            <img src="/alumno/img/iconos/ejetematico.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/alumno/img/iconos/ejetematico2.svg" class="img" alt="#">

                                                        <?php

                                                    }

                                                ?>

                                            </div>

                                            <?php 
                                            
                                                if($PruebaAlumno->fecha_termino){ 
                                                
                                                    ?>

                                                        <div class="cajatitulocontenedores">
                                                            <span class="bajadacarpetastextosuperior"> Eje Tematico:</span>
                                                            <div class="separadorfinocarpetas"></div>

                                                            <?php 

                                                                if($PruebaAlumno->fecha_termino){

                                                                    echo Html::a('

                                                                    <i class="fa fa-angle-right"></i>  Ver

                                                                    ', ['/grafico','prueba_id'=>$prueba_id,'prueba_alumno'=>$PruebaAlumno->id,'curso_id'=>$curso_id], ['class'=>'marginbtngris btngris']);


                                                                }else{

                                                                    echo "-";

                                                                }

                                                            ?>


                                                        </div>
                                                        
                                                    <?php


                                                }else{
                                                    ?>

                                                        <div class="cajatitulocontenedores">
                                                            <span class="bajadacarpetastextosuperior"> Eje Tematico:</span>
                                                            <div class="separadorfinocarpetas"></div>
                                                            <div class="bajadacarpetastexto"> 

                                                                <?php
                                                                    echo "-";
                                                                ?>

                                                            </div>
                                                        </div>
                                                        
                                                    <?php
                                                }
                                                
                                            ?>




                                        </div>  

                                    </div> 




                                </div>  

                            <?php
                            $i2++;
                        }

                    ?>


                </div>
            </div>  

            

            <br>
            <br>



            <br>


            <div class="row">
                <div class="col-xs-4 col-md-4"></div>                                        

                <div class="col-xs-2 col-md-2 sacarpadingleftrightmenos">

                    <?php

                        echo Html::a('<i class="fa fa-reply"></i> VOLVER

                        ', ['/home','curso_id'=>$curso_id], ['class'=>'btn-celeste']);

                    ?>

                </div>

                <div class="col-xs-2 col-md-2 sacarpadingleftrightmenos">

                    <?php


                        if($prueba_incompleta == 0){
                            echo Html::a('

                            <i class="fa fa-plus"></i> NUEVO INTENTO 
    
                            ', ['rendir','prueba_id'=>$prueba_id,'curso_id'=>$curso_id], ['class'=>'btn-azul']);
                        }else{

                            if($Prueba->cantidad_intentos >= count($PruebasAlumno)){

                                echo Html::a('

                                <i class="fa fa-plus"></i> CONTINUAR 
        
                                ', ['rendir','prueba_id'=>$prueba_id,'curso_id'=>$curso_id], ['class'=>'btn-azul']);

                            }


                        }



                    ?>

                </div>

                <div class="col-xs-4 col-md-4"></div>
            </div>
            <br>
        </div>

    </div>

    <br>

    </main>

</div>
