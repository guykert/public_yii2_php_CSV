<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);


/* @var $this yii\web\View */
/* @var $model common\models\TemplateRegionGeneral */
/* Le coloca nombre al botón Create  mas el nombre del modelo */
$this->title = 'Crear Template Region General';
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Template Region Generals', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];


/* llama al archivo form  y le envía el modelo */
?>

<main class="main">
        <?=  Breadcrumbs::widget([

    'homeLink' =>[
        'label' => 'Inicio', 'url' => ['/site/index'],
        'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
    ],
    'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
    'options' => ['class' => 'breadcrumb'],
    'tag' => 'ol',

    ]) ?>

    <?= $this->render('_form_dos', [
        'model' => $model,
        'Template' => $Template,
        'id_template_general' => $id_template_general,
    ]) ?>


</main>