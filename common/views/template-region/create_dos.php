<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);


/* @var $this yii\web\View */
/* @var $model common\models\TemplateRegion */
/* Le coloca nombre al botón Create  mas el nombre del modelo */
$this->title = 'Crear Template Region';
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Template Regions', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];


/* llama al archivo form  y le envía el modelo */
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

    <?= $this->render('_form_dos', [
        'model' => $model,
        'TemplateRegionGeneral' => $TemplateRegionGeneral,
        'id_template_region' => $id_template_region,
        'width' => $width,
        'height' => $height,
        'x' => $x,
        'y' => $y,
        'x2' => $x2,
        'y2' => $y2,
        'w' => $w,
        'h' => $h,
    ]) ?>


</main>