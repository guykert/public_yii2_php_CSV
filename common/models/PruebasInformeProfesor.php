<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;


/**
 * Login form
 */
class PruebasInformeProfesor extends Model
{

    public static function getEstadisticasGenerales($prueba_id,$curso_id)
    {


        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['max(prueba_alumno.nota) as puntaje_maximo','max(prueba_alumno.buenas) as preguntas_maximo','min(prueba_alumno.nota) as puntaje_minimo','min(prueba_alumno.buenas) as preguntas_minimo','count(prueba_alumno.id) as cantidad_pruebas','sum(prueba_alumno.nota) as sumatoria_notas','sum(prueba_alumno.buenas) as sumatoria_preguntas'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        // ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        //->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->where(['prueba_alumno.prueba_id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);

        

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);



        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);


            $Curso = Curso::findOne($curso_id);
           
            
            $nombre_titulo .= " - " . $Curso->nombre;



        }


        $PruebaAlumnos = $PruebaAlumnos->asArray()->one();



        $PruebaAlumnosDetalle=PruebaAlumno::find()
        ->select(['prueba_alumno_respuesta.*'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
        ->where(['prueba_alumno.prueba_id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada]);

    

        if($curso_id != ""){

            $PruebaAlumnosDetalle->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

        }

        $PruebaAlumnosDetalle = $PruebaAlumnosDetalle->asArray()->all();

        


        // con el id de la prueba obtengo la pauta para obtener el numero maximo de preguntas

            $PruebaPauta=PruebaPauta::find()->select(['count(id) as cantidad_preguntas'])->where(['prueba_id'=>$prueba_id])->andWhere(['not', ['correcta' => null]])->andWhere(['not', ['correcta' => ""]])->asArray()->one();

                    // Busco los datos de la pauta

        $PruebaPautas=PruebaPauta::find()
        ->select(['prueba_eje_tematico.ramo_id as id_ramo','ramo.nombre as nombre_ramo','numero_pregunta','correcta'])
        ->join('INNER JOIN','prueba_eje_tematico','prueba_eje_tematico.id = prueba_pauta.eje_tematico and prueba_eje_tematico.activo = 1')
        ->join('INNER JOIN','ramo','prueba_eje_tematico.ramo_id = ramo.id and ramo.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->andWhere(['is not', 'prueba_pauta.correcta', NULL])
        ->orderBy('prueba_eje_tematico.orden','asc')
        ->asArray()
        ->all();  

        // con la prueba busco la tabla para buscar el puntaje maximo 

            $Prueba=Prueba::findOne($prueba_id);




            if($Prueba->formula_id > 0){

                $PruebaFormulaNota = PruebaFormulaNota::findOne(['id'=>$Prueba->formula_id,'activo'=>true]);

                $puntaje_maximo_posible = round(($PruebaPauta['cantidad_preguntas'] * $PruebaFormulaNota->multiplicados) + $PruebaFormulaNota->sumar,0);

            }

        // primero agrupo los ejes

            // los agrupo por titulo
            $Ramos_array = [];

            // Los agrupo por pauta



            $ramos_agrupados = ArrayHelper::index($PruebaPautas,null, 'id_ramo');



            foreach ($ramos_agrupados as $key_ramo => $preguntas_ramo) {



                $cantidad_preguntas_ramo = 0;
                $cantidad_preguntas_ramo_porcentaje = 0;
                $buenas_ramo = 0;
                $malas_ramo = 0;
                $omitidas_ramo = 0;
                foreach ($preguntas_ramo as $key => $preguntas_ramo_det) {

                    $numero_de_pregunta =  $preguntas_ramo_det["numero_pregunta"];

                    
                    foreach ($PruebaAlumnosDetalle as $key => $alumno) {
                        if ($preguntas_ramo_det["numero_pregunta"] == $numero_de_pregunta) {
                            if ($preguntas_ramo_det['correcta'] == "") {

                            } else {
                                if ($alumno["respuesta"] == "") {
                                    $omitidas_ramo++;
                                }else{
                                    if ($alumno["respuesta"] == $preguntas_ramo_det['correcta']) {
                                        $buenas_ramo++;
                                    } else {
                                        $malas_ramo++;
                                    }
                                }
                                $cantidad_preguntas_ramo_porcentaje++;
                            }
                            $cantidad_preguntas_ramo++;
                        }

                    }


                    
                }


                if ($buenas_ramo == 0 || $cantidad_preguntas_ramo_porcentaje == 0) {
                    $porcentaje_buenas = 0;
                }else{
                    $porcentaje_buenas = ($buenas_ramo * 100);
                    $porcentaje_buenas = round(($porcentaje_buenas / $cantidad_preguntas_ramo_porcentaje),1);
                }
                
                if ($malas_ramo == 0 || $cantidad_preguntas_ramo_porcentaje == 0) {
                    $porcentaje_malas = 0;
                }else{
                    $porcentaje_malas = ($malas_ramo * 100);
                    $porcentaje_malas = round(($porcentaje_malas / $cantidad_preguntas_ramo_porcentaje),1);
                }

                if ($omitidas_ramo == 0 || $cantidad_preguntas_ramo_porcentaje == 0) {
                    $porcentaje_omitidas = 0;
                }else{
                    $porcentaje_omitidas = ($omitidas_ramo * 100);
                    $porcentaje_omitidas = round(($porcentaje_omitidas / $cantidad_preguntas_ramo_porcentaje),1);
                }

                // var_dump($porcentaje);
                




                $Ramos_array[] = ['id'=>$key_ramo,'id_ramo'=>$preguntas_ramo[0]["id_ramo"],'nombre_ramo'=>$preguntas_ramo[0]["nombre_ramo"],'cantidad_preguntas'=>count($preguntas_ramo),'buenas_ramo'=>$buenas_ramo,'porcentaje_buenas'=>$porcentaje_buenas,'malas_ramo'=>$malas_ramo,'porcentaje_malas'=>$porcentaje_malas,'omitidas_ramo'=>$omitidas_ramo,'porcentaje_omitidas'=>$porcentaje_omitidas,'cantidad_preguntas_ramo'=>$cantidad_preguntas_ramo];

            }


            if ($PruebaAlumnos['sumatoria_notas']> 0 && $PruebaAlumnos['cantidad_pruebas'] > 0) {
                $promedio_res = round($PruebaAlumnos['sumatoria_notas'] / $PruebaAlumnos['cantidad_pruebas'],0);
            }else{
                $promedio_res = 0;
            }
    
            if ($PruebaAlumnos['sumatoria_preguntas']> 0 && $PruebaAlumnos['cantidad_pruebas'] > 0) {
                $preguntas_promedio_res = round($PruebaAlumnos['sumatoria_preguntas'] / $PruebaAlumnos['cantidad_pruebas'],0);
            }else{
                $preguntas_promedio_res = 0;
            }        

        // $data = ['puntaje_maximo'=>$PruebaAlumnos['puntaje_maximo'],'preguntas_maximo'=>$PruebaAlumnos['preguntas_maximo'],'puntaje_minimo'=>$PruebaAlumnos['puntaje_minimo'],'preguntas_minimo'=>$PruebaAlumnos['preguntas_minimo'],'promedio'=>round($PruebaAlumnos['sumatoria_notas'] / $PruebaAlumnos['cantidad_pruebas'],0),'preguntas_promedio'=>round($PruebaAlumnos['sumatoria_preguntas'] / $PruebaAlumnos['cantidad_pruebas'],0),'preguntas_max_correctas'=>$PruebaPauta['cantidad_preguntas'],'cantidad_pruebas'=>$PruebaAlumnos['cantidad_pruebas'],'puntaje_maximo_posible'=>$puntaje_maximo_posible,'nombre_prueba'=>$Prueba->nombre,'nombre_colegio'=>$Colegio->nombre,'nombre_curso'=>$curso];

        $data = ['puntaje_maximo'=>$PruebaAlumnos['puntaje_maximo'],'preguntas_maximo'=>$PruebaAlumnos['preguntas_maximo'],'puntaje_minimo'=>$PruebaAlumnos['puntaje_minimo'],'preguntas_minimo'=>$PruebaAlumnos['preguntas_minimo'],'promedio'=>$promedio_res,'preguntas_promedio'=>$preguntas_promedio_res,'preguntas_max_correctas'=>$PruebaPauta['cantidad_preguntas'],'cantidad_pruebas'=>$PruebaAlumnos['cantidad_pruebas'],'puntaje_maximo_posible'=>$puntaje_maximo_posible,'nombre_prueba'=>$Prueba->nombre,'nombre_titulo'=>$nombre_titulo,'division_menciones'=>$Prueba->ramo->division_menciones,'Ramos_array'=>$Ramos_array];

        return $data ;

    }

    public static function getResultadosPorAlumno($prueba_id,$curso_id)
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['usuario.rut as rut','usuario.nombre as nombre','usuario.apellido_paterno as apellido_paterno','usuario.apellido_materno as apellido_materno','prueba_alumno.buenas as buenas','prueba_alumno.malas as malas','prueba_alumno.omitidas as omitidas','prueba_alumno.nota as puntaje'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->where(['prueba_alumno.prueba_id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);


            $Curso = Curso::findOne($curso_id);
           
            
            $nombre_titulo .= " - " . $Curso->nombre;



        }

        $PruebaAlumnos = $PruebaAlumnos->asArray()->all();

        $Prueba=Prueba::findOne($prueba_id);

        $data = ['nombre_prueba'=>$Prueba->nombre,'alumnos'=>$PruebaAlumnos,'nombre_titulo'=>$nombre_titulo];

        return $data ;

    }

    public static function getAlumnosRindieron($prueba_id,$curso_id,$asignatura_id="")
    {

        $Prueba=Prueba::findOne($prueba_id);

        $Alumno = Alumno::find()
                    ->where(['usuario.activo'=>true,'curso.nivel_id'=>$Prueba->nivel_id,'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
                    ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
                    ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
                    ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
                    ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
                    ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
                    ->groupBy(['usuario.id'])
                    ->orderBy(['usuario.id'=>SORT_ASC]);
                    
        

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $Alumno->andWhere(['curso.id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }

        $Alumno = $Alumno->asArray()
        ->all();

        foreach ($Alumno as $key => &$value) {

            $value['buenas'] = 0;
            $value['malas'] = 0;
            $value['omitidas'] = 0;
            $value['puntaje'] = 0;

            $PruebaAlumnos=PruebaAlumno::find()
            ->select(['prueba_alumno.buenas as buenas','prueba_alumno.malas as malas','prueba_alumno.omitidas as omitidas','prueba_alumno.nota as nota'])
            ->where(['prueba_alumno.activo'=>1,'prueba_alumno.prueba_id'=>$prueba_id,'prueba_alumno.rut'=>$value['rut']])
            ->andWhere(['is not', 'fecha_termino', null])
            ->one();
    
            if($PruebaAlumnos){
                $value['buenas'] = $PruebaAlumnos->buenas;
                $value['malas'] = $PruebaAlumnos->malas;
                $value['omitidas'] = $PruebaAlumnos->omitidas;
                $value['puntaje'] = $PruebaAlumnos->nota;
            }

        }



        

        $data = ['nombre_prueba'=>$Prueba->nombre,'alumnos'=>$Alumno,'nombre_titulo'=>$nombre_titulo];

        return $data ;

    }

    public static function getResultadosPorTramo($prueba_id,$curso_id,$asignatura_id="")
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['count(prueba_alumno.id) as cantidad_pruebas',
        'count(IF(prueba_alumno.nota <= 199,1, NULL)) as tramo_uno',
        'count(IF(prueba_alumno.nota BETWEEN 200 and 249,1, NULL)) as tramo_dos_uno',
        'count(IF(prueba_alumno.nota BETWEEN 250 and 299,1, NULL)) as tramo_dos_dos',
        'count(IF(prueba_alumno.nota BETWEEN 300 and 349,1, NULL)) as tramo_tres_uno',
        'count(IF(prueba_alumno.nota BETWEEN 350 and 399,1, NULL)) as tramo_tres_dos',
        'count(IF(prueba_alumno.nota BETWEEN 400 and 449,1, NULL)) as tramo_cuatro_uno',
        'count(IF(prueba_alumno.nota BETWEEN 450 and 499,1, NULL)) as tramo_cuatro_dos',
        'count(IF(prueba_alumno.nota BETWEEN 500 and 549,1, NULL)) as tramo_cinco_uno',
        'count(IF(prueba_alumno.nota BETWEEN 550 and 599,1, NULL)) as tramo_cinco_dos',
        'count(IF(prueba_alumno.nota BETWEEN 600 and 649,1, NULL)) as tramo_seis_uno',
        'count(IF(prueba_alumno.nota BETWEEN 650 and 699,1, NULL)) as tramo_seis_dos',
        'count(IF(prueba_alumno.nota BETWEEN 700 and 749,1, NULL)) as tramo_siete_uno',
        'count(IF(prueba_alumno.nota BETWEEN 750 and 799,1, NULL)) as tramo_siete_dos',
        'count(IF(prueba_alumno.nota BETWEEN 800 and 850,1, NULL)) as tramo_ocho_uno',
        ])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba_alumno.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        ->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }


        $PruebaAlumnos = $PruebaAlumnos->asArray()->one();

        $Prueba=Prueba::findOne($prueba_id);

        $data = ['nombre_prueba'=>$Prueba->nombre,'tramos'=>$PruebaAlumnos,'nombre_titulo'=>$nombre_titulo];

        return $data ;

    }

    public static function getTablaEspesificaciones($prueba_id,$curso_id="")
    {

        $PruebaPauta=PruebaPauta::find()
        ->select(['prueba_eje_tematico.ramo_id as id_ramo','ramo.nombre as nombre_ramo','numero_pregunta','eje_tematico','habilidad_id','prueba_eje_tematico.nombre as nombre_eje_tematico','prueba_habilidad.nombre as nombre_habilidad'])
        ->join('INNER JOIN','prueba_eje_tematico','prueba_eje_tematico.id = prueba_pauta.eje_tematico and prueba_eje_tematico.activo = 1')
        ->join('INNER JOIN','ramo','prueba_eje_tematico.ramo_id = ramo.id and ramo.activo = 1')
        ->join('INNER JOIN','prueba_habilidad','prueba_habilidad.id = prueba_pauta.habilidad_id and prueba_habilidad.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->asArray()
        ->all();
        
 

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        $Prueba=Prueba::findOne($prueba_id);

        $Ejes = ArrayHelper::index($PruebaPauta,null, 'eje_tematico');

        // var_dump($Ejes);

        // echo "<br><br><br>";

        // primero agrupo los ejes

        $Habilidades = ArrayHelper::index($PruebaPauta,null, 'habilidad_id');

        // var_dump($Habilidades);

        // echo "<br><br><br>";

        $data = ['nombre_prueba'=>$Prueba->nombre,'Ejes'=>$Ejes,'Habilidades'=>$Habilidades,'nombre_titulo'=>$nombre_titulo,'division_menciones'=>$Prueba->ramo->division_menciones];

        return $data ;

    }

    public static function getResultadosPorEjeTematico($prueba_id,$curso_id,$asignatura_id="")
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno_respuesta.*'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
        ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba_alumno.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        ->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }

        $PruebaAlumnos = $PruebaAlumnos->asArray()->all();



        // Busco los datos de la pauta

        $PruebaPauta=PruebaPauta::find()
        ->select(['prueba_eje_tematico.ramo_id as id_ramo','ramo.nombre as nombre_ramo','numero_pregunta','eje_tematico','habilidad_id','prueba_eje_tematico.nombre as nombre_eje_tematico','correcta'])
        ->join('INNER JOIN','prueba_eje_tematico','prueba_eje_tematico.id = prueba_pauta.eje_tematico and prueba_eje_tematico.activo = 1')
        ->join('INNER JOIN','ramo','prueba_eje_tematico.ramo_id = ramo.id and ramo.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->andWhere(['is not', 'prueba_pauta.correcta', NULL])
        ->orderBy('prueba_eje_tematico.orden','asc')
        ->asArray()
        ->all();  
        

  


        $Prueba=Prueba::findOne($prueba_id);

        // primero agrupo los ejes

            // los agrupo por titulo
            $Ejes = [];

            // Los agrupo por pauta
            $Ejes_agrupados = ArrayHelper::index($PruebaPauta,null, 'eje_tematico');

            foreach ($Ejes_agrupados as $key_eje => $preguntas_ejes) {



                $cantidad_preguntas_eje = 0;
                $cantidad_preguntas_eje_porcentaje = 0;
                $buenas_eje = 0;
                $malas_eje = 0;
                $omitidas_eje = 0;
                foreach ($preguntas_ejes as $key => $eje) {
                    $numero_de_pregunta =  $eje["numero_pregunta"];
                    foreach ($PruebaAlumnos as $key => $alumno) {
                        if ($alumno["numero_pregunta"] == $numero_de_pregunta) {
                            if ($eje['correcta'] == "") {

                            } else {
                                if ($alumno["respuesta"] == "") {
                                    $omitidas_eje++;
                                }else{
                                    if ($alumno["respuesta"] == $eje['correcta']) {
                                        $buenas_eje++;
                                    } else {
                                        $malas_eje++;
                                    }
                                }
                                $cantidad_preguntas_eje_porcentaje++;
                            }
                            $cantidad_preguntas_eje++;
                        }

                    }


                    
                }


                if ($buenas_eje == 0 || $cantidad_preguntas_eje_porcentaje == 0) {
                    $porcentaje_buenas = 0;
                }else{
                    $porcentaje_buenas = ($buenas_eje * 100);
                    $porcentaje_buenas = round(($porcentaje_buenas / $cantidad_preguntas_eje_porcentaje),0);
                }
                
                if ($malas_eje == 0 || $cantidad_preguntas_eje_porcentaje == 0) {
                    $porcentaje_malas = 0;
                }else{
                    $porcentaje_malas = ($malas_eje * 100);
                    $porcentaje_malas = round(($porcentaje_malas / $cantidad_preguntas_eje_porcentaje),0);
                }

                if ($omitidas_eje == 0 || $cantidad_preguntas_eje_porcentaje == 0) {
                    $porcentaje_omitidas = 0;
                }else{
                    $porcentaje_omitidas = ($omitidas_eje * 100);
                    $porcentaje_omitidas = round(($porcentaje_omitidas / $cantidad_preguntas_eje_porcentaje),0);
                }

                // var_dump($porcentaje);
                
                //calificaciones Buenas :

                    $calificacion_buenas = "";


                    if ($porcentaje_buenas < 30) {
                        $calificacion_buenas = "Bajo";
                    }
                    if ($porcentaje_buenas >= 30 && $porcentaje_buenas <= 40) {
                        $calificacion_buenas = "Medio Bajo";
                    }
                    if ($porcentaje_buenas > 40 && $porcentaje_buenas <= 60) {
                        $calificacion_buenas = "Medio";
                    }
                    if ($porcentaje_buenas > 60 && $porcentaje_buenas <= 80) {
                        $calificacion_buenas = "Medio Alto";
                    }
                    if ($porcentaje_buenas > 80) {
                        $calificacion_buenas = "Alto";
                    }

                    $calificacion_malas = "";
                    if ($porcentaje_malas > 40) {
                        $calificacion_malas = "Bajo";
                    }
                    if ($porcentaje_malas > 30 && $porcentaje_malas <= 40) {
                        $calificacion_malas = "Medio Bajo";
                    }
                    if ($porcentaje_malas > 20 && $porcentaje_malas <= 30) {
                        $calificacion_malas = "Medio";
                    }
                    if ($porcentaje_malas > 10 && $porcentaje_malas <= 20) {
                        $calificacion_malas = "Medio Alto";
                    }
                    if ($porcentaje_malas <= 10) {
                        $calificacion_malas = "Alto";
                    }

                
                    $calificacion_omitidas = "";
                    if ($porcentaje_omitidas > 40) {
                        $calificacion_omitidas = "Bajo";
                    }
                    if ($porcentaje_omitidas > 30 && $porcentaje_omitidas <= 40) {
                        $calificacion_omitidas = "Medio Bajo";
                    }
                    if ($porcentaje_omitidas > 20 && $porcentaje_omitidas <= 30) {
                        $calificacion_omitidas = "Medio";
                    }
                    if ($porcentaje_omitidas > 10 && $porcentaje_omitidas <= 20) {
                        $calificacion_omitidas = "Medio Alto";
                    }
                    if ($porcentaje_omitidas <= 10) {
                        $calificacion_omitidas = "Alto";
                    }


                $Ejes[] = ['id'=>$key_eje,'id_ramo'=>$preguntas_ejes[0]["id_ramo"],'eje_tematico'=>$preguntas_ejes[0]["eje_tematico"],'nombre_ramo'=>$preguntas_ejes[0]["nombre_ramo"],'nombre'=>$preguntas_ejes[0]["nombre_eje_tematico"],'cantidad_preguntas'=>count($preguntas_ejes),'buenas_eje'=>$buenas_eje,'porcentaje_buenas'=>$porcentaje_buenas,'malas_eje'=>$malas_eje,'porcentaje_malas'=>$porcentaje_malas,'omitidas_eje'=>$omitidas_eje,'porcentaje_omitidas'=>$porcentaje_omitidas,'cantidad_preguntas_eje'=>$cantidad_preguntas_eje,'calificacion_buenas'=>$calificacion_buenas,'calificacion_malas'=>$calificacion_malas,'calificacion_omitidas'=>$calificacion_omitidas];

            }

        $data = ['nombre_prueba'=>$Prueba->nombre,'Ejes'=>$Ejes,'nombre_titulo'=>$nombre_titulo,'division_menciones'=>$Prueba->ramo->division_menciones];
    

        return $data ;

    }

    public static function getResultadosPorHabilidadCognitiva($prueba_id,$curso_id,$asignatura_id="")
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno_respuesta.*'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
        ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba_alumno.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        ->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada]);

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }
        
        $PruebaAlumnos = $PruebaAlumnos->asArray()->all();


        // Busco los datos de la pauta

        $PruebaPauta=PruebaPauta::find()
        ->select(['numero_pregunta','eje_tematico','habilidad_id','prueba_habilidad.nombre as nombre_habilidad','correcta'])
        ->join('INNER JOIN','prueba_habilidad','prueba_habilidad.id = prueba_pauta.habilidad_id and prueba_habilidad.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->orderBy('prueba_habilidad.orden','asc')
        ->asArray()
        ->all();       

        $Prueba=Prueba::findOne($prueba_id);

        // primero agrupo los ejes

        // los agrupo por titulo
        $Habilidad = [];

        // Los agrupo por pauta
        $Habilidad_agrupados = ArrayHelper::index($PruebaPauta,null, 'habilidad_id');



        foreach ($Habilidad_agrupados as $key_habilidad => $preguntas_habilidad) {
        $cantidad_preguntas_habilidad = 0;
        $buenas_habilidad = 0;
        $malas_habilidad = 0;
        $omitidas_habilidad = 0;

        foreach ($preguntas_habilidad as $key => $habilidad) {
        $numero_de_pregunta =  $habilidad["numero_pregunta"];
        foreach ($PruebaAlumnos as $key => $alumno) {
        if ($alumno["numero_pregunta"] == $numero_de_pregunta) {
            if ($habilidad['correcta'] == "") {

            } else {
                if ($alumno["respuesta"] == "") {
                    $omitidas_habilidad++;
                }else{
                    if ($alumno["respuesta"] == $habilidad['correcta']) {
                        $buenas_habilidad++;
                    } else {
                        $malas_habilidad++;
                    }
                }
            }
            $cantidad_preguntas_habilidad++;
        }

        }



        }


        if ($buenas_habilidad == 0 || $cantidad_preguntas_habilidad == 0) {
        $porcentaje_buenas = 0;
        }else{
        $porcentaje_buenas = ($buenas_habilidad * 100);
        $porcentaje_buenas = round(($porcentaje_buenas / $cantidad_preguntas_habilidad),0);
        }

        if ($malas_habilidad == 0 || $cantidad_preguntas_habilidad == 0) {
        $porcentaje_malas = 0;
        }else{
        $porcentaje_malas = ($malas_habilidad * 100);
        $porcentaje_malas = round(($porcentaje_malas / $cantidad_preguntas_habilidad),0);
        }

        if ($omitidas_habilidad == 0 || $cantidad_preguntas_habilidad == 0) {
        $porcentaje_omitidas = 0;
        }else{
        $porcentaje_omitidas = ($omitidas_habilidad * 100);
        $porcentaje_omitidas = round(($porcentaje_omitidas / $cantidad_preguntas_habilidad),0);
        }

        // var_dump($porcentaje);

        //calificaciones Buenas :

        $calificacion_buenas = "";


        if ($porcentaje_buenas < 30) {
        $calificacion_buenas = "Bajo";
        }
        if ($porcentaje_buenas >= 30 && $porcentaje_buenas <= 40) {
        $calificacion_buenas = "Medio Bajo";
        }
        if ($porcentaje_buenas > 40 && $porcentaje_buenas <= 60) {
        $calificacion_buenas = "Medio";
        }
        if ($porcentaje_buenas > 60 && $porcentaje_buenas <= 80) {
        $calificacion_buenas = "Medio Alto";
        }
        if ($porcentaje_buenas > 80) {
        $calificacion_buenas = "Alto";
        }

        $calificacion_malas = "";
        if ($porcentaje_malas > 40) {
        $calificacion_malas = "Bajo";
        }
        if ($porcentaje_malas > 30 && $porcentaje_malas <= 40) {
        $calificacion_malas = "Medio Bajo";
        }
        if ($porcentaje_malas > 20 && $porcentaje_malas <= 30) {
        $calificacion_malas = "Medio";
        }
        if ($porcentaje_malas > 10 && $porcentaje_malas <= 20) {
        $calificacion_malas = "Medio Alto";
        }
        if ($porcentaje_malas <= 10) {
        $calificacion_malas = "Alto";
        }


        $calificacion_omitidas = "";
        if ($porcentaje_omitidas > 40) {
        $calificacion_omitidas = "Bajo";
        }
        if ($porcentaje_omitidas > 30 && $porcentaje_omitidas <= 40) {
        $calificacion_omitidas = "Medio Bajo";
        }
        if ($porcentaje_omitidas > 20 && $porcentaje_omitidas <= 30) {
        $calificacion_omitidas = "Medio";
        }
        if ($porcentaje_omitidas > 10 && $porcentaje_omitidas <= 20) {
        $calificacion_omitidas = "Medio Alto";
        }
        if ($porcentaje_omitidas <= 10) {
        $calificacion_omitidas = "Alto";
        }


        $Habilidad[] = ['id'=>$key_habilidad,'nombre'=>$preguntas_habilidad[0]["nombre_habilidad"],'cantidad_preguntas'=>count($preguntas_habilidad),'buenas_habilidad'=>$buenas_habilidad,'porcentaje_buenas'=>$porcentaje_buenas,'malas_habilidad'=>$malas_habilidad,'porcentaje_malas'=>$porcentaje_malas,'omitidas_habilidad'=>$omitidas_habilidad,'porcentaje_omitidas'=>$porcentaje_omitidas,'cantidad_preguntas_habilidad'=>$cantidad_preguntas_habilidad,'calificacion_buenas'=>$calificacion_buenas,'calificacion_malas'=>$calificacion_malas,'calificacion_omitidas'=>$calificacion_omitidas];

        }

        $data = ['nombre_prueba'=>$Prueba->nombre,'Habilidad'=>$Habilidad,'nombre_titulo'=>$nombre_titulo];




        

        return $data ;
        
    }

    public static function getEstadisticasPorPregunta($prueba_id,$curso_id,$asignatura_id="")
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno_respuesta.*'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
        ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba_alumno.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        ->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }

        $PruebaAlumnos = $PruebaAlumnos->asArray()->all();

        $PruebaPauta=PruebaPauta::find()
        ->select(['prueba_eje_tematico.ramo_id as id_ramo','numero_pregunta','ramo.nombre as nombre_ramo','correcta','eje_tematico','habilidad_id','prueba_eje_tematico.nombre as nombre_eje_tematico','prueba_habilidad.nombre as nombre_habilidad','correcta'])
        ->join('INNER JOIN','prueba_eje_tematico','prueba_eje_tematico.id = prueba_pauta.eje_tematico and prueba_eje_tematico.activo = 1')
        ->join('INNER JOIN','ramo','prueba_eje_tematico.ramo_id = ramo.id and ramo.activo = 1')
        ->join('INNER JOIN','prueba_habilidad','prueba_habilidad.id = prueba_pauta.habilidad_id and prueba_habilidad.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->asArray()
        ->all();   



            // calculo las bueenas por pregunta

            foreach ($PruebaPauta as $key => &$pregunta) {
                $pregunta['omitidas'] = 0;
                $pregunta['buenas'] = 0;
                $pregunta['malas'] = 0;
                $numero_de_pregunta =  $pregunta["numero_pregunta"];
                foreach ($PruebaAlumnos as $key => $alumno) {
                    if ($alumno["numero_pregunta"] == $numero_de_pregunta) {
                        if ($pregunta['correcta'] == "") {

                        } else {
                            if ($alumno["respuesta"] == "") {
                                $pregunta['omitidas']++;
                            }else{
                                if ($alumno["respuesta"] == $pregunta['correcta']) {
                                    $pregunta['buenas']++;
                                } else {
                                    $pregunta['malas']++;
                                }
                            }
                        }
                    }

                }


                
            }



        // Agrupo los datos por eje y habilidad

            // primero agrupo los ejes

                $Ejes = ArrayHelper::index($PruebaPauta,null, 'eje_tematico');

            // primero agrupo los ejes

                $Habilidades = ArrayHelper::index($PruebaPauta,null, 'habilidad_id');


        // obtengo los datos generales del informe

        $Prueba=Prueba::findOne($prueba_id);

        if($Prueba->ramo->division_menciones == 1){


            $Ejes = ArrayHelper::index($PruebaPauta,null, 'id_ramo');


        }

        $data = ['nombre_prueba'=>$Prueba->nombre,'Ejes'=>$Ejes,'Habilidades'=>$Habilidades,'nombre_titulo'=>$nombre_titulo,'division_menciones'=>$Prueba->ramo->division_menciones];





            
            





        

        return $data ;
        
    }

    public static function getEstadisticasPorPreguntaSubEje($prueba_id,$curso_id,$asignatura_id="")
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno_respuesta.*'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
        ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba_alumno.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        ->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);

        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }

        $PruebaAlumnos = $PruebaAlumnos->asArray()->all();

        $PruebaPauta=PruebaPauta::find()
        ->select(['prueba_eje_tematico.ramo_id as id_ramo','numero_pregunta','ramo.nombre as nombre_ramo','correcta','eje_tematico','sub_eje_tematico','prueba_eje_tematico.nombre as nombre_eje_tematico','prueba_sub_eje_tematico.nombre as nombre_sub_eje','correcta'])
        ->join('INNER JOIN','prueba_eje_tematico','prueba_eje_tematico.id = prueba_pauta.eje_tematico and prueba_eje_tematico.activo = 1')
        ->join('INNER JOIN','ramo','prueba_eje_tematico.ramo_id = ramo.id and ramo.activo = 1')
        ->join('INNER JOIN','prueba_sub_eje_tematico','prueba_sub_eje_tematico.id = prueba_pauta.sub_eje_tematico and prueba_sub_eje_tematico.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->asArray()
        ->all();   





            // calculo las bueenas por pregunta

            foreach ($PruebaPauta as $key => &$pregunta) {
                $pregunta['omitidas'] = 0;
                $pregunta['buenas'] = 0;
                $pregunta['malas'] = 0;
                $numero_de_pregunta =  $pregunta["numero_pregunta"];
                foreach ($PruebaAlumnos as $key => $alumno) {
                    if ($alumno["numero_pregunta"] == $numero_de_pregunta) {
                        if ($pregunta['correcta'] == "") {

                        } else {
                            if ($alumno["respuesta"] == "") {
                                $pregunta['omitidas']++;
                            }else{
                                if ($alumno["respuesta"] == $pregunta['correcta']) {
                                    $pregunta['buenas']++;
                                } else {
                                    $pregunta['malas']++;
                                }
                            }
                        }
                    }

                }


                
            }



        // Agrupo los datos por eje y habilidad

            // primero agrupo los ejes

                $Ejes = ArrayHelper::index($PruebaPauta,null, 'eje_tematico');

            // primero agrupo los ejes

                $Habilidades = ArrayHelper::index($PruebaPauta,null, 'sub_eje_tematico');


        // obtengo los datos generales del informe

        $Prueba=Prueba::findOne($prueba_id);

        if($Prueba->ramo->division_menciones == 1){


            $Ejes = ArrayHelper::index($PruebaPauta,null, 'id_ramo');


        }

        $data = ['nombre_prueba'=>$Prueba->nombre,'Ejes'=>$Ejes,'Habilidades'=>$Habilidades,'nombre_titulo'=>$nombre_titulo,'division_menciones'=>$Prueba->ramo->division_menciones];





            
            





        

        return $data ;
        
    }

    public static function getEstadisticasPorPreguntaDos($prueba_id,$curso_id,$asignatura_id="")
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno_respuesta.*'])
        ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
        ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
        ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = prueba_alumno.curso_id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
        ->where(['prueba.id'=>$prueba_id,'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->andWhere(['is not', 'fecha_termino', null]);


        $nombre_titulo = Empresa::getEmpresasNombre(Yii::$app->user->identity->colegio_predeterminada);

        if($curso_id != ""){

            $PruebaAlumnos->andWhere(['prueba_alumno.curso_id'=>$curso_id]);

            $Curso = Curso::findOne($curso_id);
           
            $nombre_titulo .= " - " . $Curso->nombre;

        }

        $PruebaAlumnos = $PruebaAlumnos->asArray()->all();




        $PruebaPauta=PruebaPauta::find()
        ->select(['numero_pregunta','correcta','eje_tematico','habilidad_id','prueba_eje_tematico.nombre as nombre_eje_tematico','prueba_habilidad.nombre as nombre_habilidad','correcta'])
        ->join('INNER JOIN','prueba_eje_tematico','prueba_eje_tematico.id = prueba_pauta.eje_tematico and prueba_eje_tematico.activo = 1')
        ->join('INNER JOIN','prueba_habilidad','prueba_habilidad.id = prueba_pauta.habilidad_id and prueba_habilidad.activo = 1')
        ->where(['prueba_id'=>$prueba_id])
        ->asArray()
        ->all();   


        $PruebaAlumnoPreguntas = ArrayHelper::index($PruebaAlumnos,null, 'numero_pregunta');



        PruebasInformeProfesor::agregarEstructuraPauta($PruebaPauta,$PruebaAlumnoPreguntas);

        // obtengo los datos generales del informe

        $Prueba=Prueba::findOne($prueba_id);

        

        $data = ['nombre_prueba'=>$Prueba->nombre,'nombre_titulo'=>$nombre_titulo,'PruebaPauta'=>$PruebaPauta];

        return $data ;
        
    }

    public static function agregarEstructuraPauta(&$PruebaPauta,$PruebaAlumnoPreguntas)
    {

        $pruebas_alumno_array = [];

        foreach ($PruebaAlumnoPreguntas as $key => $PruebaAlumnoPre) {

            foreach ($PruebaAlumnoPre as $key => $PruebaAlumnoP) {

                $pruebas_alumno_array[] = $PruebaAlumnoP["prueba_alumno_id"];

            }
            break;

        }




        foreach ($PruebaPauta as $key => &$PruebaPa) {

			// Para calcular el nivel de discriminación se realizan dos sumatorias uno que calcule las buenas 
			// a la parte superior de los alumnos y uno que lo haga a la parte inferior

			// calculo la mitad

			// la mitad se redondea por lo que cuando es un numero impar hay un valor que no entra en el calculo



            $PruebaPa["alternativa_a"] = 0;
            $PruebaPa["alternativa_b"] = 0;
            $PruebaPa["alternativa_c"] = 0;
            $PruebaPa["alternativa_d"] = 0;
            $PruebaPa["alternativa_e"] = 0;

            $PruebaPa["alternativa_a_color"] = "";
            $PruebaPa["alternativa_b_color"] = "";
            $PruebaPa["alternativa_c_color"] = "";
            $PruebaPa["alternativa_d_color"] = "";
            $PruebaPa["alternativa_e_color"] = "";

            $PruebaPa["alternativa_malas_color"] = "";

            $PruebaPa["alternativa_buenas"] = 0;
            $PruebaPa["alternativa_malas"] = 0;
            $PruebaPa["alternativa_omitidas"] = 0;
            $PruebaPa["alternativa_nivel_disc"] = 0;
            $PruebaPa["alternativa_nivel_dific"] = 0;

            $cantBuenasSup = 0;

            $cantBuenasInf = 0;

            $cantidad_total = 0;

            if(count($PruebaAlumnoPreguntas) > 0){

                foreach ($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]] as $key => $alternativas) {

                    $cantidadniv_disc = count($alternativas) / 2;
    
                    $cantidadniv_disc = floor($cantidadniv_disc);
    
                    $cantidad_total = count($alternativas);
    
    
                    if($alternativas["respuesta"] == "a" || $alternativas["respuesta"] == "A"){
                        $PruebaPa["alternativa_a"]++;
                    }
                    if($alternativas["respuesta"] == "b" || $alternativas["respuesta"] == "B"){
                        $PruebaPa["alternativa_b"]++;
                    }
                    if($alternativas["respuesta"] == "c" || $alternativas["respuesta"] == "C"){
                        $PruebaPa["alternativa_c"]++;
                    }
                    if($alternativas["respuesta"] == "d" || $alternativas["respuesta"] == "D"){
                        $PruebaPa["alternativa_d"]++;
                    }
                    if($alternativas["respuesta"] == "e" || $alternativas["respuesta"] == "E"){
                        $PruebaPa["alternativa_e"]++;
                    }
    
                    if($PruebaPa["correcta"] == $alternativas["respuesta"]){
    
                        if(($key + 1) <= $cantidadniv_disc ){
    
                            $cantBuenasInf++;
        
                        }else{
        
                            $cantBuenasSup++;
    
                        }
    
                        $PruebaPa["alternativa_buenas"]++;
                    }else{
                        if($alternativas["respuesta"] == "" || $alternativas["respuesta"] == "-"){
                            $PruebaPa["alternativa_omitidas"]++;
                        }else{
                            $PruebaPa["alternativa_malas"]++;
                        }
                    }
    
    
    
                }

                $PruebaPa["alternativa_a"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_a"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));

                $PruebaPa["alternativa_b"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_b"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
                $PruebaPa["alternativa_c"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_c"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
                $PruebaPa["alternativa_d"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_d"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
                $PruebaPa["alternativa_e"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_e"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
    
    
    
                if($PruebaPa["alternativa_a"] > 20){
                    $PruebaPa["alternativa_a_color"] = "FF6B33";
                }
                if($PruebaPa["alternativa_b"] > 20){
                    $PruebaPa["alternativa_b_color"] = "FF6B33";
                }
                if($PruebaPa["alternativa_c"] > 20){
                    $PruebaPa["alternativa_c_color"] = "FF6B33";
                }
                if($PruebaPa["alternativa_d"] > 20){
                    $PruebaPa["alternativa_d_color"] = "FF6B33";
                }
                if($PruebaPa["alternativa_e"] > 20){
                    $PruebaPa["alternativa_e_color"] = "FF6B33";
                }
    
    
                if($PruebaPa["correcta"] == "a" || $PruebaPa["correcta"] == "A"){
                    $PruebaPa["alternativa_a_color"] = "00B050";
                }
                if($PruebaPa["correcta"] == "b" || $PruebaPa["correcta"] == "B"){
                    $PruebaPa["alternativa_b_color"] = "00B050";
                }
                if($PruebaPa["correcta"] == "c" || $PruebaPa["correcta"] == "C"){
                    $PruebaPa["alternativa_c_color"] = "00B050";
                }
                if($PruebaPa["correcta"] == "d" || $PruebaPa["correcta"] == "D"){
                    $PruebaPa["alternativa_d_color"] = "00B050";
                }
                if($PruebaPa["correcta"] == "e" || $PruebaPa["correcta"] == "E"){
                    $PruebaPa["alternativa_e_color"] = "00B050";
                }
    
    
    
                $PruebaPa["alternativa_malas_color"] = "";
    
                $PruebaPa["alternativa_buenas"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_buenas"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
                $PruebaPa["alternativa_malas"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_malas"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
                $PruebaPa["alternativa_omitidas"] = PruebasInformeProfesor::porcentajes($PruebaPa["alternativa_omitidas"],count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]));
                
    
                if($PruebaPa["alternativa_malas"] >= 40 ){
                    $PruebaPa["alternativa_malas_color"] = "FE2E2E";
                }
    
                $cantDiscDiv = count($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]]) / 2;
    
                $cantDiscDiv = floor($cantDiscDiv);
    
                $PruebaAlumnosDific=PruebaAlumno::find()
                ->select(['prueba_alumno_respuesta.*','prueba_alumno.rut','prueba_alumno.nota'])
                ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
                ->where(['prueba_alumno.id'=>$pruebas_alumno_array,'prueba_alumno.activo'=>1,'prueba_alumno_respuesta.numero_pregunta'=>$alternativas["numero_pregunta"]])
                ->orderBy(['prueba_alumno.nota'=>SORT_DESC])
                ->andWhere(['is not', 'fecha_termino', null])
                ->limit($cantDiscDiv)
                // ->offset(0)
                ->asArray()
                ->all();
    
                // foreach ($PruebaAlumnosDific as $key => $value) {
                //     var_dump($value["rut"]);
                //     echo "<br>";
                //     var_dump($value["nota"]);
                //     echo "<br>";
                //     var_dump($value["respuesta"]);
                //     echo "<br>";
                // }
    
                
    
                // recorremos la parte superior para ver la cantidad de buenas que tiene
                // no se traen agrupadas por que el group choca con el limit y el calculo no da
    
                $cantBuenasSup = 0;
    
                foreach($PruebaAlumnosDific as $alternativasup){
    
                    if($PruebaPa["correcta"] == $alternativasup["respuesta"]){
                        $cantBuenasSup++;
    
                    }
                }
    
                $CPreguntaNivSup=PruebaAlumno::find()
                ->select(['prueba_alumno_respuesta.*'])
                ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
                ->where(['prueba_alumno.id'=>$pruebas_alumno_array,'prueba_alumno.activo'=>1,'prueba_alumno_respuesta.numero_pregunta'=>$alternativas["numero_pregunta"]])
                ->orderBy(['prueba_alumno.nota'=>SORT_DESC])
                ->andWhere(['is not', 'fecha_termino', null])
                ->limit($cantDiscDiv)
                ->offset(0)
                ->asArray()
                ->all();
    
                // recorremos la parte superior para ver la cantidad de buenas que tiene
                // no se traen agrupadas por que el group choca con el limit y el calculo no da
    
                $cantBuenasSup = 0;
    
                foreach($CPreguntaNivSup as $alternativasup){
    
                    if($PruebaPa["correcta"] == $alternativasup["respuesta"]){
                        $cantBuenasSup++;
    
                    }
                }
    
                $CPreguntaNivInf=PruebaAlumno::find()
                ->select(['prueba_alumno_respuesta.*'])
                ->join('INNER JOIN','prueba_alumno_respuesta','prueba_alumno_respuesta.prueba_alumno_id = prueba_alumno.id and prueba_alumno_respuesta.activo = 1')
                ->where(['prueba_alumno.id'=>$pruebas_alumno_array,'prueba_alumno.activo'=>1,'prueba_alumno_respuesta.numero_pregunta'=>$alternativas["numero_pregunta"]])
                ->orderBy(['prueba_alumno.nota'=>SORT_DESC])
                ->andWhere(['is not', 'fecha_termino', null])
                ->limit($cantDiscDiv)
                ->offset($cantDiscDiv + 1)
                ->asArray()
                ->all();
    
                // recorremos la parte superior para ver la cantidad de buenas que tiene
                // no se traen agrupadas por que el group choca con el limit y el calculo no da
    
                $cantBuenasInf = 0;
    
                foreach($CPreguntaNivInf as $alternativasinf){
    
                    if($PruebaPa["correcta"] == $alternativasinf["respuesta"]){
                        $cantBuenasInf++;
    
                    }
                }
    
    
    
                // calculamos la discriminación y la dificultad
    
                // primero realizamos la resta de los valores para ver que de más de 0
    
                $cantDiscRest = $cantBuenasSup - $cantBuenasInf;
    
    
                //$cantDiscDiv = $cantidad_total / 2;
    
    
    
                $PruebaPa["alternativa_nivel_disc"] = round((((float)$cantDiscRest) / ((float)$cantDiscDiv)),3);
    
                $PruebaPa["alternativa_nivel_dific"] = round((((float)($cantBuenasSup + $cantBuenasInf)) / ((count($CPreguntaNivSup) + count($CPreguntaNivSup)))),3);
       
            }

        }

    }

    public static function porcentajes($valor_parcial=0,$valor_total=0)
    {

        if($valor_total == "0" || $valor_parcial == "0"){

            return 0;

        }else{

            return round((($valor_parcial * 100) / $valor_total),2);

        }


    }



}
