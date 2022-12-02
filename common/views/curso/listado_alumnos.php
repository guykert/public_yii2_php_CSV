<?php

use yii\helpers\Html;

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\export\ExportMenuAsset;
use kartik\helpers\Enum;
use common\models\Ramo;
use common\models\Curso;
use common\models\Nivel;
use common\models\Letra;
use common\models\SubRamo;
use common\assets\MantenedoresAsset;
use yii\widgets\Breadcrumbs;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\Curso */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Cursos';

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

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>



    <?= 
        GridView::widget([
        'dataProvider' => $dataProvider,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY
        ],
        'bordered' => true,
        'striped' => true,
        'condensed' => false,
        'responsive' => true,
        'hover' => true,
        'pjax' => true, // pjax is set to always true for this demo
        'floatHeader' => true,
        'panel' => [
            'heading'=>'<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> '.Html::encode($this->title).'</h3>',
            'type'=>'success',
            //'footer'=>false
        ],
        'export' => [
            'fontAwesome' => true,
        ],

        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
                'rut',
                'nombre',
                'apellido_paterno',
                'apellido_materno',
                'email',


            ],
            'export' => [
                'fontAwesome' => true,
            ],
            'toolbar' => [
               
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
              
        'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'rut',
                    'nombre',
                    'apellido_paterno',
                    'apellido_materno',
                    'email',
                    ],
                    'target' => ExportMenu::TARGET_BLANK,
                    'columnSelectorOptions'=>[
                        'label' => 'Columnas',
                        'class' => 'btn btn-warning'
                    ],
                    'hiddenColumns'=>[0, 9], // SerialColumn & ActionColumn
                    'disabledColumns'=>[1, 2], // ID & Name
                    'fontAwesome' => false,
                    'dropdownOptions' => [
                        'label' => 'Exportar',
                        'class' => 'btn btn-warning',

                    ],

                    ]),
                    '{toggleData}'
                   
            ],

        ]); ?>
          
        </div>
        <br><br><br>
    </div><!--container-->
</main>
