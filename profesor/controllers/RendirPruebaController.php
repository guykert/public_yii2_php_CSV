<?php
namespace profesor\controllers;


/* llama a los controladores */ 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Usuario;
use common\models\Prueba;
use common\models\PruebaAlumno;
use common\models\PruebaAlumnoRespuesta;
use yii\db\Expression;
use yii\base\Model;
use yii\helpers\Json;
use common\models\PruebaPauta;
use common\models\PruebaTablaConversion;
use common\models\PruebaTablaConversionDetalle;
use yii\helpers\ArrayHelper;
use common\models\PruebaFormulaNota;
use common\models\FullEnsayosGenerales;

/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class RendirPruebaController extends Controller
{

    public $layout = "alumno";
    public $info_superior;

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),


                //esto permite definir una determinada acción en caso de que no se cumplan las reglas
                // lo dejare comentado para ver si posteriormente sirve en algún caso particular
                // 'denyCallback' => function ($rule, $action) {
                //     //Esta es la acción a ejecutar en caso de que no se cumplan las reglas

                //     throw new \Exception('error');
                // },
                'rules' => [
                    [
                        'actions' => ['index','previo','finalizar-prueba','borrar-respuesta','guardar-respuesta','rendir'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    // Este es un ejemplo para bloquear un día en particular a los usuarios no autorizados
                    // [
                    //     'actions' => ['index'],
                    //     'allow' => false,
                    //     'roles' => ['@'],

                    //     //esto es para realizar un bloqueo por fechas
                    //     'matchCallback' => function ($rule, $action) {
                    //         return date('d-m') === '29-07';
                    //     }
                    // ],
                    // [
                    //     'actions' => ['index'],
                    //     'allow' => true,
                    //     'roles' => ['@'],
                    //     'matchCallback' => function ($rule, $action) {
                    //         return Usuario::isActive();
                    //     },
                    //     //esto es para realizar un bloqueo por fechas
                    //     // 'matchCallback' => function ($rule, $action) {
                    //     //     return date('d-m') === '28-07';
                    //     // }
                    // ],

                    [
                        'actions' => ['index','previo','finalizar-prueba','borrar-respuesta','guardar-respuesta','rendir'],
                        'allow' => true,
                        'roles' => ['acceso_profesores'],
                        'matchCallback' => function ($rule, $action) {
                            return Usuario::isActive();
                        },
                        //esto es para realizar un bloqueo por fechas
                        // 'matchCallback' => function ($rule, $action) {
                        //     return date('d-m') === '28-07';
                        // }
                    ],


                ],
            ],
        ];
    
    }

    public function actionFinalizarPrueba($prueba_id,$prueba_alumno,$curso_id,$taller="")
    {
        // traigo la data de la prueba

        $Prueba = Prueba::findOne($prueba_id);

        // cargamos la prueba del alumno

            $PruebaAlumno = PruebaAlumno::findOne(['rut' => Yii::$app->user->identity->rut,'fecha_termino'=>null,'prueba_id'=>$prueba_id,'id'=>$prueba_alumno]);

            // Busco la data de la pauta de la prueba

            $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$Prueba->id,'activo'=>1])->asArray()->All(); 

            $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');



        if ($PruebaAlumno) {
            
            // traigo la data de la prueba
            $PruebaAlumno->detalle_malas = "";

            $PruebaAlumno->buenas = 0;
            $PruebaAlumno->malas = 0;
            $PruebaAlumno->omitidas = 0;

            $Prueba = Prueba::findOne($prueba_id);

            for($i = 1; $i <= $Prueba->numero_preguntas; $i++) {

                $PruebaAlumnoRespuesta[$i] = new PruebaAlumnoRespuesta();

            }



            // cargo las respuestas enviadas por el alumno

            if (Model::loadMultiple($PruebaAlumnoRespuesta, Yii::$app->request->post())) {
                $PruebaAlumnoRespuesta = [];

                foreach (Yii::$app->request->post()['PruebaAlumnoRespuesta'] as $PruebaAlumnoRespuesta2) {
                    $PruebaAlumnoRespuesta[$PruebaAlumnoRespuesta2['numero_pregunta']] = new PruebaAlumnoRespuesta();
                }

                Model::loadMultiple($PruebaAlumnoRespuesta, Yii::$app->request->post());


                $error = false;
                $cantidad_on = 0;



                foreach ($PruebaAlumnoRespuesta as &$AlumnoRespuesta) {

                    $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'numero_pregunta'=>$AlumnoRespuesta->numero_pregunta,'activo'=>1])->one();  

                    if(!$PruebaAlumnoRespuestaGuardado){

                        $AlumnoRespuesta->respuesta = $AlumnoRespuesta->respuesta;
                        $AlumnoRespuesta->pregunta_id = $AlumnoRespuesta->pregunta_id;
                        $AlumnoRespuesta->prueba_alumno_id = $PruebaAlumno->id;
                        $AlumnoRespuesta->creado_por = Yii::$app->user->identity->id;

                    }else{
                        $PruebaAlumnoRespuestaGuardado->respuesta = $AlumnoRespuesta->respuesta;
                        $PruebaAlumnoRespuestaGuardado->modificado_por = Yii::$app->user->identity->id;
                        
                        $AlumnoRespuesta = $PruebaAlumnoRespuestaGuardado;
                        $AlumnoRespuesta->activo = 1;
                    }

                    if (!$AlumnoRespuesta->save()) {
                        $error = true;
                        break;
                    }


                    if ($PruebaPauta[$AlumnoRespuesta->numero_pregunta]["correcta"] != "") {

                        if ($AlumnoRespuesta->respuesta == "") {
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




                    $cantidad_on++;

                }
                


            }else{

                // En caso de que la data no venga por post se tomará la información que este cargada en la base de datos 

                $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'activo'=>1])->All();

                foreach ($PruebaAlumnoRespuestaGuardado as $AlumnoRespuesta) {
                    if ($AlumnoRespuesta->respuesta == "") {
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

        return $this->redirect(['/rendir-prueba/previo','prueba_id'=>$prueba_id,'curso_id'=>$curso_id]);

        

    }

    public function actionIndex($prueba_id)
    {

        // Confirmo si el alumno tiene pruebas terminadas 

        $CantidadPruebasAlumno = PruebaAlumno::find()
        ->where(['rut'=>Yii::$app->user->identity->rut,'prueba_id'=>$prueba_id,'activo' => 1,'curso_id'=>Yii::$app->session->get('curso_id')])
        ->andWhere(['is not', 'fecha_termino', null])
        ->count();


        return $this->render('rendir', [
            ]);


    }

    public function actionPrevio($prueba_id,$curso_id)
    {

        $Prueba = Prueba::findOne($prueba_id);



        // Confirmo si el alumno tiene pruebas terminadas 

            $CantidadPruebasAlumno = PruebaAlumno::find()
                        ->where(['rut'=>Yii::$app->user->identity->rut,'prueba_id'=>$prueba_id,'activo' => 1,'curso_id'=>$curso_id])
                        ->andWhere(['is not', 'fecha_termino', null])
                        ->count();




        if($CantidadPruebasAlumno == 0){

            return $this->redirect(['rendir','prueba_id'=>$prueba_id,'curso_id'=>$curso_id]);

        }else{

            // Si tiene pruebas despliego el listado de las pruebas.

            $PruebasAlumno = PruebaAlumno::find()
                        ->where(['rut'=>Yii::$app->user->identity->rut,'prueba_id'=>$prueba_id,'activo' => 1,'curso_id'=>$curso_id])
                        ->All();


            $CantidadPruebasAlumnoAbiertas = PruebaAlumno::find()
                        ->where(['rut'=>Yii::$app->user->identity->rut,'prueba_id'=>$prueba_id,'activo' => 1,'fecha_termino'=>null,'curso_id'=>$curso_id])
                        ->count();



            return $this->render('pruebas_anteriores', [
                'PruebasAlumno' => $PruebasAlumno,
                'CPruebasAlumno' => $CantidadPruebasAlumno,
                'prueba_id' => $prueba_id,
                'CantidadPruebasAlumnoAbiertas' => $CantidadPruebasAlumnoAbiertas,
                'curso_id'=>$curso_id,
                'nombre'=>$Prueba->nombre,
                'Prueba'=>$Prueba,
            ]);

        }



    }

    public function actionRendir($prueba_id,$curso_id,$confirma="")
    {


        date_default_timezone_set('America/Santiago');

        
        $Prueba = Prueba::findOne($prueba_id);

        $fecha_inicio_temporal = "";

        $CantidadPruebasAlumno = PruebaAlumno::find()
        ->where(['rut'=>Yii::$app->user->identity->rut,'prueba_id'=>$prueba_id,'activo' => 1,'curso_id'=>$curso_id])
        ->andWhere(['is not', 'fecha_termino', null])
        ->count();

        // cargamos la prueba del alumno

            $PruebaAlumno = PruebaAlumno::findOne(['rut' => Yii::$app->user->identity->rut,'fecha_termino'=>null,'prueba_id'=>$prueba_id,'curso_id'=>$curso_id]);



        if(!$PruebaAlumno){

            // si el alumno no tiene prueba con fecha abierta se crea una nueva prueba

            
            if($confirma == "si"){
                // aca obtenemos el id del ensayo



                $PruebaAlumno=new PruebaAlumno;
                $PruebaAlumno->prueba_id = $prueba_id;
                $PruebaAlumno->creado_por = Yii::$app->user->identity->id;
                $PruebaAlumno->fecha_inicio = new Expression('NOW()');
                $PruebaAlumno->rut = Yii::$app->user->identity->rut;
                $PruebaAlumno->curso_id = $curso_id;

                $fecha_inicio_temporal = new \DateTime();
                $fecha_inicio_temporal2 = new \DateTime();

            }

        }



        // si el alumno no tiene creada una prueba y no ha confirmado
        if(!$PruebaAlumno && $confirma == ""){

            // vemos si tiene abierto algún otro ensayo ya que e caso de que sea asi no le permitirá crear uno nuevo
            $PruebaAlumnoAbiertas = PruebaAlumno::findOne(['rut' => Yii::$app->user->identity->rut,'fecha_termino'=>null]);


            // if($PruebaAlumnoAbiertas){

            //     // si tiene ensayos abiertos se despliega la ventana de bloqueo

            //     $this->layout="general";

            //     return $this->render('display_block', [
            //         'prueba_id' => $prueba_id,
            //         'nombre' => $Prueba->nombre,
            //         'nombre_abierta' => $PruebaAbierta->prueba->nombre,
            //     ]);


            // }else{

                //$this->layout="general";
                return $this->render('index', [
                    'prueba_id' => $prueba_id,
                    'nombre' => $Prueba->nombre,
                    'curso_id'=>$curso_id,
                    ]);
                // en el caso contrario se despliega la ventana pregia donde se explicará de que se trata el ensayo
                // return $this->render('display_prev_taller', [
                //     'prueba_id' => $prueba_id,
                //     'nombre' => $Prueba->nombre,
                //     'CPruebasAlumno' => $CPruebasAlumno,
                //     'tipo' => $Prueba->listacodigos,
                // ]);

            // }

            
        }else{

            $PruebaAlumno->save();

            $Prueba_preguntas=$Prueba->getPreguntasPrueba();


            for($i = 1; $i <= $Prueba->numero_preguntas; $i++) {

                $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'numero_pregunta'=>$i,'activo'=>1])->one();  

                if(!$PruebaAlumnoRespuestaGuardado){
                    $PruebaAlumnoRespuesta[$i] = new PruebaAlumnoRespuesta();
                }else{
                    $PruebaAlumnoRespuesta[$i] = $PruebaAlumnoRespuestaGuardado;
                }
                
            }

            // Primero consulto si tiene la prueba con tiempo pausado

            // if($PruebaAlumno->tiempo_pausa > 0){

            //     // Tomo la fecha actual y le resto los segundos guardados anteriormente

            //     $PruebaAlumno->fecha_inicio = new Expression('NOW()');

            //     $PruebaAlumno->save();

            //     $PruebaAlumno = PruebaAlumno::findOne($PruebaAlumno->id);

            //     $fecha_inicio_pausa = new \DateTime($PruebaAlumno->fecha_inicio);

            //     $PruebaAlumno->tiempo_pausa = $PruebaAlumno->tiempo_pausa - 260;

            //     $fecha_inicio_pausa = date_modify($fecha_inicio_pausa, '-'. $PruebaAlumno->tiempo_pausa .' second');

                

            //     $PruebaAlumno->fecha_inicio = $fecha_inicio_pausa->format('Y-m-d H:i:s');
            //     $PruebaAlumno->tiempo_pausa = 0;

            //     $PruebaAlumno->save();

            //     $PruebaAlumno = PruebaAlumno::findOne($PruebaAlumno->id);

            // }

            if($fecha_inicio_temporal == ""){
                $fecha_inicio = new \DateTime($PruebaAlumno->fecha_inicio);
                $fecha_inicio2 = new \DateTime($PruebaAlumno->fecha_inicio);
                $fecha_alerta = new \DateTime($PruebaAlumno->fecha_inicio);
                $fecha_alerta2 = new \DateTime($PruebaAlumno->fecha_inicio);
            }else{
                $fecha_inicio = $fecha_inicio_temporal;
                $fecha_inicio2 = $fecha_inicio_temporal;
                $fecha_alerta = $fecha_inicio_temporal2;
                $fecha_alerta2 = $fecha_inicio_temporal2;
            }

            // echo  "<br><br><br>";

            // echo "fecha_inicio2 : <br>";

            // var_dump($fecha_inicio2);

            // echo  "<br>";

            // echo "PruebaAlumno->fecha_inicio : <br>";

            // var_dump($PruebaAlumno->fecha_inicio);

            // echo  "<br>";

            // echo "PruebaAlumno->id : <br>";

            // var_dump($PruebaAlumno->id);

            // echo  "<br>";

            $fecha_inicio2 = date_modify($fecha_inicio2, '+'.$Prueba->cantidad_minutos.' minutes');

            $intervalo_de_tiempo = $fecha_inicio2->getTimestamp() - $fecha_inicio->getTimestamp();

            $fecha_alerta2 = date_modify($fecha_alerta2, '+'.($Prueba->cantidad_minutos - 10).' minutes');

            $fecha_actual = new \DateTime(); 

            if($fecha_actual >= $fecha_inicio2){
                if(!$PruebaAlumno->fecha_termino){
                    $this->redirect(array('finalizar-prueba','prueba_id'=>$Prueba->id,'prueba_alumno'=>$PruebaAlumno->id,'curso_id'=>$curso_id));
                }else{
                    //$this->redirect(array('resultados','id_ensayo'=>$ensayo->id));
                }

                
            }
            



            $mostrar_alerta = 0;


            $this->info_superior = 1;

            $segundos =  $fecha_inicio2->getTimestamp() - $fecha_actual->getTimestamp();


            $segundos2 =  $fecha_alerta2->getTimestamp() - $fecha_actual->getTimestamp();

            // echo  "<br><br><br>";

            // echo "fecha_inicio_temporal : <br>";

            // var_dump($fecha_inicio_temporal);

            // echo  "<br>";

            // echo "fecha_inicio_temporal2 : <br>";

            // var_dump($fecha_inicio_temporal2);

            // echo  "<br>";

            // echo "fecha_inicio2 : <br>";

            // var_dump($fecha_inicio2);

            // echo  "<br>";
            
            // echo "intervalo_de_tiempo : " . $intervalo_de_tiempo . "<br>";



            // echo "fecha_alerta2 : <br>";

            // var_dump($fecha_alerta2);

            // echo  "<br>";

            // echo "fecha_actual : <br>";

            // var_dump($fecha_actual);

            // echo  "<br>";


            // echo "segundos : " . $segundos . "<br>";

            // echo "segundos2 : " . $segundos2 . "<br>";

            // echo "fecha php : <br>";

            // var_dump(date("Y-m-d H:i:s"));

            // echo  "<br>";

            $PruebaAlumno->save();

            $this->layout = "rendir_prueba";

            return $this->render('rendir', [
                'PruebaAlumno' => $PruebaAlumno,
                'PruebaAlumnoRespuesta' => $PruebaAlumnoRespuesta,
                'Prueba_preguntas' => $Prueba_preguntas,
                'CPruebasAlumno' => $CantidadPruebasAlumno,
                'segundos'=>$segundos,
                'segundos2'=>$segundos2,
                'prueba_id'=>$Prueba->id,
                'mostrar_alerta'=>$mostrar_alerta,
                'Prueba'=>$Prueba,
                'nombre'=>$Prueba->nombre,
                'curso_id'=>$curso_id,
            ]);


        }




    }

    public function actionBorrarRespuesta($prueba_id,$prueba_alumno,$numero_pregunta)
    {

        $estado = 0;

        $PruebaAlumnoRespuesta = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$prueba_alumno,'numero_pregunta'=>$numero_pregunta,'activo'=>1])->one();  

        if($PruebaAlumnoRespuesta){

            $PruebaAlumnoRespuesta->modificado_por = Yii::$app->user->identity->id;

            $PruebaAlumnoRespuesta->activo = 0;
    
            if($PruebaAlumnoRespuesta->save()){
                $estado = 2;
            }else{
                $estado = 3;
            }

        }



        echo Json::encode(['estado'=>$estado]);
 
    }

    public function actionGuardarRespuesta($prueba_id,$prueba_alumno,$respuesta,$numero_pregunta)
    {

        $estado = 0;

        $PruebaAlumnoRespuesta = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$prueba_alumno,'numero_pregunta'=>$numero_pregunta,'activo'=>1])->one();  

        if(!$PruebaAlumnoRespuesta){
            $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta;
            $PruebaAlumnoRespuesta->prueba_alumno_id = $prueba_alumno;
            $PruebaAlumnoRespuesta->creado_por = Yii::$app->user->identity->id;
            $PruebaAlumnoRespuesta->numero_pregunta = $numero_pregunta;

        }else{
            
            $PruebaAlumnoRespuesta->modificado_por = Yii::$app->user->identity->id;
        }

        $PruebaAlumnoRespuesta->respuesta = $respuesta;

        if($PruebaAlumnoRespuesta->save()){
            $estado = 2;
        }else{
            $estado = 3;
        }

        echo Json::encode(['estado'=>$estado]);
 
    }

}
