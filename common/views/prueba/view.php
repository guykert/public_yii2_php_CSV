<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;
use yii\widgets\ActiveForm;
use yii\widgets\DetailViewColumn;   
use kartik\tabs\TabsX;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\Prueba */

$path_gif='https://www.desarrollos-csv.com/img/cargando2.gif';

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Pruebas', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
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

                            <div class="alineadoizquierdo"><i class="icon-note"></i> &nbsp;  MANTENEDOR DE PRUEBAS</div>
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
                                    
                            En este mantenedor podrás administrar las Pruebas crear, modificar o eliminar.                            
                            
                            <div class="espacio-chico"></div>







            
                <?= DetailView::widget([
                    'model' => $model,
                    'options'=>[
                        'class' => 'table colortabalfondo table-bordered detail-view'
                    ],


                    'attributes' => [
                    
                        [                     
                            'label' => 'Ramo',
                            'value' => $model->ramo->nombre,
                        ],
                        [    
                            'label' => 'Categoría',
                            'value' => $model->categoria->nombre,
                        ], 
                        // [    
                        //     'label' => 'Sub Ramo',
                        //     'value' => $model->subRamo ? $model->subRamo->nombre : '(no definido)',
                        // ],   
                        'muestra_resultados_web',
                        'codigo',                        
                        //'fecha',
                        // [    
                        //     'label' => 'Fórmula',
                        //     'value' => $model->formula,
                        // ],
                        [    
                            'label' => 'Tiempo',
                            'value' => $model->tiempo,
                        ],   
                        [    
                            'label' => 'Id ensayo Moodle',
                            'value' => $model->externo_id,
                        ], 
                        [    
                            'label' => 'Solucionario Teórico',
                            'value' => $model->solucionario_teorico_id,
                        ], 
                        [    
                            'label' => 'Solucionario',
                            'value' => $model->solucionario_id,
                        ], 
                        [    
                            'label' => 'Migrar',
                            'value' => $model->migrar,
                        ],
                        [    
                            'label' => 'Migrar Pauta',
                            'value' => $model->migrar_pauta,
                        ],
                        [    
                            'label' => 'Número de Preguntas',
                            'value' => $model->numero_preguntas,
                        ], 

                    ],
                ]) ?>


            <?php 

                if (!$model->isNewRecord) {

                    ?>



                        <!--pestaña o tab	-->
                        <div class="pestanas">



                            <ul class="tabs nav nav-tabs" data-krajee-tabsx="tabsX_00000000" role="tablist">

                                <li  class="obtener nav-item"><a href="#tabArticuloPauta" class="nav-link active" accion=""  data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Pauta </a></li>
                                <li  class="obtener nav-item"><a href="#tabArticuloEjeTematico" class="nav-link"  data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Eje Temático </a></li>
                                <li  class="obtener nav-item"><a href="#tabArticuloVerSubEjeTematico" class="nav-link"  data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Ver Sub Eje Temático </a></li>
                                <li  class="obtener nav-item"><a href="#tabArticuloSubEjeTematico" class="nav-link"  data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Asignar Sub Eje Temático </a></li>
                                <li  class="obtener nav-item"><a href="#tabArticuloHabilidades" class="nav-link" data-toggle="tab" role="tab"><i class="fa fa-file-text-o pd-10"></i> Habilidades </a></li>

                                                
                            </ul>
                            <div class="secciones">
                                <!--FICHAS-->
                                <article id="tabArticuloPauta">
                                    <div id="articuloPauta">
                                    </div>

                                </article> 	
                                <article id="tabArticuloEjeTematico">

                                    <div id="articuloEjeTematico">
                                    </div>
                                </article> 
                                <article id="tabArticuloVerSubEjeTematico">

                                    <div id="articuloVerSubEjeTematico">
                                    </div>
                                </article> 
                                <article id="tabArticuloSubEjeTematico">

                                    <div id="articuloSubEjeTematico">
                                    </div>
                                </article> 
                                <article id="tabArticuloHabilidades">

                                    <div id="articuloHabilidades">
                                    </div>
                                </article> 
                            </div>	
                        </div>	

                        <div  id="resultado" class="tituloprimer">
        	            </div>

                    <?php
                    # code...
                }




            ?>
            
                <?php 

                    $this->registerJs("

                        cargarEstructuraTab('pauta','#articuloPauta');

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

                            if(activeTab == '#tabArticuloPauta'){

                                cargarEstructuraTab('pauta','#articuloPauta');

                            }

                            if(activeTab == '#tabArticuloEjeTematico'){

                                cargarEstructuraTab('eje-tematico','#tabArticuloEjeTematico');

                            }

                            if(activeTab == '#tabArticuloHabilidades'){

                                cargarEstructuraTab('habilidades','#tabArticuloHabilidades');

                            }

                            if(activeTab == '#tabArticuloSubEjeTematico'){

                                cargarEstructuraTab('sub-eje-tematico','#tabArticuloSubEjeTematico');

                            }

                            if(activeTab == '#tabArticuloVerSubEjeTematico'){

                                cargarEstructuraTab('ver-sub-eje-tematico','#tabArticuloVerSubEjeTematico');

                            }

                        });     






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


