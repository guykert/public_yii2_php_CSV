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
 
                


                    <br>

                    <div class="card">
                        <div class="cabeceradecurso">

                            <div class="row">
                                <div class="col-md-9">
                                    <h5> Curso : <?= $model['nombre_curso'];?>  -  Asignatura : <?= $model['nombre_sub_ramo'];?> <div class="card-actions"></h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="float-right">
                                    
                                        

                                    </div>
                                </div>
                            </div>

                        </div>
                        
                        <div class="card-body">
                            <div class="card-deck">

                                <div class="card sobrelevebordes">
                                    <div class="card-headermorado content-center">

                                        <div class="row">

                                            <div class="col-md-10">
                                                <h5><i class="fa fa-caret-right "></i> Asistencia</h5>
                                            </div>
                                            <div class="col-md-2 float-right">

                                                
                                                
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="card-body pb-0">

                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th class="cabeceratablamorada text-center">Presentes</th>
                                                    <th class="cabeceratablamorada text-center">Ausentes</th>
                                                    <th class="cabeceratablamorada text-center">Atrasados</th>
                                                </tr>
                                            </thead>
                                            <tbody >
                                                <?php
                                                    if(count($Asistencia) > 0){

                                                        if (ArrayHelper::keyExists('1', $Asistencia, false)) {

                                                            $presentes = count($Asistencia[1]);
        
                                                        }else{

                                                            $presentes = 0;
        
                                                        }

                                                        if (ArrayHelper::keyExists('0', $Asistencia, false)) {

                                                            $ausentes = count($Asistencia[0]);
        
                                                        }else{
        
                                                            $ausentes = 0;
        
                                                        }

                                                        if (ArrayHelper::keyExists('2', $Asistencia, false)) {

                                                            $atrasados = count($Asistencia[2]);
        
                                                        }else{
        
                                                            $atrasados = 0;
        
                                                        }

                                                        ?>
                                                            <tr>
                                                                    <td class=" text-center tipotablacontenido"><?=$presentes ;?></td>
                                                                    <td class=" text-center tipotablacontenido"><?=$ausentes ;?></td>
                                                                    <td class=" text-center tipotablacontenido"><?=$atrasados ;?></td>
                                                            </tr>
                                                            <tr>
                                                                <td ></td>
                                                                <td ></td>
                                                                <td ></td>
                                                            </tr>
                                                        <?php

                                                    }
                                                ?>

                                            </tbody>
                                        </table>



                                        
                                    </div>

                                    <div class="card-footer">
                                        
                                        <?= Html::a('Historial', ['/asignatura/historial-asistencia','id' => $model["id"],'fecha' => $fecha], ['class' => 'btn btnprimario1']);?>

                                        <?= Html::a('Pasar Asistencia', ['/asignatura/asistencia','id' => $model["id"],'curso_id' => $model["curso_id"],'fecha' => $fecha], ['class' => 'btn btnprimario1']);?>

                                    </div>
                                    
                                </div>
                                
                                <div class="card sobrelevebordes">


                                    <div class="card-headermorado content-center">

                                        <div class="row">

                                            <div class="col-md-12">
                                                <h5><i class="fa fa-caret-right "></i> Clases Online</h5>
                                            </div>

                                        </div>

                                    </div>
                                    
                                    <div class="card-body alineartodo row text-center">
                                        <div class="row col-md-12">
                                            <div class="col-md-6">
                                                <img src="<?=$this->assetBundles['common\assets\AsignaturaAsset']->baseUrl.'/img/zoom.jpg';?>" class="i" alt="">
                                                <?= Html::a('Zoom  ', ['/asignatura/zoom','id' => $model["id"],'fecha' => $fecha], ['class' => 'btn btnvideoconferencias1']);?>

                                            </div>
                                            <div class="col-md-6">
                                                <img src="<?=$this->assetBundles['common\assets\AsignaturaAsset']->baseUrl.'/img/meet.jpg';?>" class="i" alt="">
                                                <?= Html::a('Meet  ', ['/asignatura/meet','id' => $model["id"]], ['class' => 'btn btnvideoconferencias1']);?>

                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12">

                                                

                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="card-footer">
                                    <?= Html::a('Emails', ['/asignatura/emails-alumnos','id' => $model["id"]], ['class' => 'btn btnprimario1']);?>
                                    </div>

                                </div>

                            </div>

                        </div>
                        <div class="card-body">
                            <div class="card-deck">

                                <div class="card sobrelevebordes">


                                    <div class="card-headermorado content-center">

                                        <div class="row">

                                            <div class="col-md-10">
                                                <h5><i class="fa fa-caret-right "></i> Pruebas</h5>
                                            </div>
                                            <div class="col-md-2 float-right">

                                                <!-- <?= Html::a('<i class="icon-note"></i>  ', ['/asignatura/pruebas','id' => $model["id"]], ['class' => 'btn btn-success']);?> -->
                                                
                                            </div>
                                        </div>

                                    </div>
                                    
                                    <div class="card-body ">

                                        <table class="table table-bordered">


                                            <thead>
                                                <tr>
                                                    <th  class="cabeceratablamorada text-center">Nombre Prueba</th>
                                                    <th  class="cabeceratablamorada text-center">Descargar</th>
                                                    <th  class="cabeceratablamorada text-center">Cantidad Preguntas</th>
                                                    <th  class="cabeceratablamorada text-center">Activar Pruebas</th>
                                                    <th  class="cabeceratablamorada text-center">Activar Solucionario</th>
                                                    <th  class="cabeceratablamorada text-center">Configuraciones</th>
                                                    <th  class="cabeceratablamorada text-center">Config. Preguntas</th>
                                                    <th  class="cabeceratablamorada text-center">Informes</th>
                                                    <th  class="cabeceratablamorada text-center">Eliminar</th>
                                                </tr>

                                            </thead>
                                            <tbody >

                                                <?php

                                                    foreach ($Pruebas as $key => $Prueba) {

                                                        ?>

                                                            <tr>
                                                            <td><?=$Prueba['nombre']?></td>
                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php echo  Html::a('<i class="fa fa-arrow-circle-down "  style="font-size:20px;color:red">&nbsp</i> ' , ['descargas/index','ruta'=>'/files/carta_apoderado', 'ruta_archivo'=>$Prueba['prueba_ruta_archivo'] ] , ['class'=>'btntamano btn-block']) ?>

                                                            </td>
                                                            <td class="cajaFI2 text-center"><?=$Prueba['numero_preguntas']?></td>
                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php 
                                                                
                                                                    if($Prueba['publicar_hoja_respuesta'] == 1){

                                                                        echo  Html::a('<i class="fa fa-unlock "  style="font-size:20px;color:green">&nbsp</i> ' , ['#'] , ['class'=>'btntamano btn-block habilitar_hoja_de_respuesta','prueba_id'=>$Prueba['id']]);

                                                                    }else{

                                                                        echo  Html::a('<i class="fa fa-lock "  style="font-size:20px;color:red">&nbsp</i> ' , ['#'] , ['class'=>'btntamano btn-block habilitar_hoja_de_respuesta','prueba_id'=>$Prueba['id']]);

                                                                    }
                                                                
 
                                                                ?>

                                                            </td>
                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php 
                                                                
                                                                    if($Prueba['publicar_solucionario'] == 1){

                                                                        echo  Html::a('<i class="fa fa-unlock "  style="font-size:20px;color:green">&nbsp</i> ' , ['#'] , ['class'=>'btntamano btn-block habilitar_solucionario','prueba_id'=>$Prueba['id']]);

                                                                    }else{

                                                                        echo  Html::a('<i class="fa fa-lock "  style="font-size:20px;color:red">&nbsp</i> ' , ['#'] , ['class'=>'btntamano btn-block habilitar_solucionario','prueba_id'=>$Prueba['id']]);

                                                                    }
                                                                
 
                                                                ?>

                                                            </td>
                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php echo  Html::a('<i class="fa fa-cog"  style="font-size:20px;color:green">&nbsp</i> ' , ['/asignatura/editar-prueba','id' => $model["id"],'fecha' => $fecha,'prueba_id'=>$Prueba['id'] ] , ['class'=>'btntamano btn-block']) ?>

                                                            </td>
                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php echo  Html::a('<i class="fa fa-cog"  style="font-size:20px;color:blue">&nbsp</i> ' , ['/asignatura/config-preguntas','id' => $model["id"],'fecha' => $fecha,'prueba_id'=>$Prueba['id'] ] , ['class'=>'btntamano btn-block']) ?>

                                                            </td>

                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php echo  Html::a('<i class="fa fa-file-excel-o"  style="font-size:20px;color:blue">&nbsp</i> ' , ['/informes','prueba_id'=>$Prueba['id'],'curso_id' => $model["id"],'curso_asignatura_id' => $model["id"],'fecha' => $fecha] , ['class'=>'btntamano btn-block']) ?>

                                                            </td>

                                                            <td   class="cajaFI2 text-center">
                                                            
                                                                <?php echo  Html::a('<i class="fa fa-trash"  style="font-size:20px;color:red">&nbsp</i> ' , ['/asignatura/eliminar-prueba','id' => $model["id"],'fecha' => $fecha,'prueba_id'=>$Prueba['id'] ] , ['class'=>'btntamano btn-block',
                                                                            'data' => [
                                                                                'confirm' => '¿Realmente quieres eliminar el registro ?',
                                                                                'method' => 'post',
                                                                            ],]) ?>

                                                            </td>

                                                        <?php
                                                        
                                                    }
                                                ?>

                                            </tbody>

                                        </table>


                                    </div>

                                    <div class="card-footer">
                                        <?= Html::a('Nuevo', ['/asignatura/nueva-prueba','id' => $model["id"],'fecha' => $fecha], ['class' => 'btn btnsecundario1']);?>
                                    </div>

                                </div>



                            </div>

                        </div>

                        
                    </div>
                    <br>


            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>

</div>

<?php 



    $this->registerJs("

        $('.habilitar_hoja_de_respuesta').click(function(e){
            e.preventDefault();

            var boton = $(this);

            var icono = boton.children();

            var prueba_id = $(this).attr( \"prueba_id\");
            

            var resultado_ajax = boton.parent();

            $.ajax({
                url: '/profesor/asignatura/habilitar-hoja-respuesta',
                type: 'get',
                data: {'prueba_id':prueba_id},
                dataType:'json',
                success: function (response) {
                    // do something with response


                    if(response.respuesta == 1){
                        icono.removeClass('fa-lock');
                        icono.addClass('fa-unlock');
                        icono.css('color', 'green');
                    }else{
                        icono.removeClass('fa-unlock');
                        icono.addClass('fa-lock');
                        icono.css('color', 'red');
                    }


                    


                }
            });
            return false;
        
        });

        $('.habilitar_solucionario').click(function(e){
            e.preventDefault();

            var boton = $(this);

            var icono = boton.children();

            var prueba_id = $(this).attr( \"prueba_id\");
            

            var resultado_ajax = boton.parent();

            $.ajax({
                url: '/profesor/asignatura/habilitar-solucionario',
                type: 'get',
                data: {'prueba_id':prueba_id},
                dataType:'json',
                success: function (response) {
                    // do something with response


                    if(response.respuesta == 1){
                        icono.removeClass('fa-lock');
                        icono.addClass('fa-unlock');
                        icono.css('color', 'green');
                    }else{
                        icono.removeClass('fa-unlock');
                        icono.addClass('fa-lock');
                        icono.css('color', 'red');
                    }


                    


                }
            });
            return false;
        
        });

    ");
?> 
