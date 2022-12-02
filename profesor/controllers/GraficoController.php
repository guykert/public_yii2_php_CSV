<?php
namespace alumno\controllers;


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
class GraficoController extends Controller
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
                        'actions' => ['index'],
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
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['acceso_alumnos'],
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




    public function actionIndex($prueba_id,$prueba_alumno,$curso_id)
    {
        $Prueba = Prueba::findOne($prueba_id);
        $PruebaAlumno = PruebaAlumno::findOne($prueba_alumno);


        return $this->render('index', [
            'data'=>$PruebaAlumno->informeEjes,
            'PruebaAlumno'=>$PruebaAlumno,
            'nombre'=>$Prueba->nombre,
            'curso_id'=>$curso_id,
            'prueba_id'=>$prueba_id
        ]);


    }



}
