
<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\AlumnoAsset;

AlumnoAsset::register($this);


/* @var $this yii\web\View */
/* @var $model common\models\Dia */
/* Le coloca nombre al botón Create  mas el nombre del modelo */
$this->title = 'Perfil';
/* coloca el menu breadcrumbs */

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

    <?= $this->render('_form_perfil', [
        'model' => $model,
        'cantidadColegiosUsuario' => $cantidadColegiosUsuario,
    ]) ?>


</main>