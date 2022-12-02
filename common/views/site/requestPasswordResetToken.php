
<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Solicitar Clave';
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'input-group mb-3'],
    'inputTemplate' => "<div class=\"input-group-prepend\">
                      <span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
                    </div>{input}"
];

?>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group">
          <div class="card p-4">
            <div class="card-body">
              <h1><?= Html::encode($this->title) ?></h1>
              <p class="text-muted">Ingresa tu usuario y recibirás un correo con un enlace para restablecer tu clave.</p>
              <?php $form = ActiveForm::begin(['id' => 'login-form','options' => ['class'=>'form-horizontal']]); ?>

                    <?= $form->field($model, 'username')->input("text") ?>



                  <div class="row">
                    <div class="col-6">
                      <?= Html::submitButton('Enviar', ['class' => 'btn btn-primary px-4', 'name' => 'login-button']) ?>
                    </div>
                    <div class="col-6 text-right">

                    </div>
                  </div>
                <?php ActiveForm::end(); ?>
            </div>
          </div>

        </div>
      </div>
    </div>

