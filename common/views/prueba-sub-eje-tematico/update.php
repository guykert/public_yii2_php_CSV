<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PruebaSubEjeTematico */
/* Coloca el título Update más el nombre del modelo */
$this->title = 'Modificar Prueba Sub Eje Tematico: ' . ' ' . $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Prueba Sub Eje Tematicos', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];

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

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</main>