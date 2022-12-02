<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;

use kartik\tabs\TabsX;
use yii\helpers\Url;
use common\assets\MantenedoresAsset;

MantenedoresAsset::register($this);



/* @var $this yii\web\View */
/* @var $model common\models\Empresa */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Empresas', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
/*genera los botones update y delete */
?>


<main class="main">
        <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/go-home'],
            'template' => '<li class=\'breadcrumb-item\'>{link}</li>', // template for this link only
        ],
        'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        'options' => ['class' => 'breadcrumb'],
        'tag' => 'ol',

    ]) ?>


    <div class="container-fluid">

        <div class="animated fadeIn">
            <div class="row">
                <div class="col-md-12">

                    <div class="card">
                        <div class="alineadototal">

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  Ver información del id</div>
                            <div>


                            </div>

                        </div>
                        
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada la empresa <?= $model->nombre;?>

                            <div class="espacio-chico"></div>

                            <?php 

                                // display the image uploaded or show a placeholder
                                // you can also use this code below in your `view.php` file
                                $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';

                                if($model->imagen != ""){

                                    ?>
                                        <img src="<?php echo  Url::to(['/imagenes', 'ruta' => $model->imagen, 'tipo_imagen' => 'comun']) ; ?>" class="img-thumbnail" alt="<?=$title;?>"  title="<?=$title;?>">
                                    <?php

                                }

                            ?>

                            <?= $this->render('_form_colegios-seleccion-asignatura', [
                                'model' => $model,
                                'Ramos' => $Ramos,
                                'SubRamos' => $SubRamos,
                                //'cantidadColegiosUsuario' => $cantidadColegiosUsuario,
                            ]) ?>







                        </div>

                        <div class="card-footer">



                        </div>
                        
                    </div>

                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>

    </div>






</main>


