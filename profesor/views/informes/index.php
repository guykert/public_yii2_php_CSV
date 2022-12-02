<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\AsignaturaAsset;

AsignaturaAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Curso */
/* Coloca el título Update más el nombre del modelo */
$this->params['breadcrumbs'][] = ['label' => 'Home', 'url' => ['/home']];
$this->params['breadcrumbs'][] = $this->title;

/* llama al archivo form  y le envía el modelo con su id */
?>

<main class="main">

    <?=  Breadcrumbs::widget([
        'class'=>'breadcrumb',
        'itemTemplate' => "<li  class=\"breadcrumb-item\">{link}</li>\n", 
        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/seleccionar-curso'],
            'template' => "<li  class=\"breadcrumb-item\">{link}</li>\n", // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    ]) ?>

    <?= $this->render('_index', [
        'Prueba' => $Prueba,
        'prueba_id' => $prueba_id,
        'curso_id' => $curso_id,
        'Cursos' => $Cursos,
        'fecha' => $fecha
    ]) ?>

</main>