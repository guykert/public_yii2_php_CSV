
<?php
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\export\ExportMenuAsset;
use kartik\helpers\Enum;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;
MantenedoresAsset::register($this);

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require __DIR__ . '/../../../vendor/autoload.php';

// Create new Spreadsheet object
$spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();

use kartik\icons\Icon;
Icon::map($this); 

/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\Usuario */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Usuarios';
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
?>

<main class="main">

    <?=  Breadcrumbs::widget([
        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => "<li class=\"breadcrumb-item\">{link}</li>\n", // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',
    ]) ?>


      <div class="container-fluid">

        <div class="animated fadeIn">



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
                'tableOptions' =>['class' => 'table table-striped table-bordered datatable'],
                'hover' => true,
                //'showFooter' habilita el footer quien ya contiene la paginación
                'showFooter' => true,
                'floatHeader' => true,
                'panel' => [
                    'heading'=>'<h3 class="panel-title"></h3>',
                    'type'=>'success',
                    'before'=>Html::a('Crear Usuario <i class="iconomantenedor fa fa-plus"></i>', ['create'], ['class' => 'btn btn-primary']),
                //    'footer'=>false
                ],
                'export' => [
                    'fontAwesome' => true,
                ],
                'filterModel' => $searchModel,
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],
                                // 'id',
                    // 'usuario_entrar_como_id',
                    // 'rut',
                    'username',
                    'nombre',
                    'apellido_paterno',
                    'apellido_materno',
                    // 'sexo',
                    // 'edad',
                    // 'email:email',
                    // 'email2:email',
                    // 'telefono1',
                    // 'telefono2',
                    
                    // 'clave_actualizada',
                    
                    // 'auth_key',
                    // 'password_reset_token',
                    // 'password_hash',
                    // 'status',
                    // 'activo:boolean',
                    // 'updated_at',
                    // 'fecha_creacion',
                    // 'fecha_modificacion',
                    // 'creado_por',
                    // 'created_at',
                    ['class' => 'yii\grid\ActionColumn',
                        'template'=>'{view} {update} {delete}',
                        'buttons' => [
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
                                'rut',
                                'username',
                                'nombre',
                                'apellido_paterno',
                                'apellido_materno',
                                // 'apellido_materno',
                                // 'sexo',
                                // 'edad',
                                'email:email',
                                // 'email2:email',
                                // 'telefono1',
                                // 'telefono2',
                                // 'username',
                                // 'clave_actualizada',
                                
                                // 'auth_key',
                                // 'password_reset_token',
                                // 'password_hash',
                                // 'status',
                                // 'activo:boolean',
                                // 'updated_at',
                                // 'fecha_creacion',
                                // 'fecha_modificacion',
                                // 'creado_por',
                                // 'created_at',
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
                ]); 
            ?>

        </div>

      </div>

</div>
