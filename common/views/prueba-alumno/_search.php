<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\PruebaAlumno */
/* @var $form yii\widgets\ActiveForm */


/*  llama al archivo form  y lo carga con la información de resultante en base a los parametros de busqueda  */
?>
<div class="prueba-alumno-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sede_id') ?>

    <?= $form->field($model, 'prueba_id') ?>

    <?= $form->field($model, 'curso_id') ?>

    <?= $form->field($model, 'rut') ?>

    <?php // echo $form->field($model, 'nota') ?>

    <?php // echo $form->field($model, 'buenas') ?>

    <?php // echo $form->field($model, 'malas') ?>

    <?php // echo $form->field($model, 'omitidas') ?>

    <?php // echo $form->field($model, 'fecha_creacion') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'modificado_por') ?>

    <?php // echo $form->field($model, 'activo')->checkbox() ?>

    <?php // echo $form->field($model, 'fecha_termino') ?>

    <?php // echo $form->field($model, 'fecha_inicio') ?>

    <?php // echo $form->field($model, 'tiempo_pausa') ?>

    <?php // echo $form->field($model, 'fecha_pausa') ?>

    <?php // echo $form->field($model, 'detalle_malas') ?>

    <?php // echo $form->field($model, 'descripcion') ?>

    <?php // echo $form->field($model, 'id_ensayo_desafio') ?>

    <?php // echo $form->field($model, 'id_tipo_desafio') ?>

    <?php // echo $form->field($model, 'observacion') ?>

    <?php // echo $form->field($model, 'mdl_quiz_id') ?>

    <?php // echo $form->field($model, 'mdl_attempt') ?>

    <?php // echo $form->field($model, 'empresa_id') ?>

    <?php // echo $form->field($model, 'neto') ?>

    <?php // echo $form->field($model, 'porcentaje_logro') ?>

    <?php // echo $form->field($model, 'nivel_logro') ?>

    <?php // echo $form->field($model, 'pond_buenas') ?>

    <?php // echo $form->field($model, 'pond_malas') ?>

    <?php // echo $form->field($model, 'pond_omitidas') ?>

    <?php // echo $form->field($model, 'preguntas_abiertas') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
