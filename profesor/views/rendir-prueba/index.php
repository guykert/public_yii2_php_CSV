<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

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

    <main>

        <div class="cajafondoprincipal">

            <div class="cajaprecauciontitulo">
                <span>
                    <i class="fa fa-exclamation-circle"></i> 
                    Antes de comenzar <b> DEBES SABER...</b>
                </span>
            </div>

            <div class="cajaprecaucion ">

                <div class="row cajati">
                    <div class="col-md-12">
                        <div class="text-center">
                        <i class="fa fa-check"></i> <span class="recomend">Recomendamos usar Chrome o Mozilla Firefox.</span>
                        </div>
                    </div>
                </div>


                <div class="row ">
                    <div class="">
                        <div class="">
                            <br>
                            <div class="">
                                <div class="row">
                                    <div class="col-xs-6 col-md-6 textosprecaucion">
                                        <ul>
                                        <dd><i class="fa fa-check iconoazul"></i>  A continuación se desplegará el set de preguntas seleccionadas.</dd>

                                        <dd><i class="fa fa-check iconoazul"></i>  En la parte superior derecha encontrarás una barra que indica tus preguntas contestadas y omitidas, de esta forma sabrás como va tu avance, y también aparecerá el tiempo que te queda para responder. ¡Revísalo siempre antes de dar el OK final!</dd>
                                        
                                        <dd><i class="fa fa-check iconoazul"></i>  Luego de presionar el botón FINALIZAR se desplegará un mensaje en tú pantalla con las preguntas que te faltan responder, <b>¡Revísalo siempre antes de dar el OK final!</b></dd>
                                        
                                        </ul>
                                    </div>
                                    <div class="col-xs-6 col-md-6 textosprecaucion">
                                        <ul>
                                        <dd><i class="fa fa-check iconoazul"></i> Una vez presionado el botón FINALIZAR el sistema entregará un reporte de tu desempeño, con el puntaje obtenido, y la cantidad de preguntas Buenas, Malas y/o Omitidas.</dd>

                                        <dd> <i class="fa fa-check iconoazul"></i>Podrás revisar en el solucionario como se resuelven las preguntas malas y omitidas, una vez que el periodo para contestar la prueba haya finalizado.</dd>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <br>

                <div class="row">
                <div class="col-xs-4 col-md-4"></div> 
                <div class="col-xs-2 col-md-2">

                    <?php 

                        echo Html::a('

                        <i class="fa fa-angle-right "></i> SI

                        ', ['rendir','prueba_id'=>$prueba_id,'curso_id'=>$curso_id,'confirma'=>'si'], ['class'=>'btn btn-block btn-celeste','data-confirm'=>'¿Estás seguro que quieres Iniciar : '.$nombre.'?']);

                    ?>
                                    
                </div>
                <div class="col-xs-2 col-md-2 "> 

                        <?php 

                            echo Html::a('

                            <i class="fa fa-angle-right "></i> NO

                            ', ['/home','prueba_id'=>$prueba_id,'curso_id'=>$curso_id,'confirma'=>'si'], ['class'=>'btn btn-block btn-celeste']);

                        ?>

                </div>                                      
                <div class="col-xs-4 col-md-4"></div>
                </div>


                <br>
            </div>


        </div>

    </main>

</div>