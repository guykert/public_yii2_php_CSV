<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2; 
use common\assets\ContactoAsset;
use yii\captcha\Captcha;
ContactoAsset::register($this);
$this->title = 'Contacto';
$this->params['breadcrumbs'][] = ['label' => 'Contacto', 'url' => ['create']];
$this->params['breadcrumbs'][] = $this->title;
/* @var $this yii\web\View */
/* @var $model common\models\Contacto */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="contacto-form box box-primary">
    <?php $form = ActiveForm::begin(); ?>
    <div class="box-body table-responsive">
        <div class="class col-md-12">
            <?= $form->field($model, 'nombre')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'telefono')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'descripcion')->textarea(['rows' => 6]) ?>
            <!-- <?= $form->field($model, 'codigoVerificacion')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
            ]) ?> -->
        </div>
    </div>
    <div class="box-footer">
        <?= Html::submitButton('Enviar', ['class' => 'btn btn-success btn-flat']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php 
	$this->registerJs("
			var editor = $('textarea').ckeditor().editor;
    ");
    ?>