<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\MallaHorariaAsset;

MallaHorariaAsset::register($this);

use kartik\icons\Icon;
Icon::map($this); 

/* @var $this yii\web\View */
/* @var $model common\models\Curso */
/* Coloca el título Update más el nombre del modelo */
$this->title = 'Malla Horaria Profesor: ' . ' ' . $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Profesor",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];


/* llama al archivo form  y le envía el modelo con su id */
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

    <?= $this->render('_malla_horaria_profesor', [
        'model' => $model,
        'MallaHoraria' => $MallaHoraria,
        'dias' => $dias,
        'FechasComponent' => $FechasComponent,
    ]) ?>
</main>