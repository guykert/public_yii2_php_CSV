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
use common\models\PruebaConversionDetalle;
use yii\helpers\ArrayHelper;
use common\models\PruebaFormulaLineal;
use common\models\FullEnsayosGenerales;

/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class SolucionarioController extends Controller
{

    public $layout = "rendir_prueba";
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
                        'actions' => ['index','profesor'],
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
                        'actions' => ['index','profesor'],
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


    public function actionProfesor($prueba_id,$curso_id)
    {

        $Prueba = Prueba::findOne($prueba_id);

        $fecha_inicio_temporal = "";

        $Prueba_preguntas=$Prueba->getPreguntasPrueba();

        $Prueba_solucionario=$Prueba->getPreguntasSolucionario();

        return $this->render('profesor', [
            'Prueba_preguntas' => $Prueba_preguntas,
            'Prueba_solucionario' => $Prueba_solucionario,
            'prueba_id'=>$Prueba->id,
            'Prueba'=>$Prueba,
            'nombre'=>$Prueba->nombre,
            'curso_id'=>$curso_id
        ]);


    }

    public function actionIndex($prueba_id,$prueba_alumno,$curso_id,$confirma="")
    {

        $Prueba = Prueba::findOne($prueba_id);

        $fecha_inicio_temporal = "";

        $CantidadPruebasAlumno = PruebaAlumno::find()
        ->where(['rut'=>Yii::$app->user->identity->rut,'prueba_id'=>$prueba_id,'activo' => 1,'curso_id'=>$curso_id])
        ->andWhere(['is not', 'fecha_termino', null])
        ->count();

        // cargamos la prueba del alumno

            $PruebaAlumno = PruebaAlumno::findOne($prueba_alumno);

            $PruebaAlumno->save();

            $Prueba_preguntas=$Prueba->getPreguntasPrueba();

            $Prueba_solucionario=$Prueba->getPreguntasSolucionario();

            for($i = 1; $i <= $Prueba->numero_preguntas; $i++) {

                $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'numero_pregunta'=>$i,'activo'=>1])->one();  
    
                if(!$PruebaAlumnoRespuestaGuardado){
                    $PruebaAlumnoRespuesta[$i] = new PruebaAlumnoRespuesta();
                }else{
                    $PruebaAlumnoRespuesta[$i] = $PruebaAlumnoRespuestaGuardado;
                }
                
            }

        $PruebaAlumno->save();

        return $this->render('index', [
            'PruebaAlumno' => $PruebaAlumno,
            'PruebaAlumnoRespuesta' => $PruebaAlumnoRespuesta,
            'Prueba_preguntas' => $Prueba_preguntas,
            'Prueba_solucionario' => $Prueba_solucionario,
            // 'CPruebasAlumno' => $CPruebasAlumno,
            'prueba_id'=>$Prueba->id,
            'prueba'=>$Prueba,
            'nombre'=>$Prueba->nombre,
            'curso_id'=>$curso_id
        ]);


    }

    public function actionBorrarRespuesta($prueba_id,$prueba_alumno,$numero_pregunta)
    {

        $estado = 0;

        $PruebaAlumnoRespuesta = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$prueba_alumno,'numero_pregunta'=>$numero_pregunta,'activo'=>1])->one();  

        $PruebaAlumnoRespuesta->modificado_por = Yii::$app->user->identity->id;

        $PruebaAlumnoRespuesta->activo = 0;

        if($PruebaAlumnoRespuesta->save()){
            $estado = 2;
        }else{
            $estado = 3;
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
