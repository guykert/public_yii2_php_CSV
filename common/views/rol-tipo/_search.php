<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\search\RolTipo */
/* @var $form yii\widgets\ActiveForm */


/*  llama al archivo form  y lo carga con la información de resultante en base a los parametros de busqueda  */
?>
<div class="rol-tipo-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>
    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'activo')->checkbox() ?>

    <?= $form->field($model, 'fecha_creacion') ?>

    <?= $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'modificado_por') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
