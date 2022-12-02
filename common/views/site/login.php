<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\LoginForm */

$this->title = 'Login';
$this->params['breadcrumbs'][] = $this->title;

$fieldOptions1 = [
    'options' => ['class' => 'input-group'],
    'template' => "<div class=\"input-group-prepend\">
                      <span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
                    </div>{input}
                    <div class=\"col-md-12\">
                      {error}
                    </div>
                    
                    ",



];


?>

    <div class=" row justify-content-center">
      <div class="col-md-5">
        <div class="card-group">
          <div class=" card p-4">


          <div class=" card-body">

              <h1 class="colorBienvenidos">Bienvenid@s</h1>        
              <p class="text-muted"> <i class="fa fa-caret-right icon"></i> Ingresa usuario y contraseña</p>

                <?php 
                
                
                $form = ActiveForm::begin([
                  'id' => 'login-form',
                  'layout' => 'horizontal',
                  'fieldConfig' => [
                      'template' => " <div class=\"input-group-prepend\">
                                        <span class=\"input-group-text\"><i class=\"icon-user\"></i></span>
                                      </div>{input}
                                      <div class=\"col-md-12\">
                                      {error}
                                      </div>",
                      'horizontalCssClasses' => [
                          'error' => 'textoerror',

                      ],
                  ],
                ]);

                
                
                
                
                
                
                
                
                
                
                ?>

                    <?= $form->field($model, 'username',$fieldOptions1
                        )->label(false)->textInput(['autofocus' => 'autofocus','placeholder'=>'Usuario','class'=>'form-control','required'=>'true']); ?>

                    <?= $form->field($model, 'password',$fieldOptions1
                        
                        )->label(false)->passwordInput(['placeholder'=>'Password','class'=>'form-control','required'=>'true']); ?>




                    <?php echo $form->field($model, 'rememberMe', 
                    ['options'=>['tag'=>'div','class'=>''],

                    'template' => "<div class=\"checkbox checkbox-danger\">\n{input}\n{label}\n{error}\n{hint}\n</div>"]

                    )->input('checkbox', ['class' => ''])->label('Recordar Clave', ['class' => 'control-label']);; ?>

<hr> 
                  <div class="row">
                    <div class="col-6">
                      <button type="submit" class="btn btn-primary px-4" name="login-button">ENTRAR</button>
                    </div>
                    <div class="col-6 text-right">
                      <!-- <a class="btn btn-link px-0" href="/desarrollo_csv/admin/site/request-password-reset"><i class="fa fa-long-arrow-right icon"></i> Solicitar clave</a>                    </div> -->
                    </div>
                <?php ActiveForm::end(); ?>





          </div>

        </div>
      </div>
    </div>

