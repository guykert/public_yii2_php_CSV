<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\Breadcrumbs;
use common\assets\MantenedoresAsset;
use yii\widgets\ActiveForm;

MantenedoresAsset::register($this);

/* @var $this yii\web\View */
/* @var $model common\models\PruebaTablaConversion */

$this->title = $model->id;
/* coloca el menu breadcrumbs */
$this->params['breadcrumbs'][] = ['label' => "Admin",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => "Mantenedores",'template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
$this->params['breadcrumbs'][] = ['label' => 'Prueba Tabla Conversions', 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['index'],'template' => "<li class=\"breadcrumb-item\">{link}</li>\n"];
$this->params['breadcrumbs'][] = ['label' => 'Update','template' => "<li class=\"breadcrumb-item\">{link}</li>\n",];
/*genera los botones update y delete */
?>


<main class="main">
        <?=  Breadcrumbs::widget([

        'homeLink' =>[
            'label' => 'Inicio', 'url' => ['/site/index'],
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
                        <div class="card-header">
                            <i class="icon-note"></i> Ver información del id
                            <div class="card-actions">
                                <?= Html::a('Modificar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                                <?= Html::a('Eliminar', ['delete', 'id' => $model->id], [
                                    'class' => 'btn btn-danger',
                                    'data' => [
                                        'confirm' => 'Are you sure you want to delete this item?',
                                        'method' => 'post',
                                    ],
                                ]) ?>
                            </div>
                        </div>
                        
                        <div class="card-body">
                            En esta parte podrás ver la información que tiene asignada el id                            <hr>


                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                

                                    'nombre',
                                    'descripcion',
                               ],
                            ]) ?>


                        </div>

                        <?php 


                        ?>


                        <div class="container-fluid">
                            
                                <?php $form = ActiveForm::begin(
                                    [
                                        'enableAjaxValidation' => false,
                                        'enableClientValidation' => false,
                                    ]
                                    ); 

                                ?>

                                <div class="">
                                    <div class="row">
                                        <?php 


                                            $template = ' <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-angle-right"></i> {label}</span>
                                            {input}
                                            </div>';// falta {hint}\n{error}

                                            $template_hidden = '{input}';// falta {hint}\n{error}

                                            $inputSize = '60'; 

                                        ?>
                                        <div>
                                        <br>    
                                        </div> 


                                        <p style="margin-left: 15px;">

                                        <?= Html::submitButton('<i class="fa fa-star pad-right"></i> GUARDAR ' , ['class' => 'btn btn-success btn-flat']) ?>

                                        <br>

                                    </div>
                                    <div class="row">



                                        <div class="col-md-4 ">

                                            <?php 
                                        
                                                $contador_separador = 0;
                                            
                                                $i_general = 0;

                                                foreach($PruebaConversionDetalle as $i=>$item): 


                                                    if ($i_general < round(count($PruebaConversionDetalle) / 3,0)) {
                                                

                                                        
                                                        ?>


                                                            
                                                                <div class="">                                                
                                                                    <div class="cuadradoCompleto">
                                                                        <a class="" idpauta="188" numeropregunta="28" correcta="A">
                                                                            <div class="row col-md-12"> 
                                                                                <div class="col-md-8 numeroalt">
                                                                                <?php 

                                                                                    echo " Correctas: " . ($i + 1);

                                                                                    $item->preguntas_correctas = ($i + 1);

                                                                                    echo $form->field($item, '['.$i.']preguntas_correctas')->hiddenInput()->label('');


                                                                                ?>  
                                                                                </div>

                                                                                <div class="col-md-4 arregloingresocolumna">

                                                                                <?= $form->field($item, '['.$i.']puntaje')->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label(false) ?>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>  
                                                            
                                                            


                                                        <?php 
                                                    
                                                            if($contador_separador == 2){
                                                                echo "<div class=\"separadorpequeno\"></div>";
                                                            }else{
                                                                $contador_separador++;
                                                            }

                                                            
                                                            
                                                        ?>

                                                    <?php 

                                                        

                                                        }

                                                        $i_general++;

                                                endforeach; 

                                                
                                                    
                                            ?>

                                        </div>  
                                        
                                        <div class="col-md-4 ">

                                            <?php 
                                        
                                                $contador_separador = 0;
                                            
                                                $i_general = 0;

                                                foreach($PruebaConversionDetalle as $i=>$item): 


                                                    if (($i_general >= round(count($PruebaConversionDetalle) / 3,0)) && $i_general < ((round(count($PruebaConversionDetalle) / 3,0) * 2))) {

                                                        ?>


                                                            
                                                                <div class="">                                                
                                                                    <div class="cuadradoCompleto">
                                                                        <a class="" idpauta="188" numeropregunta="28" correcta="A">
                                                                            <div class="row col-md-12"> 
                                                                                <div class="col-md-8 numeroalt">
                                                                                <?php 

                                                                                    echo " Correctas: " . ($i + 1);

                                                                                    $item->preguntas_correctas = ($i + 1);

                                                                                    echo $form->field($item, '['.$i.']preguntas_correctas')->hiddenInput()->label('');


                                                                                ?>  
                                                                                </div>

                                                                                <div class="col-md-4 arregloingresocolumna">

                                                                                <?= $form->field($item, '['.$i.']puntaje')->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label(false) ?>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>  
                                                            
                                                            




                                                    <?php 

                                                        

                                                        }

                                                        $i_general++;

                                                endforeach; 

                                                
                                                    
                                            ?>

                                        </div>  

                                        <div class="col-md-4 ">

                                            <?php 
                                        
                                                $contador_separador = 0;
                                            
                                                $i_general = 0;

                                                foreach($PruebaConversionDetalle as $i=>$item): 

                                                    if (($i_general >= ((round(count($PruebaConversionDetalle) / 3,0) * 2)))) {
                                                

                                                        
                                                        ?>


                                                            
                                                                <div class="">                                                
                                                                    <div class="cuadradoCompleto">
                                                                        <a class="" idpauta="188" numeropregunta="28" correcta="A">
                                                                            <div class="row col-md-12"> 
                                                                                <div class="col-md-8 numeroalt">
                                                                                <?php 

                                                                                    echo " Correctas: " . ($i + 1);

                                                                                    $item->preguntas_correctas = ($i + 1);

                                                                                    echo $form->field($item, '['.$i.']preguntas_correctas')->hiddenInput()->label('');


                                                                                ?>  
                                                                                </div>

                                                                                <div class="col-md-4 arregloingresocolumna">

                                                                                <?= $form->field($item, '['.$i.']puntaje')->textInput(['style' => 'text-transform: uppercase','class'=>'form-control numeroalt'])->label(false) ?>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>  
                                                            
                                                            




                                                    <?php 

                                                        

                                                        }
                                                        $i_general++;

                                                endforeach; 
                                                    
                                                

                                            ?>

                                        </div>  

                                    </div>

                                </div>
                                
                            <?php ActiveForm::end(); ?>
                            
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


