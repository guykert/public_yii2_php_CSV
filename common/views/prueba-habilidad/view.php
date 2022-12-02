<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PruebaHabilidad */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Prueba Habilidads', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
/*genera los botones update y delete */
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
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="alineadototal">

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  Ver información del id</div>
                            <div>

                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '¿Realmente quieres eliminar el registro ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>

                            </div>

                        </div>
                        
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada el id

                            <div class="espacio-chico"></div>

                            <?= DetailView::widget([
                                'options'=>[
                                    'class' => 'table colortabalfondo table-bordered detail-view'
                                ],
                                'model' => $model,
                                'attributes' => [
                                    'nombre',
                                    'descripcion',
                                    'orden',                                
                                ],
                            ]) ?>


                        </div>

                        <div class="card-footer">



                        </div>
                        
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>






</main>


