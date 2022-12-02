<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'input-group mb-3'],
    'inputTemplate' => "<div class=\"input-group-prepend\">
                      <span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
                    </div>{input}"
];

$fieldOptions2 = [
    'options' => ['class' => 'input-group mb-4'],
    'inputTemplate' => "<div class=\"input-group-prepend\">
                      <span class=\"input-group-text\"><i class=\"icon-lock\"></i></span>
                    </div>{input}"
];

$fieldOptions3 = [
    'options' => ['class' => 'input-group mb-4'],
    'inputTemplate' => "<div class=\"input-group-prepend\">
                      <span class=\"input-group-text\"><i class=\"icon-envelope\"></i></span>
                    </div>{input}"
];

?>

<div class="row justify-content-center">
    <div class="col-md-8">
    <div class="card-group">
        <div class="card p-4">
        <div class="card-body">
            <h1>Registro</h1>
            <p class="text-muted">Ingresa Email, usuario y contraseña</p>
            <?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class'=>'form-horizontal']]); ?>

                <?= $form->field($model, 'email',$fieldOptions3
                    )->label(false)->textInput(['autofocus' => 'autofocus','placeholder'=>'Usuario','class'=>'form-control','required'=>'true']); ?>


                <?= $form->field($model, 'username',$fieldOptions1
                    )->label(false)->textInput(['autofocus' => 'autofocus','placeholder'=>'Usuario','class'=>'form-control','required'=>'true']); ?>


                <?= $form->field($model, 'password',$fieldOptions2
                    
                    )->label(false)->passwordInput(['placeholder'=>'Password','class'=>'form-control','required'=>'true']); ?>

                <div class="row">
                <div class="col-6">
                    <?= Html::submitButton('Ingresar', ['class' => 'btn btn-primary px-4', 'name' => 'login-button']) ?>
                </div>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        </div>
        <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
        <div class="card-body text-center">
            <div>
            <h2>Información</h2>
            <p>Despues de llenar los datos será enviado un email para confirmar el registro.</p>

        </div>
        </div>
    </div>
    </div>
</div>

