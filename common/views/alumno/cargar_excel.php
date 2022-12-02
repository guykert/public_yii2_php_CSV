<?php

use yii\helpers\Html;

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\export\ExportMenuAsset;
use kartik\helpers\Enum;

use common\assets\MantenedoresAsset;
use yii\widgets\Breadcrumbs;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Alumno */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cargar Base - Paso 1';

$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];

?>


<main class="main">


        <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',

    ]) ?>

<div class="container-fluid">

    <div class="animated fadeIn">

        <div class="fondo">
            <div class="titulo22">
                <div class="container">
                    <ul class="steps ">
                        <li class="fuelux">
                            <span class="circulo">1</span>Descargar Plantilla
                            <div class="lineademenu"></div>
                        </li>
                        <li  class="fuelux">
                            <span class="circuloGris">2</span> Datos Colegio
                            <span class="lineaGris"></span>
                        </li>
                        <li  class="fuelux">
                            <span class="circuloGris">3</span> Cargar Excel
                        </li>
                    </ul>
                    <br>
                    <div class="container">
                        <div class="col-md-12 quitar-padding feature-box-2 cuadroexplicativo fondoblanc fadeInDownSmall">
                            <div class="col-md-12">
                                <div class="cajatextoexplicativo1">
                                    <span class="textoexplicativo1">Descarga y completa el formato en Excel con toda la información
                                        solicitada. Luego selecciona el Colegio asociado a los Alumnos y sube la información.
                                        Con estos datos podrás realizar la corrección de la Campaña.</span>
                                    <!-- <div class="separator2 clearfix"></div>
                                    <br>
                                        <a class="btn btn-default btn-animated btn-md" href="http://mizonapreu.preupdv.cl/files/base_test_vocacional/archivo_base.xlsx" style="color:#fff;"><i class="fa fa-download icon-white"></i> Descargar Plantilla </a>
                                    </div> -->
                                    <div class="">
                                        <?= Html::a('<i class="fa fa-download icon-white"></i> Descargar Plantilla ', ['descargar-excel'], ['class'=>'btn btn-success   ',' style'=>'color:#fff;']) ?>
                                    </div>

                                </div>
                                <div class=" alineadotextoboton"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="col-md-10"></div>
                                <div class="col-md-2">
                                    <?= Html::a(' Continuar <i class="iconomantenedor fa fa-arrow-right"></i>', ['cargar-form'], ['class'=>'btn btn-success ',' style'=>'color:#fff;']) ?>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div><!--container-->
</main>
