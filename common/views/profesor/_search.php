<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\search\UsuarioSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="usuario-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'rut') ?>

    <?= $form->field($model, 'nombre') ?>

    <?= $form->field($model, 'apellido_paterno') ?>

    <?= $form->field($model, 'apellido_materno') ?>

    <?php // echo $form->field($model, 'sexo') ?>

    <?php // echo $form->field($model, 'edad') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'email2') ?>

    <?php // echo $form->field($model, 'telefono1') ?>

    <?php // echo $form->field($model, 'telefono2') ?>

    <?php // echo $form->field($model, 'username') ?>

    <?php // echo $form->field($model, 'clave_actualizada') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'activo')->checkbox() ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'fecha_creacion') ?>

    <?php // echo $form->field($model, 'fecha_modificacion') ?>

    <?php // echo $form->field($model, 'creado_por') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'modificado_por') ?>

    <?php // echo $form->field($model, 'passwordResetTokenExpire') ?>

    <?php // echo $form->field($model, 'rol_predeterminado') ?>

    <?php // echo $form->field($model, 'anio_predeterminado') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
