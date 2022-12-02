<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;
use kartik\tabs\TabsX;

use kartik\widgets\SwitchInput;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Curso */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Cursos', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
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

                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => '¿Realmente quieres eliminar el registro ?',
                                        'method' => 'post',
                                    ],
                                ]) ?>

                            </div>

                        </div>
                            
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada el id

                            <div class="espacio-chico"></div>


                            <?php 
                                // echo  DetailView::widget([
                                //     'options'=>[
                                //         'class' => 'table colortabalfondo table-bordered detail-view'
                                //     ],
                                //     'model' => $model,
                                //     'attributes' => [
                                        

                                //             'region_id',
                                //             'nombre',
                                //             'descripcion',
                                //     ],
                                // ]) ;
                            ?>




                            <?php 

                                if (!$model->isNewRecord) {

                                    ?>



                                        <!--pestaña o tab	-->
                                        <div class="pestanas">



                                            <ul class="tabs nav nav-tabs" data-krajee-tabsx="tabsX_00000000" role="tablist">

                                                <li  class="obtener nav-item"><a href="#tabArticuloAsignaturas" class="nav-link active" accion=""  data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Asignaturas </a></li>
                                                <li  class="obtener nav-item"><a href="#tabArticuloHorario" class="nav-link"  data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Horario </a></li>

                                                                
                                            </ul>
                                            <div class="secciones">
                                                <!--FICHAS-->
                                                <article id="tabArticuloAsignaturas">
                                                    <div id="articuloAsignaturas">
                                                    </div>
                                                </article> 	
                                                <article id="tabArticuloHorario">
                                                    <div id="articuloHorario">
                                                    </div>
                                                </article> 
 
                                            </div>	
                                        </div>	

                                        <div  id="resultado" class="tituloprimerresultado">
                                        </div>

                                    <?php
                                    # code...
                                }

                            ?>

                            <?php 

                                $this->registerJs("

                                    cargarEstructuraTab('asignatura','#articuloAsignaturas');

                                    function cargarEstructuraTab(tabNombre,activeTab) {


                                        $(activeTab).fadeOut().empty();

                                        $.ajax({
                                            url: tabNombre,
                                            data:{id:" . $model->id . "},
                                            beforeSend:function(){
                                                $('#resultado').html('<div class=\"sk-circle11 sk-child\"></div>');
                                            },
                                            success: function(data) {
                                                $('#resultado').html('');
                                                $(activeTab).fadeOut().empty();
                                                $(activeTab).append(data).fadeIn();

                                                return true;
                                            }
                                        });


                                    }

                                    $('ul.tabs li a').click(function(){

                                        //oculta todas las secciones
                                        $('.secciones article ').hide();
                                        var	activeTab=$(this).attr('href');

                                        $(activeTab).show();

                                        if(activeTab == '#tabArticuloAsignaturas'){

                                            cargarEstructuraTab('asignatura','#articuloAsignaturas');

                                        }

                                        if(activeTab == '#tabArticuloHorario'){

                                            cargarEstructuraTab('horario-curso','#tabArticuloHorario');

                                        }

                                    });     



                                    function cargarEstructuraTab2(tabNombre,activeTab) {


                                        alert(\"test 2\");


                                    }

                                "); 

                            ?>


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


