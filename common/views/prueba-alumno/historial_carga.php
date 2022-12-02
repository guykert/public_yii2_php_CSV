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

MantenedoresAsset::register($this);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require __DIR__ . '/../../../vendor/autoload.php';

// Create new Spreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

use kartik\icons\Icon;
Icon::map($this); 

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
                'hoja_numero',
                'rut',
                'nombre_completo',
                'nota',
                'buenas',
                'malas',
                'omitidas',

                ['class' => 'yii\grid\ActionColumn',
                'template'=>'{update} {view} {recalcular}',
                'buttons' => [

                    'update' => function ($url,$model) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Update'),
                            'aria-label' => Yii::t('yii', 'Update'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-info',
                        ]);


                        return Html::a(Icon::show('refresh'), ['crear-respuesta-alternativas', 'rut'=>$model["rut"], 'prueba_id'=>$model["prueba_id"]], $options);


                    },

                    'view' => function ($url,$model) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'View'),
                            'aria-label' => Yii::t('yii', 'View'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-success',
                        ]);
                        return Html::a(Icon::show('eye'), $url, $options);

                    },
                    'recalcular' => function ($url, $model, $key) {
                        $options = array_merge([
                            'title' => Yii::t('yii', 'Actualizar'),
                            'aria-label' => Yii::t('yii', 'Actualizar'),
                            'data-pjax' => '0',
                            'class' => 'btn btn-success',
                        ]);
                        return Html::a(Icon::show('refresh'), ['recalcular-puntajes', 'prueba_alumno_id'=>$model["id_prueba_alumno"]], $options);
                    },


                ],

                    
            ],

            ],
            'export' => [
                'fontAwesome' => true,
            ],
            'toolbar' => [
               
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
              
        'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                    'hoja_numero',
                    'rut',
                    'nombre_completo',
                    'nota',
                    'buenas',
                    'malas',
                    'omitidas',
                    
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
