<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Curso;
use common\models\search\Curso as CursoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Ramo;
use common\models\SubRamo;
use common\models\Alumno;
use yii\data\ArrayDataProvider;
use common\components\select\SubRamoComponent;
use common\models\Dia;
use common\models\Bloque;
use common\models\AlumnoCurso;
use common\models\MallaHorariaCurso;
use common\components\select\BloqueComponent;
use common\models\MallaHorariaColegioBloque;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * CursoController Implementa las acciones del CRUD para el modeloCurso .
 * */ 
class CursoController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
    public $tituloAyuda='AYUDA INDEX';

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
                        'actions' => ['index','create','update','delete','view','sub-ramo','assign-sub-ramo','listado-alumnos','asignatura','horario-curso','crear-horario-curso','horario-curso2','bloque','eliminar-horario-curso','update-horario-curso','delete-horario-curso'],
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
                        'actions' => ['index','create','update','delete','view','sub-ramo','assign-sub-ramo','listado-alumnos','asignatura','horario-curso','crear-horario-curso','horario-curso2','bloque','eliminar-horario-curso','update-horario-curso','delete-horario-curso'],
                        'allow' => true,
                        'roles' => ['mantenedores_sistema','sub_administrador'],
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

    public function actionUpdateHorarioCurso($curso_id,$id_horario)
    {
        /**
        * Actualiza un modelo existente Curso.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        $model = $this->findModelMallaHorariaCurso($id_horario);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post())) {

            $model->usar_bloques = Yii::$app->request->post()["MallaHorariaCurso"]["usar_bloques"];

            // var_dump((!$model->usar_bloques));
            // var_dump(Yii::$app->request->post()["MallaHorariaCurso"]["usar_bloques"]);
            // var_dump($model->usar_bloques);
            // exit;

            $model->curso_id = Yii::$app->request->post()["curso_id"];

            if($model->usar_bloques == 0){



                if (ArrayHelper::keyExists('horarios_anteriores', Yii::$app->request->post()["MallaHorariaCurso"], false)) {
                    

                    
                    if(Yii::$app->request->post()["MallaHorariaCurso"]["horarios_anteriores"] > 0){

                        $MallaHorariaCurso = MallaHorariaCurso::findOne(Yii::$app->request->post()["MallaHorariaCurso"]["horarios_anteriores"]);

                        $model->hora_desde = $MallaHorariaCurso->hora_desde;

                        $model->hora_hasta = $MallaHorariaCurso->hora_hasta;

                    }else{
                        $model->hora_desde = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_desde"]));

                        $model->hora_hasta = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_hasta"]));
                    }
                }else{
                    $model->hora_desde = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_desde"]));

                    $model->hora_hasta = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_hasta"]));
                }
                

                
            }else{

                $error = 0;

                if(!$model->malla_horaria_colegio_id > 0){
               
                    $model->addError('malla_horaria_colegio_id', 'Malla Horaria es un campo obligatorio');

                }
               
                if(!$model->bloque_id > 0){
               
                    $model->addError('bloque_id', 'Bloque es un campo obligatorio');

                }


                if(count($model->getErrors()) > 0){
                    return $this->render('@common/views/curso/create_horario_curso', [
                        'model' => $model,
                        'curso' => $this->findModelCurso($id),
                    ]);
                }

                $MallaHorariaColegioBloque = MallaHorariaColegioBloque::find()
                ->select(['malla_horaria_colegio_bloque.hora_desde','malla_horaria_colegio_bloque.hora_hasta'])
                ->where(['malla_horaria_colegio_bloque.activo'=>true,
                'malla_horaria_colegio_bloque.maya_horaria_id'=>$model->malla_horaria_colegio_id,
                'malla_horaria_colegio_bloque.bloque'=>$model->bloque_id,
                'malla_horaria_colegio_bloque.dia_id'=>$model->dia_id,
                ])
                ->asArray()
                ->one();

                $model->hora_desde = $MallaHorariaColegioBloque["hora_desde"];

                $model->hora_hasta = $MallaHorariaColegioBloque["hora_hasta"];



            }

            $model->save();


            return $this->redirect(['horario-curso2','id'=>$curso_id]);
        } else {

            $MallaHorariaCurso = MallaHorariaCurso::find()
            ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo'])
            ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
            ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
            ->where(['malla_horaria_curso.activo'=>true])
            ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
            ->asArray()
            ->count();


            return $this->render('@common/views/curso/update_horario_curso', [
                'model' => $model,
                'curso_id' => $curso_id,
                'curso' => $this->findModelCurso($curso_id),
                'MallaHorariaCurso' => $MallaHorariaCurso,
            ]);
        }
    }

    public function actionDeleteHorarioCurso($id,$curso_id)
    {

        /**
        * Si el campo activo del registro está activo lo desactiva y viceversa
        * Si lo desactiva, el navegador será redirigido a la página "index" de lo contrario a "inactivo" 
        *.      * @param string $id
        * no tiene variable de retorno 
        */
        $model = $this->findModelMallaHorariaCurso($id);
        if($model->activo == true )
        {
            $model->activo = false ;
            $model->save();
            return $this->redirect(['horario-curso2','id'=>$curso_id]);     
        }else{
            $model->activo = true ;
            $model->save();
            return $this->redirect(['horario-curso2','id'=>$curso_id]);
        }
        
    }

    public function actionEliminarHorarioCurso($curso_id,$horario_curso_id)
    {

        /**
        * Si el campo activo del registro está activo lo desactiva y viceversa
        * Si lo desactiva, el navegador será redirigido a la página "index" de lo contrario a "inactivo" 
        *.      * @param string $id
        * no tiene variable de retorno 
        */


        $MallaHorariaCurso = MallaHorariaCurso::findOne($horario_curso_id);


        if($MallaHorariaCurso->activo == true )
        {
            $MallaHorariaCurso->activo = false ;
            $MallaHorariaCurso->save();
            return $this->redirect(['horario-curso2','id'=>$curso_id]);        
        }else{
            $MallaHorariaCurso->activo = true ;
            $moMallaHorariaCursodel->save();
            return $this->redirect(['horario-curso2','id'=>$curso_id]);  
        }
        
    }

    public function actionCrearHorarioCurso($id)
    {

        // $model = new MallaHorariaCurso();


        // return $this->renderAjax('@common/views/curso/crear_horario_curso', [
        //     'model_horario_curso' => $this->findModel($id),
        //     'model' => $model,
        // ]);



        $model = new MallaHorariaCurso();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {

            $model->usar_bloques = Yii::$app->request->post()["MallaHorariaCurso"]["usar_bloques"];

            // var_dump((!$model->usar_bloques));
            // var_dump(Yii::$app->request->post()["MallaHorariaCurso"]["usar_bloques"]);
            // var_dump($model->usar_bloques);
            // exit;

            $model->curso_id = Yii::$app->request->post()["curso_id"];

            if($model->usar_bloques == 0){



                if (ArrayHelper::keyExists('horarios_anteriores', Yii::$app->request->post()["MallaHorariaCurso"], false)) {
                    

                    
                    if(Yii::$app->request->post()["MallaHorariaCurso"]["horarios_anteriores"] > 0){

                        $MallaHorariaCurso = MallaHorariaCurso::findOne(Yii::$app->request->post()["MallaHorariaCurso"]["horarios_anteriores"]);

                        $model->hora_desde = $MallaHorariaCurso->hora_desde;

                        $model->hora_hasta = $MallaHorariaCurso->hora_hasta;

                    }else{
                        $model->hora_desde = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_desde"]));

                        $model->hora_hasta = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_hasta"]));
                    }
                }else{
                    $model->hora_desde = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_desde"]));

                    $model->hora_hasta = date('Y-m-d H:i:s', strtotime(Yii::$app->request->post()["hora_hasta"]));
                }
                



                $model->save();

                return $this->redirect(['horario-curso2','id'=>$model->curso_id]);
                
            }else{

                $error = 0;

                if(!$model->malla_horaria_colegio_id > 0){
               
                    $model->addError('malla_horaria_colegio_id', 'Malla Horaria es un campo obligatorio');

                }
               
                if(!$model->bloque_id > 0){
               
                    $model->addError('bloque_id', 'Bloque es un campo obligatorio');

                }


                if(count($model->getErrors()) > 0){
                    return $this->render('@common/views/curso/create_horario_curso', [
                        'model' => $model,
                        'curso' => $this->findModel($id),
                    ]);
                }

                $MallaHorariaColegioBloque = MallaHorariaColegioBloque::find()
                ->select(['malla_horaria_colegio_bloque.hora_desde','malla_horaria_colegio_bloque.hora_hasta'])
                ->where(['malla_horaria_colegio_bloque.activo'=>true,
                'malla_horaria_colegio_bloque.maya_horaria_id'=>$model->malla_horaria_colegio_id,
                'malla_horaria_colegio_bloque.bloque'=>$model->bloque_id,
                'malla_horaria_colegio_bloque.dia_id'=>$model->dia_id,
                ])
                ->asArray()
                ->one();

                $model->hora_desde = $MallaHorariaColegioBloque["hora_desde"];

                $model->hora_hasta = $MallaHorariaColegioBloque["hora_hasta"];




                $model->save();

                return $this->redirect(['horario-curso2','id'=>$model->curso_id]);

            }

 

        } else {

            // busco los horarios creados apra este curso

            $MallaHorariaCurso = MallaHorariaCurso::find()
            ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo'])
            ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
            ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
            ->where(['malla_horaria_curso.activo'=>true])
            ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
            ->asArray()
            ->count();
 



            if($model->hora_desde == ""){
                $model->hora_desde = '08:00 AM';
            }

            if($model->hora_hasta == ""){
                $model->hora_hasta = '08:00 AM';
            }


            return $this->render('@common/views/curso/create_horario_curso', [
                'model' => $model,
                'curso' => $this->findModel($id),
                'MallaHorariaCurso' => $MallaHorariaCurso,
            ]);
        }


    }

    public function actionHorarioCurso($id)
    {

        $Ramos = Ramo::getRamosSubRamosObj();


        return $this->renderAjax('@common/views/curso/horario_curso', [
            'model' => $this->findModel($id),
            'Ramos' => $Ramos,
        ]);

    }

    public function actionListadoAlumnos($id,$nombre)
    {
 


        $AlumnoCurso = AlumnoCurso::alumnosPorCurso($id,Yii::$app->user->identity->colegio_predeterminada);

        $dataProvider = new ArrayDataProvider([
            'key'=>'usuario_id',
            'allModels' => $AlumnoCurso,
            'pagination' => ['pageSize' => 1000,],
            'sort' => [
                'attributes' => ['usuario_id','rut','nombre','apellido_paterno','apellido_materno','email'],
            ],
        ]);


        return $this->render('@common/views/curso/listado_alumnos', [
            'dataProvider'=>$dataProvider,
            'nombre'=>$nombre]);

    }
    
    public function actionIndex()
    {
        /**
        * Lista todo el modelo Curso. 
        * no hay variable de retorno
        */


        $searchModel = new CursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/curso/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Curso. 
        * @param integer $id
        * no tiene variable de retorno
        */

        // $dias = Dia::getDiasActivos();

        // $bloques = Bloque::getBloquesActivos();

        // $Ramos = Ramo::getRamosSubRamosObj();

        // $MatrizDatos = [];

        // $confirmacion = [];

        // $MatrizDatosMapa = [];

        return $this->render('@common/views/curso/view', [
            'model' => $this->findModel($id),
            // 'Ramos' => $Ramos,
            // 'dias' => $dias,
            // 'bloques' => $bloques,
            // 'MatrizDatos' => $MatrizDatos,
            // 'confirmacion' => $confirmacion,
            // 'MatrizDatosMapa' => $MatrizDatosMapa,
        ]);
    }

    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo Curso.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Curso();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->colegio_id = Yii::$app->user->identity->colegio_predeterminada;
        $model->anio_id = Yii::$app->user->identity->anio_predeterminado;
        $model->cupo = 0;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/curso/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Curso.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/curso/update', [
                'model' => $model,
            ]);
        }
    }

    public function actionHorarioCurso2($id)
    {
        /**
        * Actualiza un modelo existente Curso.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        // busco los horarios creados apra este curso

        $MallaHorariaCurso = MallaHorariaCurso::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo'])
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_curso.curso_id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->all();


        

        $dias = Dia::getDiasActivos();

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");

        return $this->render('@common/views/curso/horario_curso2', [
            'model' => $model,
            'MallaHorariaCurso' => $MallaHorariaCurso,
            'dias' => $dias,
            'curso_id' => $id,
        ]);

    }

    public function actionDelete($id)
    {

        /**
        * Si el campo activo del registro está activo lo desactiva y viceversa
        * Si lo desactiva, el navegador será redirigido a la página "index" de lo contrario a "inactivo" 
        *.      * @param string $id
        * no tiene variable de retorno 
        */
        $model = $this->findModel($id);
        if($model->activo == true )
        {
            $model->activo = false ;
            $model->save();
            return $this->redirect(['index']);        
        }else{
            $model->activo = true ;
            $model->save();
            return $this->redirect(['inactivo']);  
        }
        
    }

    protected function findModel($id)
    {
        /**
        * Busca el modelo Curso en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Curso el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Curso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionSubRamo()
    {

        $SubRamo = new SubRamoComponent();

        echo $SubRamo->RecibirInformacion();

    }

    public function actionBloque()
    {

        $Bloque = new BloqueComponent();

        echo $Bloque->RecibirInformacion();

    }

    public function actionAssignSubRamo($SubRamoid,$SubRamoNombre,$CursoId,$CursoNombre)
    {



        if(SubRamo::getConfirnarCargadosAsignatura($CursoId,$SubRamoid)){
            // Si ya está asignado se reboca la asignación
            SubRamo::eliminarCursoAsignatura($CursoId,$SubRamoid);

        }else{
            // en caos de no estar asignado se asigna
            SubRamo::asignarCursoAsignatura($CursoId,$SubRamoid);

        }
         
        Yii::$app->end();

    }

    public function actionAsignatura($id)
    {

        $Ramos = Ramo::getRamosSubRamosObj();


        return $this->renderAjax('@common/views/curso/asignatura', [
            'model' => $this->findModel($id),
            'Ramos' => $Ramos,
        ]);

    }

    protected function findModelMallaHorariaCurso($id)
    {
        /**
        * Busca el modelo Curso en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Curso el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = MallaHorariaCurso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelCurso($id)
    {
        /**
        * Busca el modelo Curso en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Curso el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Curso::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
