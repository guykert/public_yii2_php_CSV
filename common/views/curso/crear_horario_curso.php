<?php

use yii\helpers\Html;






?>

<main class="main">


    <?= $this->render('_form_crear_horario_curso', [
        
        'model_horario_curso' => $model_horario_curso,
        'model' => $model,
    ]) ?>


</main>