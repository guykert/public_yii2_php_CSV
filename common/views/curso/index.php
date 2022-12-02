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

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require __DIR__ . '/../../../vendor/autoload.php';

// Create new Spreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

use kartik\icons\Icon;
Icon::map($this); 

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
            'before'=>Html::a('Crear horario Curso', ['create'], ['class' => 'btn btn-success']),
            //'footer'=>false
        ],
        'export' => [
            'fontAwesome' => true,
        ],
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=>'nivel_id',
                'value'=>'nivel.nombre',
                'filter' =>Html::activeDropDownList($searchModel,'nivel_id', Nivel::getNivelCombo(),['class'=>'form-control','prompt'=>'Selecciona']),
            ],

            [
                'attribute'=>'letra_id',
                'value'=>'letra.nombre',
                'filter' =>Html::activeDropDownList($searchModel,'letra_id', Letra::getLetraCombo(),['class'=>'form-control','prompt'=>'Selecciona']),
            ],

            // 'codigo',
            'nombre',
            // 'descripcion',
            // 'capacidad',
            // 'cupo',
            // 'anio_id',
            // 'ramo_id',

                 ['class' => 'yii\grid\ActionColumn',
                    'template'=>'{horario} {alumno} {view} {update} {delete}',
                    'buttons' => [

                        'horario' => function ($url, $model, $key) {
                            $options = array_merge([
                                'title' => Yii::t('yii', 'Alumnos'),
                                'aria-label' => Yii::t('yii', 'Alumnos'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-success',
                            ]);
                            return Html::a(Icon::show('calendar'), ['horario-curso2', 'id'=>$model->id , 'nombre'=>$model->nombre], $options);
                        },

                        'alumno' => function ($url, $model, $key) {
                            $options = array_merge([
                                'title' => Yii::t('yii', 'Alumnos'),
                                'aria-label' => Yii::t('yii', 'Alumnos'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-success',
                            ]);
                            return Html::a(Icon::show('user'), ['listado-alumnos', 'id'=>$model->id , 'nombre'=>$model->nombre], $options);
                        },



                        'delete' => function ($url,$model) {
                            //se activa la accion horario-profesor del controlador profesorController 
                            // return Html::a('<i class="fa fa-calendar refresh"></i>', ['horario-profesor', 'campana' => $campana,]);
                        
                            $options = array_merge([
                                'title' => Yii::t('yii', 'Delete'),
                                'aria-label' => Yii::t('yii', 'Delete'),
                                'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                'data-method' => 'post',
                                'data-pjax' => '0',
                                'class' => 'btn btn-danger ',
                            ]);
                            return Html::a(Icon::show('trash-alt'), $url, $options);
                        },
                        'update' => function ($url,$model) {
                            $options = array_merge([
                                'title' => Yii::t('yii', 'Update'),
                                'aria-label' => Yii::t('yii', 'Update'),
                                'data-pjax' => '0',
                                'class' => 'btn btn-info',
                            ]);
                            return Html::a(Icon::show('pencil-alt'), $url, $options);


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
                    ],

                        
                ],
            ],
            'export' => [
                'fontAwesome' => true,
            ],
            'toolbar' => [
               
                ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                      'filterModel' => $searchModel,
        'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
            'codigo',
            'nombre',
            'descripcion',
            // 'capacidad',
            // 'cupo',
            // 'anio_id',
            // 'ramo_id',
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
