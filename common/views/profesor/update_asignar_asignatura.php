<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model backend\models\Usuario */

$this->title = 'Create Usuario';
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Usuarios",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n", 'url' => ['index']];
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

    <?= $this->render('_form_asignar_asignatura', [
    'model' => $model,
    'profesor' => $profesor,
    ]) ?>

<!-- /.conainer-fluid -->
</main>
