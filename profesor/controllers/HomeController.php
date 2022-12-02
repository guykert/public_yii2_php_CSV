<?php
namespace profesor\controllers;


/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\UsuarioCurso;
use common\models\Prueba;

/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class HomeController extends Controller
{

    public $layout = "alumno";

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
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    
    }

    public function actionIndex($curso_id="")
    {

        if($curso_id){

            Yii::$app->session->set('curso_id',$curso_id);

        }else{
            $curso_id = Yii::$app->session->get('curso_id');
        }

        // Primero Busco los tipo prueba



        $Pruebas = Prueba::find()
        ->select(['prueba.sub_ramo_id','fecha_mostrar_prueba','fecha_terminar_prueba','pagina_alumno_area.nombre as nombre_area','pagina_alumno_area.id as id_area','prueba.id as id_prueba','prueba.nombre as nombre_prueba','numero_preguntas'])
        ->where(['prueba.pagina_alumno_id'=>1,'curso_asignatura.id'=>$curso_id,'prueba.activo' => 1,'prueba.muestra_resultados_web'=>1,'prueba.anio_id' => Yii::$app->user->identity->anio_predeterminado,'prueba.empresa_id'=> Yii::$app->user->identity->colegio_predeterminada])
        //->where(['prueba.pagina_alumno_id'=>1,'curso_asignatura.id'=>$curso_id,'prueba.activo' => 1,'prueba.muestra_resultados_web'=>1,'prueba.anio_id' => Yii::$app->user->identity->anio_predeterminado,'prueba.empresa_id'=> Yii::$app->user->identity->colegio_predeterminada])
        ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.sub_ramo_id = prueba.sub_ramo_id and curso_asignatura.activo = 1 ')
        ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id  and curso.activo = 1 ')
        ->join('INNER JOIN', 'pagina_alumno_area','pagina_alumno_area.id = prueba.pagina_alumno_area_id and pagina_alumno_area.activo = 1 ')
        ->orderBy(['prueba.id'=>SORT_ASC])
        ->asArray()
        ->all();



        return $this->render('index', [
            'Pruebas'=>$Pruebas,
            'curso_id'=>$curso_id,
        ]);
    }

}
