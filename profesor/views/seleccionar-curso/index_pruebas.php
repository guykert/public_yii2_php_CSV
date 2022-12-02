<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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

                <div class="row ">
                    <div class="col-xs-12 col-md-12 sacarpadingleftright">



                        <?php
                            $i2=1;
                            $prueba_incompleta = 0;


                            foreach ($Pruebas as $key => $Prueba) {

                                ?>

                                    <div class="Titulocajaparatodo">
                                        <span>
                                            <i class="fa fa-file"></i> 
                                            Pruebas : <?php echo $Prueba['nombre']; ?>
                                        </span>
                                    </div>

                                    <div class="row fondocuerpoindicadores">

                                        <div class="col-md-2 sacarpadingleftrightmenos">
                                            <div class="ensayocarpeta">

                                                <?php
                                                    if(($Prueba['cantidad_pruebas']) > 0 ){
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
                                                <span class="bajadacarpetastextosuperior"> Pruebas Rendidas:</span>
                                                <div class="separadorfinocarpetas"></div>
                                                <div class="bajadacarpetastexto"><?php echo $Prueba['cantidad_pruebas']; ?></div>
                                            </div>
                                        </div>

                                        <div class="row col-md-4 sacarpadingleftright sacarpadingleftrightmenos">

                                            <div class="col-md-6 sacarpadingleftrightmenos">
                                                <div class="ensayocarpeta">
                                                    <img src="/alumno/img/iconos/calendarioinicio.svg" class="img" alt="#">
                                                </div>
                                                <div class="cajatitulocontenedoresfecha">
                                                    <span class="bajadacarpetastextosuperior"> Fecha Inicio:</span>
                                                    <div class="separadorfinocarpetas"></div>
                                                    <div class="bajadacarpetastextofecha"> 

                                                        <?php 

                                                            if($Prueba['fecha_mostrar_prueba']){ 
                                                            
                                                                echo date('d-m H:i', strtotime($Prueba['fecha_mostrar_prueba']));


                                                            }else{

                                                                echo "-";

                                                            }
                                                            
                                                        ?>

                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6 sacarpadingleftrightmenos">
                                                <div class="ensayocarpeta">

                                                    <?php

                                                        if($Prueba['fecha_mostrar_prueba']){
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
                                                
                                                    if($Prueba['fecha_terminar_prueba']){ 
                                                    
                                                        ?>

                                                            <div class="cajatitulocontenedoresfecha">
                                                                <span class="bajadacarpetastextosuperior"> Fecha Termino:</span>
                                                                <div class="separadorfinocarpetas"></div>
                                                                <div class="bajadacarpetastextofecha"> 

                                                                    <?php

                                                                        echo date('d-m H:i', strtotime($Prueba['fecha_terminar_prueba']));

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

                                        </div>

                                        <div class="row col-md-3 sacarpadingleftright sacarpadingleftrightmenos">

                                            <div class="col-xs-6 col-md-6 sacarpadingleftrightmenos">
                                                <div class="ensayocarpeta">

                                                <?php

                                                    if(($Prueba['cantidad_pruebas']) > 0 ){
                                                        ?>

                                                            <img src="/profesor/img/iconos/mejorpuntaje.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/profesor/img/iconos/mejorpuntaje2.svg" class="img" alt="#">

                                                        <?php

                                                    }
                                                    
                                                ?>

                                                </div>
                                                <div class="cajatitulocontenedores">
                                                    <span class="bajadacarpetastextosuperior"> Mejor Puntaje:</span>
                                                    <div class="separadorfinocarpetas"></div>
                                                    <div class="bajadacarpetastexto"> 
                                                        
                                                        <?php 

                                                            if(($Prueba['cantidad_pruebas']) > 0 ){
                                                                
                                                                echo $Prueba['puntaje_maximo'];

                                                            }else{

                                                                echo "-";

                                                            }
                                                            
                                                            
                                                        ?>

                                                    </div>
                                                </div>

                                            </div>  

                                            <div class="col-xs-6 col-md-6 sacarpadingleftrightmenos">
                                                <div class="buenascarpeta">

                                                <?php

                                                    if(($Prueba['cantidad_pruebas']) > 0 ){
                                                        ?>

                                                            <img src="/profesor/img/iconos/promedio.svg" class="img" alt="#">

                                                        <?php
                                                    }else{

                                                        ?>

                                                            <img src="/profesor/img/iconos/promedio2.svg" class="img" alt="#">

                                                        <?php

                                                    }
                                                    
                                                ?>

                                                </div>
                                                <div class="cajatitulocontenedores">
                                                    <span class="bajadacarpetastextosuperior">  Promedio Puntaje:</span>
                                                <div class="separadorfinocarpetas"></div>
                                                    <div class="bajadacarpetastexto">

                                                        <?php 

                                                            if(($Prueba['cantidad_pruebas']) > 0 ){
                                                                                                                            
                                                                echo $Prueba['promedio'];

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
                                                <div class="ejetematicocarpeta">

                                                    <?php

                                                        if(($Prueba['cantidad_pruebas']) > 0 ){
                                                            ?>

                                                                <img src="/profesor/img/iconos/solucionario.svg" class="img" alt="#">

                                                            <?php
                                                        }else{

                                                            ?>

                                                                <img src="/profesor/img/iconos/solucionario2.svg" class="img" alt="#">

                                                            <?php

                                                        }

                                                    ?>

                                                </div>

                                                <div class="cajatitulocontenedores">
                                                    <span class="bajadacarpetastextosuperior"> Ver Prueba:</span>
                                                    <div class="separadorfinocarpetas"></div>
                                                    <div class="bajadacarpetastexto">
                                                        <?php 

                                                            if(($Prueba['cantidad_pruebas']) > 0 ){

                                                                if(count($Prueba["cursos"]) > 0){

                                                                    foreach ($Prueba["cursos"] as $key => $cursos) {

                                                                        echo Html::a('
    
                                                                        <i class="fa fa-angle-right"></i>  Ver
        
                                                                        ', ['/solucionario/profesor','prueba_id'=>$Prueba['id'],'curso_id'=>$cursos], ['class'=>'btn btnprimario1']);
    
                                                                    }

                                                                }

                                                            }else{



                                                            }

                                                        ?>
                                                    </div>

                                                </div>




                                            </div>  

                                            <div class="col-xs-6 col-md-6 sacarpadingleftrightmenos">
                                                <div class="ejetematicocarpeta">

                                                    <?php

                                                        if(($Prueba['cantidad_pruebas']) > 0 ){
                                                            ?>

                                                                <img src="/profesor/img/iconos/excel.svg" class="img" alt="#">

                                                            <?php
                                                        }else{

                                                            ?>

                                                                <img src="/profesor/img/iconos/excel2.svg" class="img" alt="#">

                                                            <?php

                                                        }

                                                    ?>

                                                </div>

                                                <div class="cajatitulocontenedores">
                                                    <span class="bajadacarpetastextosuperior"> Excel Informes:</span>
                                                    <div class="separadorfinocarpetas"></div>
                                                    <div class="bajadacarpetastexto">
                                                        <?php 

                                                            if(($Prueba['cantidad_pruebas']) > 0 ){

                                                                if(count($Prueba["cursos"]) > 0){

                                                                    foreach ($Prueba["cursos"] as $key => $cursos) {

                                                                        echo Html::a('
    
                                                                        <i class="fa fa-angle-right"></i>  Ver
        
                                                                        ', ['/informes','prueba_id'=>$Prueba['id'],'curso_id'=>$cursos], ['class'=>'btn btnprimario1']);
    
                                                                    }

                                                                }

                                                            }else{



                                                            }

                                                        ?>
                                                    </div>

                                                </div>




                                            </div>  

                                        </div> 




                                    </div>  

                                    <br>
                                    <br>

                                <?php
                                $i2++;
                            }

                        ?>


                    </div>
                </div>  


                <br>
            </div>

        </div>

        <br>

        </main>

    </div>
    
</div>