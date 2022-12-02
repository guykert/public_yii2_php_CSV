<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use common\models\Ramo;
use kartik\widgets\DepDrop;
use yii\helpers\Url;
use common\models\Nivel;
use common\models\Letra;
use common\models\Empresa;
use yii\helpers\ArrayHelper;
use kartik\popover\PopoverX;

use kartik\icons\Icon;
Icon::map($this); 

/*use kartik\widgets\Select2; */


/* @var $this yii\web\View */
/* @var $model common\models\Curso */
/* @var $form yii\widgets\ActiveForm */

/* se definen los campos y el tipo de datos que contendrá el formulario en base al modelo y los botones Create Upate*/
?>
<div class="container-fluid">

    <div class="animated fadeIn">
        <div class="row">
            <div class="col-md-12">
 
                <div class="recuperarmarginescuadro">
                  <div class="thumbnail2">


                    <div class="cuadradomensaje">
                      <div class="espaciobajo">
                      <i class="icon-chevron-right tamano19"></i>
                      <span class="estimadoalumno2" >

                           Estimado(a) <?php echo Yii::$app->user->identity->nombre . ' ' . Yii::$app->user->identity->apellido_paterno; ?>


                      </span>
                    </div>
                      <div class="cuadromensaje"><p class="lead alumnoseleccionamensaje">
                        
                          <?php echo $mensaje; ?>

                      </p>
                    </div>

                    </div>
                  </div>       
                </div>

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>
