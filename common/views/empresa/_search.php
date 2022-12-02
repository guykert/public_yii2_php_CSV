<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\Empresa */
/* @var $form yii\widgets\ActiveForm */


/*  llama al archivo form  y lo carga con la información de resultante en base a los parametros de busqueda  */
?>
<div class="empresa-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'empresa_tipo_id') ?>

    <?= $form->field($model, 'descripcion') ?>

    <?= $form->field($model, 'rut') ?>

    <?php // echo $form->field($model, 'razonsocial') ?>

    <?php // echo $form->field($model, 'direccion') ?>

    <?php // echo $form->field($model, 'telefono') ?>

    <?php // echo $form->field($model, 'imagen') ?>

    <?php // echo $form->field($model, 'rbd') ?>

    <?php // echo $form->field($model, 'sostenedor') ?>

    <?php // echo $form->field($model, 'director') ?>

    <?php // echo $form->field($model, 'encargadopw') ?>

    <?php // echo $form->field($model, 'telefonoepw') ?>

    <?php // echo $form->field($model, 'activo')->checkbox() ?>

    <?php // echo $form->field($model, 'fecha_creacion') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'modificado_por') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
