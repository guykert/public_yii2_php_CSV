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
use common\models\RamoHijo;
use common\models\CursoAsignatura;
use common\models\MallaHorariaProfesor;
use common\components\FechasComponent;
use common\models\Dia;
use common\models\Profesor;
use common\models\Prueba;
use common\models\PruebasInformeProfesor;
use common\models\PruebaAlumno;


/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class SeleccionarCursoController extends Controller
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

    public function actionIndex($fecha_dia="",$fecha_inicio="",$fecha_final="",$fecha_solo_dia="")
    {



        // Confirmo la cantidad de cursos que tiene el usuario.

        // Primero obtengo el listado con los subramos en los que el alumno tiene cursos para desplegarlos

        
        // $cantidad_cursos = UsuarioCurso::find()
        // ->select(['COUNT(*) AS cnt'])
        // ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        // ->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')

        // // ->orWhere(['email2' => $model->email]) 
        // ->count();

        // $cantidad_cursos = UsuarioCurso::find()
        // ->select(['COUNT(sub_ramo.id) AS cnt'])
        // ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        // ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')

        // // ->orWhere(['email2' => $model->email]) 
        // ->count();

        // busco los horarios creados apra este curso




        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo', 'curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->all();

        if(count($MallaHorariaProfesor) > 0){

            $dias = Dia::getDiasActivos();

            $model =  Profesor::findOne(Yii::$app->user->identity->id);
    
            /* toma el id del usuario que está logeado*/
            $model->modificado_por = Yii::$app->user->identity->id ;     
            $model->fecha_modificacion = date("Y-m-d H:i:s");
    
            $FechasComponent = new FechasComponent();
    
            if ($model->load(Yii::$app->request->post())) {
    
                $FechasComponent->fechaInicioFinSemana(Yii::$app->request->post()["Profesor"]["fecha"],$fecha_inicio,$fecha_final,$fecha_solo_dia);
    
            }else{
                
                $FechasComponent->fechaInicioFinSemana($fecha_dia,$fecha_inicio,$fecha_final,$fecha_solo_dia);
    
            }
    
            Yii::$app->session->set('MallaHorariaProfesor',$MallaHorariaProfesor);
    
            return $this->render('index', [
                'model' => $model,
                'MallaHoraria' => $MallaHorariaProfesor,
                'dias' => $dias,
                'FechasComponent' => $FechasComponent,
            ]);

        }else{

            $Pruebas = Prueba::find()

            ->where(['prueba.activo'=>true,"empresa_id"=>Yii::$app->user->identity->colegio_predeterminada,"anio_id"=>Yii::$app->user->identity->anio_predeterminado])
            ->andWhere(['is', 'prueba.tipo_prueba_id', null])
            ->asArray()
            ->all();

            

            foreach ($Pruebas as $key => &$Prueba) {


                $PruebaAlumno=PruebaAlumno::find()
                ->select(['prueba_alumno.prueba_id','prueba_alumno.curso_id','max(prueba_alumno.nota) as puntaje_maximo','max(prueba_alumno.buenas) as preguntas_maximo','min(prueba_alumno.nota) as puntaje_minimo','min(prueba_alumno.buenas) as preguntas_minimo','count(prueba_alumno.id) as cantidad_pruebas','sum(prueba_alumno.nota) as sumatoria_notas','sum(prueba_alumno.buenas) as sumatoria_preguntas'])
                ->join('INNER JOIN','usuario','usuario.rut = prueba_alumno.rut and usuario.activo = 1')
                ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id and rol_usuario.activo = 1')
                ->join('INNER JOIN','prueba','prueba.id = prueba_alumno.prueba_id and prueba.activo = 1')
                // ->join('INNER JOIN','curso_asignatura','curso_asignatura.sub_ramo_id = prueba.sub_ramo_id and curso_asignatura.activo = 1')
                // ->join('INNER JOIN','usuario_curso','usuario_curso.curso_id = curso_asignatura.id and usuario_curso.activo = 1 and usuario_curso.usuario_id = usuario.id')
                
                ->where(['prueba_alumno.prueba_id'=>$Prueba["id"],'prueba_alumno.activo'=>1,'rol_usuario.item_name'=>'alumno','prueba.empresa_id'=>Yii::$app->user->identity->colegio_predeterminada])
                ->andWhere(['is not', 'fecha_termino', null]);



                $PruebaAlumnos = $PruebaAlumno->asArray()->one();

                $PruebaAlumnosAll = $PruebaAlumno->asArray()->all();

                // var_dump($PruebaAlumnos);
                // var_dump($PruebaAlumnosAll);

                // echo "<br><br><br>";


                $Prueba["cursos"] = [];

                foreach ($PruebaAlumnosAll as $key => $curso) {
                    $Prueba["cursos"][] = $curso['curso_id'];
                }

                $Prueba["cantidad_pruebas"] = $PruebaAlumnos["cantidad_pruebas"];
                $Prueba["puntaje_maximo"] = $PruebaAlumnos["puntaje_maximo"];

                if ($PruebaAlumnos['sumatoria_notas']> 0 && $PruebaAlumnos['cantidad_pruebas'] > 0) {
                    $Prueba["promedio"] = round($PruebaAlumnos['sumatoria_notas'] / $PruebaAlumnos['cantidad_pruebas'],0);
                }else{
                    $Prueba["promedio"] = 0;
                } 

            }

            // exit;


            return $this->render('index_pruebas', [
                'Pruebas' => $Pruebas,
            ]);

        }



    }

    public function actionIndex2()
    {



        // Confirmo la cantidad de cursos que tiene el usuario.

        // Primero obtengo el listado con los subramos en los que el alumno tiene cursos para desplegarlos

        
        // $cantidad_cursos = UsuarioCurso::find()
        // ->select(['COUNT(*) AS cnt'])
        // ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        // ->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')

        // // ->orWhere(['email2' => $model->email]) 
        // ->count();

        // $cantidad_cursos = UsuarioCurso::find()
        // ->select(['COUNT(sub_ramo.id) AS cnt'])
        // ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        // ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')

        // // ->orWhere(['email2' => $model->email]) 
        // ->count();

        $CursoAsignatura = CursoAsignatura::getCursosMenuProfesor();





        Yii::$app->session->set('RamoHijo',$CursoAsignatura);



        return $this->render('index', [
            'RamoHijo' => $CursoAsignatura,
        ]);
    }

}
