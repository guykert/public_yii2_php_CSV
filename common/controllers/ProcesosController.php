<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use common\models\PruebaAlumno;
use yii\helpers\ArrayHelper;
use common\models\PruebaAlumnoRespuesta;
use common\models\PruebaPauta;
use common\models\PruebaFormulaNota;
use common\models\Prueba;
use common\models\PruebaTablaConversionDetalle;
use yii\db\Expression;

/**
 * GoogleDriveController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class ProcesosController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
    public $tituloAyuda='AYUDA INDEX';



    public function actionIndex()
    {

        var_dump('actionIndex');

    }

    public function actionCrearArchivoText()
    {

        $msg = "Internet down";

        echo $jsonfile= "/home/desarr21/public_html/respaldoDB/newfile.txt";


        $fp = fopen($jsonfile, 'w+');

        fwrite($fp, $msg);
        fclose($fp);
 


    }


    public function actionClavesQa()
    {

        


        if(Url::base(true) == "https://qa.desarrollos-csv.com/admin"){

            $Usuarios = Usuario::find()
                ->all();

            foreach ($Usuarios as $key => $Usuario) {
                $Usuario->password_hash = '$2y$13$RvzFUCsKI6zSXBgvpIsgQ.Rd7KOYd69Nd3BpKx9BjCh/meqQWf.Zu';
                $Usuario->save();
            }
        
        }

        echo "Claves de qa Actualizadas";


    }

    public function actionBuscarRespuestasIncompletas()
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno.id','prueba_alumno.prueba_id','prueba.numero_preguntas'])
        ->where(['prueba_alumno.activo'=>1])
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->andWhere(['!=', 'prueba_alumno.respuestas_cuadradas', 1])
        ->andWhere(['is not', 'prueba_alumno.fecha_termino', null])
        ->asArray()
        ->all();


        // var_dump($PruebaAlumnos);
        // exit;

        $PruebaAlumnos = ArrayHelper::index($PruebaAlumnos,null, 'prueba_id');



        foreach ($PruebaAlumnos as $key => $prueba) {

            // Primero busco la cantidad de preguntas que tiene una prueba

            $PruebaPauta=PruebaPauta::find()
            // ->select(['count(id) as cantidad_preguntas'])
            ->where(['prueba_id'=>$prueba[0]['prueba_id']])
            ->asArray()
            ->all();



            // Busco la cantidad de respuestas del alumno

            foreach ($prueba as $key => $prueba_alumno) {

                // Primero busco la cantidad de preguntas que tiene una prueba
    
                // Busco la cantidad de respuestas del alumno
    
                $PruebaAlumnoRespuestaCount=PruebaAlumnoRespuesta::find()
    
                ->where(['prueba_alumno_respuesta.activo'=>1,'prueba_alumno_respuesta.prueba_alumno_id'=>$prueba_alumno['id']])
                ->asArray()
                ->count();




                if($PruebaAlumnoRespuestaCount >= $prueba_alumno['numero_preguntas'] ){

                    $PruebaAlumno=PruebaAlumno::findOne($prueba_alumno['id']);

                    $PruebaAlumno->respuestas_cuadradas = 1;

                    $PruebaAlumno->save();

                    // var_dump($PruebaAlumno->save());
                    // echo "<br><br>";

                    // var_dump($prueba_alumno['id']);
                    // echo "<br><br>";

                    // exit;
                }else{



                    // Recorro las preguntas de la pauta para buscar las que tienen respuesta
                    foreach ($PruebaPauta as $key => $Pauta) {

                        // var_dump($Pauta["numero_pregunta"]);
                        // echo "<br><br>";
    

                        $PruebaAlumnoRespuesta=PruebaAlumnoRespuesta::findOne(['prueba_alumno_id'=>$prueba_alumno['id'],'activo'=>1,'numero_pregunta'=>$Pauta["numero_pregunta"]]);

                        // var_dump($PruebaAlumnoRespuesta);
                        // echo "<br><br>";

                        if(!$PruebaAlumnoRespuesta){


                            $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta();
                            $PruebaAlumnoRespuesta->fecha_creacion = date("Y-m-d H:i:s");
                            $PruebaAlumnoRespuesta->creado_por = 1;
                            $PruebaAlumnoRespuesta->numero_pregunta = $Pauta["numero_pregunta"];
                            $PruebaAlumnoRespuesta->respuesta = "-";
                            $PruebaAlumnoRespuesta->prueba_alumno_id = $prueba_alumno['id'];
                            $PruebaAlumnoRespuesta->save();



                        }



                    }

                    // var_dump($prueba_alumno['prueba_id']);
                    // echo "<br><br>";

                    // var_dump($prueba_alumno['numero_preguntas']);
                    // echo "<br><br>";

                    // var_dump($PruebaAlumnoRespuestaCount);
                    // echo "<br><br>";

                    // exit;



                }
    

    
    
    
            }



        }





    }

    public function actionFinalizarPruebasTiempoExcedido()
    {

        $PruebaAlumnos=PruebaAlumno::find()
        ->select(['prueba_alumno.id','prueba_alumno.fecha_inicio','prueba_alumno.prueba_id','prueba.cantidad_minutos','prueba.numero_preguntas'])
        ->where(['prueba_alumno.activo'=>1])
        ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
        ->andWhere(['is', 'prueba_alumno.fecha_termino', null])
        ->andWhere(['is not', 'prueba_alumno.fecha_inicio', null])
        ->asArray()
        ->all();




        $PruebaAlumnos = ArrayHelper::index($PruebaAlumnos,null, 'prueba_id');



        foreach ($PruebaAlumnos as $key => $prueba) {


            foreach ($prueba as $key => $prueba_alumno) {

                $fecha_actual = new \DateTime(); 

                $fecha_inicio2 = new \DateTime($prueba_alumno['fecha_inicio']);

                $fecha_inicio2 = date_modify($fecha_inicio2, '+'.$prueba_alumno['cantidad_minutos'].' minutes');

                if($fecha_actual >= $fecha_inicio2){

                    $this->actionFinalizarPrueba($prueba_alumno['prueba_id'],$prueba_alumno['id']);
                    // if(!$PruebaAlumno->fecha_termino){
                    //     $this->redirect(array('finalizar-prueba','prueba_id'=>$Prueba->id,'prueba_alumno'=>$PruebaAlumno->id,'curso_id'=>$curso_id));
                    // }else{
                    //     //$this->redirect(array('resultados','id_ensayo'=>$ensayo->id));
                    // }
    
                    
                }
    

    

    
    
    
            }



        }





    }

    private function actionFinalizarPrueba($prueba_id,$prueba_alumno_id)
    {

        // cargamos la prueba del alumno

        $PruebaAlumno = PruebaAlumno::findOne($prueba_alumno_id);

        // Busco la data de la pauta de la prueba

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$prueba_id,'activo'=>1])->asArray()->All(); 

        $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');



        if ($PruebaAlumno) {
            
            // traigo la data de la prueba
            $PruebaAlumno->detalle_malas = "";

            $PruebaAlumno->buenas = 0;
            $PruebaAlumno->malas = 0;
            $PruebaAlumno->omitidas = 0;

            $Prueba = Prueba::findOne($prueba_id);




            foreach ($PruebaPauta as $key => $Pauta) {



                $PruebaAlumnoRespuesta=PruebaAlumnoRespuesta::findOne(['prueba_alumno_id'=>$prueba_alumno_id,'activo'=>1,'numero_pregunta'=>$Pauta["numero_pregunta"]]);

                // var_dump($PruebaAlumnoRespuesta);
                // echo "<br><br>";

                if(!$PruebaAlumnoRespuesta){


                    $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta();
                    $PruebaAlumnoRespuesta->fecha_creacion = date("Y-m-d H:i:s");
                    $PruebaAlumnoRespuesta->creado_por = 1;
                    $PruebaAlumnoRespuesta->numero_pregunta = $Pauta["numero_pregunta"];
                    $PruebaAlumnoRespuesta->respuesta = "-";
                    $PruebaAlumnoRespuesta->prueba_alumno_id = $prueba_alumno_id;
                    $PruebaAlumnoRespuesta->save();



                }



            }


            // En caso de que la data no venga por post se tomará la información que este cargada en la base de datos 

            $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'activo'=>1])->All();

            foreach ($PruebaAlumnoRespuestaGuardado as $AlumnoRespuesta) {
                if ($AlumnoRespuesta->respuesta == "" || $AlumnoRespuesta->respuesta == "-") {
                    $PruebaAlumno->omitidas++;
                    if($PruebaAlumno->detalle_malas == ""){
                        $PruebaAlumno->detalle_malas .= $AlumnoRespuesta->numero_pregunta;
                    }else{
                        $PruebaAlumno->detalle_malas .= ",".$AlumnoRespuesta->numero_pregunta;
                    }
                }else{
                    if ($PruebaPauta[$AlumnoRespuesta->numero_pregunta]["correcta"] == $AlumnoRespuesta->respuesta) {
                        $PruebaAlumno->buenas++;
                    }else{
                        $PruebaAlumno->malas++;
                        if($PruebaAlumno->detalle_malas == ""){
                            $PruebaAlumno->detalle_malas .= $AlumnoRespuesta->numero_pregunta;
                        }else{
                            $PruebaAlumno->detalle_malas .= ",".$AlumnoRespuesta->numero_pregunta;
                        }
                    }
                }
            } 



            // al tener las buenas hay que ver is la prueba trabaja con formula lineal o con tabla de conversión

            if ($Prueba->formula_id > 0) {
                $PruebaFormulaNota = PruebaFormulaNota::findOne(['id' => $Prueba->formula_id,'activo'=>1]);

                if($PruebaFormulaNota){
                    $PruebaAlumno->nota = (int)($PruebaAlumno->buenas * $PruebaFormulaNota->multiplicados) + $PruebaFormulaNota->sumar;
                }else{
                    $PruebaAlumno->nota = $PruebaAlumno->buenas;
                }
            }else{

                $PruebaTablaConversionDetalle = PruebaTablaConversionDetalle::findOne(['tabla_conversion_id'=>$Prueba->tabla_conversion_id,'preguntas_correctas'=>$PruebaAlumno->buenas,'activo'=>true]);


                if($PruebaTablaConversionDetalle){
                    $PruebaAlumno->nota = $PruebaTablaConversionDetalle->puntaje;
                }else{
                    $PruebaAlumno->nota = $PruebaAlumno->buenas;
                }

            }



            $PruebaAlumno->fecha_termino = new Expression('NOW()');

            $PruebaAlumno->save();

            

        }



    }

}
