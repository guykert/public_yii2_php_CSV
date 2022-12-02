<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use common\assets\AsignaturaAsset;

AsignaturaAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Curso */
/* Coloca el título Update más el nombre del modelo */
$this->title = 'Curso : ' . $MallaHorariaProfesor['nombre_curso'] . '    Asignatura : ' .  $MallaHorariaProfesor['nombre_sub_ramo'];
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Asignatura", 'url' => ['/asignatura','id'=>$MallaHorariaProfesor['id'],'fecha'=>$fecha],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => $this->title,'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
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

    <?= $this->render('_asistencia_historial', [
        'model' => $model,
        'MallaHorariaProfesor' => $MallaHorariaProfesor,
        'Alumnos' => $Alumnos,
        'fecha' => $fecha

    ]) ?>
</main>