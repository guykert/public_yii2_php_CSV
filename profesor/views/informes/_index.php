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
                                    <h5>Prueba: <?php echo $Prueba->nombre; ?></h5>
                                </div>
                                <div class="col-md-3">
                                    <div class="float-right">
                                    
                                        

                                    </div>
                                </div>
                            </div>

                        </div>


                        
                        <div class="card-body pb-0">
                            <div class="card">

                            <div>


                                <div class="card-headermorado content-center">

                                    <div class="row">

                                        <div class="col-md-12">
                                            <h5>Prueba: <?php echo $Prueba->nombre; ?> </h5>
                                        </div>
                                        <div class="col-md-2 float-right">

                                            
                                            
                                        </div>
                                    </div>

                                </div>



                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Estadísticas Globales</div>
                                            <div class="textobajadacajaresultado"> Puntaje máximo, mínimo y promedio obtenido en el Ensayo</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['estadisticas-generales','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>

                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['estadisticas-generales','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>





                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Resultados por Alumno</div>
                                            <div class="textobajadacajaresultado">Puntajes obtenidos por los Alumnos del Colegio en el Ensayo</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['resultados-por-alumno','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['resultados-por-alumno','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Alumno Rindieron</div>
                                            <div class="textobajadacajaresultado">Identificar a los alumnos que rindieron y los que no</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['alumnos-rindieron','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span<i class="fa fa-arrow-circle-down"></i> >Descargar</span>', ['alumnos-rindieron','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Resultados por Tramo</div>
                                            <div class="textobajadacajaresultado">Total de puntajes por tramo obtenido por el Colegio en el Ensayo</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['resultados-por-tramo','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['resultados-por-tramo','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Tabla de Especificaciones</div>
                                            <div class="textobajadacajaresultado">Ejes Temáticos y Habilidades Cognitivas asociadas a las preguntas del Ensayo</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe</span>', ['tabla-espesificaciones','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>





                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i>  Resultados por Eje Temático</div>
                                            <div class="textobajadacajaresultado">Nivel de Desempeño por Eje Temático</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['resultados-por-eje-tematico','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['resultados-por-eje-tematico','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Resultados por habilidad cognitiva</div>
                                            <div class="textobajadacajaresultado">Nivel de Desempeño por Habilidad Cognitiva</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['resultados-por-habilidad-cognitiva','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['resultados-por-habilidad-cognitiva','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>


                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Estadísticas por Pregunta Agrupada por Eje y Habilidad</div>
                                            <div class="textobajadacajaresultado">Número de Alumnos con preguntas buenas. malas y omitidas en cada una de las preguntas del Ensayo ordenado por Eje Temático y/o Habilidad</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['estadisticas-por-pregunta','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['estadisticas-por-pregunta','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Estadísticas por Pregunta Agrupada por Eje y Sub-Eje</div>
                                            <div class="textobajadacajaresultado">Número de Alumnos con preguntas buenas. malas y omitidas en cada una de las preguntas del Ensayo ordenado por Eje Temático y/o Habilidad</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['estadisticas-por-pregunta-sub-eje','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['estadisticas-por-pregunta-sub-eje','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>

                                <div class=" fondocuadrosresultado">
                                    <div class="row">

                                        <div class="col-md-4 sacarpadingleftright">
                                            <div class="titulocajaresultados"><i class="fa fa-caret-right "></i> Estadísticas por cada Pregunta</div>
                                            <div class="textobajadacajaresultado">Porcentaje de respuestas buenas, malas, omitidas y por cada alternativa, Nivel de discriminación y dificultad de la pregunta</div>
                                            <div>

                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar Informe Completo</span>', ['estadisticas-por-pregunta-dos','prueba_id'=>$prueba_id], ['class' => 'btn btnrojo1']) ?>


                                            </div>

                                        </div>

                                        <div class="col-md-1">
                                            <div class="lineadivisoriadelado"></div>
                                        </div>

                                        <?php

                                            foreach ($Cursos as $key => $curso) {
                                                ?>

                                                    <div class="col-md-1 sacarpadingleftright1px alinearalcentroelementosvertical">
                                                        <div class="cuadroinformecursosolo"> 
                                                            <div class="titulocursochico"><?php echo $curso['nombre']; ?> </div>
                                                            <div>
                                                                <?= Html::a('<span><i class="fa fa-arrow-circle-down"></i> Descargar</span>', ['estadisticas-por-pregunta-dos','prueba_id'=>$prueba_id,'curso_id'=>$curso['id']], ['class' => 'btnmaschico-naranjo']) ?>
                                                            </div>
                                                        </div>
                                                    </div>

                                                <?php
                                            }

                                        ?>



                                    </div>
                                </div>


                            </div>  




                        </div>

                        <div class="card-footer">


                            <div class="row">
                                <div class="col-xs-4 col-md-4"></div>                                        

                                <div class="col-xs-2 col-md-4 text-center">

                                    <?php

                                        echo Html::a('<i class="fa fa-reply"></i> VOLVER

                                        ', ['/seleccionar-curso'], ['class'=>'btn btnprimario1']);

                                    ?>

                                </div>



                                <div class="col-xs-4 col-md-4"></div>
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
