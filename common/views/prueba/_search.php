<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\Prueba */
/* @var $form yii\widgets\ActiveForm */


/*  llama al archivo form  y lo carga con la información de resultante en base a los parametros de busqueda  */
?>
<div class="prueba-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'codigo') ?>

    <?= $form->field($model, 'prueba_categoria_id') ?>

    <?= $form->field($model, 'ramo_id') ?>

    <?php // echo $form->field($model, 'sub_ramo_id') ?>

    <?php // echo $form->field($model, 'muestra_resultados_web') ?>

    <?php // echo $form->field($model, 'fecha_creacion') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'modificado_por') ?>

    <?php // echo $form->field($model, 'activo')->checkbox() ?>

    <?php // echo $form->field($model, 'formula_id') ?>

    <?php // echo $form->field($model, 'tabla_conversion_id') ?>

    <?php // echo $form->field($model, 'tiempo') ?>

    <?php // echo $form->field($model, 'externo_id') ?>

    <?php // echo $form->field($model, 'migrar') ?>

    <?php // echo $form->field($model, 'solucionario_teorico_id') ?>

    <?php // echo $form->field($model, 'solucionario_id') ?>

    <?php // echo $form->field($model, 'numero_preguntas') ?>

    <?php // echo $form->field($model, 'mostrar_escaner') ?>

    <?php // echo $form->field($model, 'migrar_pauta') ?>

    <?php // echo $form->field($model, 'mension_comun') ?>

    <?php // echo $form->field($model, 'anio_id') ?>

    <?php // echo $form->field($model, 'campania_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
