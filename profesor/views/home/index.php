<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use yii\helpers\ArrayHelper;

// $this->params['breadcrumbs'][] = ['label' => 'seleccionar', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$Pruebas_areas = ArrayHelper::index($Pruebas,null, 'id_area');

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
                <div class="">
                    <div class="row">
                             
                        <div class="col-md-6 sacarpadingleftdoscolumnas">
                            <!-- <div class="contenedorgris"></div> -->

                            <div class="cajaNIVEL">
                                <span>
                                    <i class="fa fa-check"></i> 
                                    Pruebas
                                </span>
                                <div class="separadorcajaazullinea"></div>
                            </div>

                            <div class="cajaTALLERES">

                                <?php

                                    foreach ($Pruebas_areas as $key => $pruebas) {

                                        ?>

                                            <div class="row cajati">
                                                <div class="col-md-12">
                                                    <div class="titulotall">
                                                        <i class="fa fa-folder-open"></i>  <?= $pruebas[0]["nombre_area"];?>
                                                    </div>
                                                </div>
                                            </div>




                                                <?php

                                                    foreach ($pruebas as $key => $prueba) {

                                                        ?>

                                                            <div class=" contenedorcajadatos">
                                                                <div class="contenedorcajadatostitulo  row">
                                                                    <span class="titulodepreguntas">
                                                                        <i class="fa fa-angle-right"></i> <?php echo $prueba["nombre_prueba"]; ?>

                                                                    </span>

                                                                </div>

                                                                <div class="row marginsuperioraltuira">
                                                                    <div class="col-md-3 text-center sacarpadingleftrightmenos centrarflex">
                                                                        <div class="">
                                                                        <div class="textosdepruebas">  Preguntas: </div>
                                                                        <div class="textosdepruebasdatosnobtn">  <i class="fa fa-angle-right"></i>  <?php echo $prueba["numero_preguntas"];?></div>
                                                                        </div>
                                                                    </div>


                                                                    <div class="col-md-3 text-center sacarpadingleftrightmenos centrarflex">
                                                                        <div class="">
                                                                            <div class="textosdepruebas">  Prueba: </div>

                                                                            <?php 

                                                                                echo Html::a('<i class="fa fa-angle-right"></i>  Rendir

                                                                                ', ['/rendir-prueba/previo','prueba_id'=>$prueba["id_prueba"],'curso_id'=>$curso_id],['class'=>'marginbtngris btnchico-naranjo']);

                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 text-center sacarpadingleftrightmenos centrarflex">
                                                                        <div class="">
                                                                            <div class="textosdepruebas">Solucionario: </div>
                                                                            
                                                                            <?php 

                                                                                echo Html::a('<i class="fa fa-angle-right"></i>  Ver

                                                                                ', ['/solucionario/profesor','prueba_id'=>$prueba["id_prueba"],'curso_id'=>$curso_id],['class'=>'marginbtngris btnchico-naranjo']);

                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                    <div class="col-md-3 text-center sacarpadingleftrightmenos centrarflex">
                                                                        <div class="">
                                                                            <div class="textosdepruebas">Informe: </div>
                                                                            
                                                                            <?php 

                                                                                echo Html::a('<i class="fa fa-angle-right"></i>  Ver

                                                                                ', ['/informes','prueba_id'=>$prueba["id_prueba"],'curso_id'=>$curso_id],['class'=>'marginbtngris btnchico-naranjo']);

                                                                            ?>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            
                                        
                                                            </div> 



                                                        <?php

                                                    }

                                                ?>



                                            <?php

                                    }

                                ?>

                            </div>

                        </div>

                        <div class="col-md-6 sacarpadingrightdoscolumnas">
                            <!-- <div class="contenedorgris"></div> -->

                            <div class="cajaNIVEL">
                                <span>
                                    <i class="fa fa-check"></i> 
                                    Ejercicios
                                </span>
                                <div class="separadorcajaazullinea"></div>
                            </div>

                            <!-- <div class="cajaTALLERES">

                                <div class="row cajati">
                                <div class="col-md-9">
                                    <div class="titulotall">
                                        <i class="fa fa-folder-open"></i>  1.- Números
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="numeropreguntas ">Preguntas</div>
                                </div>
                                </div>

                                <div class=" contenedorlista">
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                        <br>
                                    </div>
                                    </div>
                                </div>

                                <div class="row cajati">
                                <div class="col-md-9">
                                    <div class="titulotall">
                                        <i class="fa fa-folder-open"></i>  2.- Números
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="numeropreguntas ">Preguntas</div>
                                </div>
                                </div>

                                <div class=" contenedorlista">
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                        <br>
                                    </div>
                                    </div>

                                </div>


                                <div class="row cajati">
                                <div class="col-md-9">
                                    <div class="titulotall">
                                        <i class="fa fa-folder-open"></i>  3.- Números
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="numeropreguntas ">Preguntas</div>
                                </div>
                                </div>

                                <div class=" contenedorlista">
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                    </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <hr class="hr-caja">    
                                        </div>
                                    </div>
                                    <div class="row">
                                    <div class="col-md-9">
                                        <div>
                                        <a class="lista" href="/solucionario/taller-corrector?prueba_id=265">
                                            <i class="fa fa-angle-right"></i> A) Enteros
                                        </a>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <a href="/solucionario/taller-corrector?prueba_id=265">
                                        <div class="listanum">30</div>
                                        </a>
                                        <br>
                                    </div>
                                    </div>

                                </div>
                            </div> -->

                        </div>

                    </div>
            
                </div>
            </div> 


        </div>

    </main>

</div>