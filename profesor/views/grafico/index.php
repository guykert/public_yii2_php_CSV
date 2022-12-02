<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use miloschuman\highcharts\Highcharts;
use yii\widgets\ActiveForm;

$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/home','curso_id'=>$curso_id]];
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

            <div class="row">

                <div class="col-md-12 sacarpadingleftdoscolumnas">

                    <div class="">

                        <div class="cajatitulopreguntascompleto">
                            <span>
                                <i class="fa fa-angle-right"></i>
                                <?php echo $nombre; ?> 

                            </span>
                        </div>

                        <div class="contenedor">
                            <br>
                            
                        <?php 


                        echo Highcharts::widget([
                                'options' => [
                                    'title' => ['text' => ''],
                                    'chart' => ['type' => 'column'],
                                    'xAxis' => [
                                        'categories' => $data[0],
                                        'title' => [
                                            'text' => null
                                        ]
                                    ],
                                    'yAxis' => [
                                        'title' => ['text' => '']
                                    ],
                                    'legend' => ['enabled' => false],
                                    'series' => $data[1],
                                    'colors' => $data[2],
                                    'plotOptions' => ['column' => 
                                        ['dataLabels' => 
                                            ['enabled' => true],
                                            ['pointPadding' => '0.2'],
                                        ]
                                    ],
                                    'exporting' => ['enabled' => false],
                                    'subtitle' => ['text' => ''],
                                ]
                            ]);



                        ?>

                        </div>
                        <br>
                        <div class="row alinearalcentroelementos">
                            <div></div>                                        

                            <div>

                                <?php 

                                    echo Html::a('<i class="fa fa-reply"></i> Volver

                                    ', ['/rendir-prueba/previo','prueba_id'=>$prueba_id,'curso_id'=>$curso_id], ['class'=>'btn-celeste']);


                                ?>

                            </div>
                            <div></div>
                        </div>
                        <br>

                    </div>

                </div>



            </div>

        </div>

    </div>

    <br>

    </main>

</div>
