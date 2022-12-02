<?php
namespace profesor\controllers;


/* llama a los controladores */ 
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\Usuario;
use common\models\Prueba;
use common\models\Curso;

use yii\db\Expression;
use yii\base\Model;
use yii\helpers\Json;
use common\models\CursoAsignatura;
use yii\helpers\ArrayHelper;

use common\models\PruebasInformeProfesor;

/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class InformesController extends Controller
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
                        'actions' => ['index','estadisticas-generales','resultados-por-alumno','resultados-por-tramo','tabla-espesificaciones','resultados-por-eje-tematico','resultados-por-habilidad-cognitiva','estadisticas-por-pregunta','alumnos-rindieron','estadisticas-por-pregunta-dos','estadisticas-por-pregunta-sub-eje'],
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
                        'actions' => ['index','estadisticas-generales','resultados-por-alumno','resultados-por-tramo','tabla-espesificaciones','resultados-por-eje-tematico','resultados-por-habilidad-cognitiva','estadisticas-por-pregunta','alumnos-rindieron','estadisticas-por-pregunta-dos','estadisticas-por-pregunta-sub-eje'],
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

    public function actionIndex($prueba_id,$curso_id,$curso_asignatura_id="",$fecha="")
    {

        $Prueba = Prueba::findOne($prueba_id);

        $Cursos = Curso::find()
        ->where(['curso.colegio_id'=>Yii::$app->user->identity->colegio_predeterminada,'anio_id'=>Yii::$app->user->identity->anio_predeterminado,'curso.nivel_id'=>$Prueba->nivel_id, 'curso.activo'=> true])
        ->select(['curso.id','curso.nombre as nombre'])
        ->asArray()
        ->all() ;

        return $this->render('index', [
            'Prueba' => $Prueba,
            'prueba_id' => $prueba_id,
            'curso_id' => $curso_id,
            'Cursos' => $Cursos,
            'fecha' => $fecha
            
        ]);

    }

    public function actionEstadisticasGenerales($prueba_id,$curso_id="")
    {



        $PruebasInformeProfesor = PruebasInformeProfesor::getEstadisticasGenerales($prueba_id,$curso_id);


        if($PruebasInformeProfesor['division_menciones'] == 1){
            return $this->render('estadisticas_generales', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }else{
            return $this->render('estadisticas_generales', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }

    }

    public function actionResultadosPorAlumno($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getResultadosPorAlumno($prueba_id,$curso_id);

        return $this->render('resultados_por_alumno', [
            'PruebasInformeProfesor' => $PruebasInformeProfesor,
        ]);

    }
    
    public function actionAlumnosRindieron($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getAlumnosRindieron($prueba_id,$curso_id);



        return $this->render('alumno_rindio', [
            'PruebasInformeProfesor' => $PruebasInformeProfesor,
        ]);

    }
    
    public function actionResultadosPorTramo($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getResultadosPorTramo($prueba_id,$curso_id);

        return $this->render('resultados_por_tramo', [
            'PruebasInformeProfesor' => $PruebasInformeProfesor,
        ]);

    }

    public function actionTablaEspesificaciones($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getTablaEspesificaciones($prueba_id,$curso_id);

        if($PruebasInformeProfesor['division_menciones'] == 1){
            return $this->render('tabla_espesificaciones_ciencias', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }else{
            return $this->render('tabla_espesificaciones', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }



    }

    public function actionResultadosPorEjeTematico($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getResultadosPorEjeTematico($prueba_id,$curso_id);



        if($PruebasInformeProfesor['division_menciones'] == 1){
            return $this->render('resultados_por_eje_tematico_ciencias', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }else{
            return $this->render('resultados_por_eje_tematico', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }



    }

    public function actionResultadosPorHabilidadCognitiva($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getResultadosPorHabilidadCognitiva($prueba_id,$curso_id);

        return $this->render('resultados_por_habilidad_cognitiva', [
            'PruebasInformeProfesor' => $PruebasInformeProfesor,
        ]);

    }

    public function actionEstadisticasPorPregunta($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getEstadisticasPorPregunta($prueba_id,$curso_id);

        if($PruebasInformeProfesor['division_menciones'] == 1){
            return $this->render('estadisticas_por_pregunta_ciencias', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }else{
            return $this->render('estadisticas_por_pregunta', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }



    }

    public function actionEstadisticasPorPreguntaSubEje($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */




        $PruebasInformeProfesor = PruebasInformeProfesor::getEstadisticasPorPreguntaSubEje($prueba_id,$curso_id);

        if($PruebasInformeProfesor['division_menciones'] == 1){
            return $this->render('estadisticas_por_pregunta_sub_eje_ciencias', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }else{
            return $this->render('estadisticas_por_pregunta_sub_eje', [
                'PruebasInformeProfesor' => $PruebasInformeProfesor,
            ]);
        }



    }

    public function actionEstadisticasPorPreguntaDos($prueba_id,$curso_id="")
    {

        /**
        * Lista todo el modelo HistoricoAlumno. 
        * no hay variable de retorno
        */


        $PruebasInformeProfesor = PruebasInformeProfesor::getEstadisticasPorPreguntaDos($prueba_id,$curso_id);

        return $this->render('estadisticas_por_pregunta_dos', [
            'PruebasInformeProfesor' => $PruebasInformeProfesor,
            'curso_id' => $curso_id,
        ]);

    }

}
