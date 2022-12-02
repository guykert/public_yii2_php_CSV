<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Usuario;
use common\models\User;
use common\models\PerfilForm;
use common\models\Configuracion;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use common\models\Empresa;
use common\models\Ramo;
use common\models\SubRamo;
use common\models\FormColegiosSeleccionColegio;
use common\models\AlumnoMultiple;
use yii\helpers\ArrayHelper;
use common\models\Nivel;
use common\models\Letra;
use common\models\Curso;
use common\models\Alumno;
use common\models\Rol;
use common\models\AlumnoCurso;
use common\models\MallaHorariaCurso;
use common\models\Dia;
use common\models\MallaHorariaColegioBloque;
use common\models\search\Curso as CursoSearch;
use yii\db\Expression;


class ProcesosPasoPasoController extends Controller
{
/**
 * DiaController Implementa las acciones del CRUD para el modeloDia .
 * */ 

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
    public $tituloAyuda='AYUDA INDEX';

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index','actualizar-clave','actualizar-email','actualizar-email-ok','reset-password'],

                //esto permite definir una determinada acción en caso de que no se cumplan las reglas
                // lo dejare comentado para ver si posteriormente sirve en algún caso particular
                // 'denyCallback' => function ($rule, $action) {
                //     //Esta es la acción a ejecutar en caso de que no se cumplan las reglas

                //     throw new \Exception('error');
                // },
                'rules' => [
                    [
                        'actions' => ['colegios-seleccion-colegio','nuevo-colegio','colegios-seleccion-asignatura','assign-sub-ramo','carga-alumnos','crear-horario-curso-grid','crear-horario-curso','horario-curso2','bloque','eliminar-horario-curso','update-horario-curso','delete-horario-curso'],
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
                        'actions' => ['colegios-seleccion-colegio','nuevo-colegio','colegios-seleccion-asignatura','assign-sub-ramo','carga-alumnos','crear-horario-curso-grid','crear-horario-curso','horario-curso2','bloque','eliminar-horario-curso','update-horario-curso','delete-horario-curso'],
                        'allow' => true,
                        'roles' => ['sub_administrador','administrador'],
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
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id','hora_desde' => new Expression("date_format(malla_horaria_curso.hora_desde,'%H:%i')"),'hora_hasta' => new Expression("date_format(malla_horaria_curso.hora_hasta,'%H:%i')"), 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo'])
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_curso.curso_id'=>$id])
        ->orderBy(['hora_desde'=>SORT_ASC])
        ->asArray()
        ->all();

        

        $dias = Dia::getDiasActivos();

        $model = $this->findModelCurso($id);
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
                
                // fonfirmo si existe otro curso con estas mismas caracteristicas

                
                $MallaHorariaCurso = MallaHorariaCurso::find()
                //->select(['malla_horaria_colegio_bloque.hora_desde','malla_horaria_colegio_bloque.hora_hasta'])
                ->where(['activo'=>true,
                
                //'asignatura_id'=>$model->asignatura_id,
                'hora_desde'=>$model->hora_desde,
                'hora_hasta'=>$model->hora_hasta,
                'dia_id'=>$model->dia_id,
                ])
                ->one();

                if($MallaHorariaCurso){

                    $model->addError('hora_desde', 'Este horario ya tiene una asignatura asignada');

                    return $this->render('@common/views/curso/create_horario_curso', [
                        'model' => $model,
                        'curso' => $this->findModelCurso($id),
                        'MallaHorariaCurso' => $MallaHorariaCurso,
                    ]);
                    
                }else{

                    $model->save();

                    return $this->redirect(['horario-curso2','id'=>$model->curso_id]);

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


                $MallaHorariaCurso = MallaHorariaCurso::find()
                //->select(['malla_horaria_colegio_bloque.hora_desde','malla_horaria_colegio_bloque.hora_hasta'])
                ->where(['activo'=>true,
                
                //'asignatura_id'=>$model->asignatura_id,
                'hora_desde'=>$model->hora_desde,
                'hora_hasta'=>$model->hora_hasta,
                'dia_id'=>$model->dia_id,
                ])
                ->one();

                if($MallaHorariaCurso){

                    $model->addError('hora_desde', 'Este horario ya tiene una asignatura asignada');

                    return $this->render('@common/views/curso/create_horario_curso', [
                        'model' => $model,
                        'curso' => $this->findModelCurso($id),
                        'MallaHorariaCurso' => $MallaHorariaCurso,
                    ]);
                    
                }else{

                    $model->save();

                    return $this->redirect(['horario-curso2','id'=>$model->curso_id]);

                }



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
                'curso' => $this->findModelCurso($id),
                'MallaHorariaCurso' => $MallaHorariaCurso,
            ]);
        }


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

    public function actionCrearHorarioCursoGrid()
    {

        /**
        * Lista todo el modelo Curso. 
        * no hay variable de retorno
        */


        $searchModel = new CursoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/procesos-paso-paso/listdo_cursos', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionNuevoColegio()
    {

        /**
        * Crea un nuevo modelo Empresa.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Empresa();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!$model->errors) {

                $image = $model->uploadImage();

                // upload only if valid uploaded file instance found
                if ($image !== false) {

                    $path = $model->getImageFile();




                    $usuario->image = $path;
                    $usuario->image_name = "/empresa/" .$model->id."/" . $image->name;



                    $directorios = $model->creoDirectorios();

                    



                    $image->saveAs($path);



                    
                }

                $model->save();


                $usuario = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'id' => Yii::$app->user->identity->id,
                ]);
    
    
    
                $usuario->colegio_predeterminada = $model->id;

                $usuario->save();

            } 



            return $this->goHome();
        } else {
            return $this->render('@common/views/empresa/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionColegiosSeleccionColegio()
    {




        $model = new FormColegiosSeleccionColegio();



        if ($model->load(Yii::$app->request->post())) {



            $usuario = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'id' => Yii::$app->user->identity->id,
            ]);



            $usuario->colegio_predeterminada = Yii::$app->request->post()['FormColegiosSeleccionColegio']['colegio_predeterminada'];

            if (!$model->errors) {




                $usuario->save();




            } 


            Yii::$app->getSession()->setFlash('success', 'Los datos del perfil fueron modificados.');

            return $this->goHome();
        }



        return $this->render('@common/views/procesos-paso-paso/colegios-seleccion-colegio', [
            'model' => $model,
            //'cantidadColegiosUsuario' => $cantidadColegiosUsuario,
            // 'sedesUsuario' => $sedesUsuario,
            // 'cantidadRolesUsuario' => $cantidadRolesUsuario,
            // 'rolesUsuario' => $rolesUsuario,
        ]);

    }

    public function actionColegiosSeleccionAsignatura()
    {

        $model = Empresa::findOne([
            'id' => Yii::$app->user->identity->colegio_predeterminada,
        ]);

        $Ramos = Ramo::getRamosObj();

        $SubRamos = SubRamo::getSubRamosObj($Ramos);

        return $this->render('@common/views/procesos-paso-paso/colegios-seleccion-asignatura', [
            'model' => $model,
            'Ramos' => $Ramos,
            'SubRamos' => $SubRamos,
            // 'sedesUsuario' => $sedesUsuario,
            // 'cantidadRolesUsuario' => $cantidadRolesUsuario,
            // 'rolesUsuario' => $rolesUsuario,
        ]);

    }

    public function actionAssignSubRamo($subRamoid,$subRamoname,$empresaid,$empresaname)
    {



        if(SubRamo::getConfirnarCargadosEmpresa($empresaid,$subRamoid)){
            // Si ya está asignado se reboca la asignación
            SubRamo::eliminarHijo($subRamoid,$empresaid);

        }else{
            // en caos de no estar asignado se asigna
            SubRamo::asignarHijo($empresaid,$empresaname,$subRamoid,$subRamoname);

        }
         
        Yii::$app->end();

    }

    public function actionCargaAlumnos()
    {

        set_time_limit ( 0 );
        error_reporting ( E_ALL );

        $model = new AlumnoMultiple(['scenario' => 'tercer_paso']);


        if ($model->load(Yii::$app->request->post())) {

            //excel          
            $archivo = UploadedFile::getInstance($model,'excel');
            if($archivo){
                $nombre = rand(0,9999).'-'. $archivo->name  ;
                $model->excel = $nombre;
                $archivo->saveAs(Yii::getAlias('@backend').'/uploads/estructura_colegios/'.utf8_decode($model->excel));
            }
            $excel = Yii::getAlias('@backend').'/uploads/estructura_colegios/'.utf8_decode($model->excel);

            // var_dump($excel);
            // exit;
            
            try {
                $inputFileTipe = \PHPExcel_IOFactory::identify($excel);
                $objReader = \PHPExcel_IOFactory::createReader($inputFileTipe);
                $objPhPExcel = $objReader->load($excel);
            } catch (Exception $e) {
                die('error');
            }

            $sheet = $objPhPExcel->getSheet(0);
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();

            $arrayData = [];
            
            for ($row=2; $row <= $highestRow ; $row++){ 
                $rowData = $sheet->rangeToArray('a'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

                $arrayData[] = $rowData[0];

            }



            $alumnosPorNiveles = ArrayHelper::index($arrayData,null, 4);




            // $model = new Curso();
            // /* toma el id del usuario que está logeado*/
            // $model->creado_por = Yii::$app->user->identity->id;
            // $model->colegio_id = Yii::$app->user->identity->colegio_predeterminada;
            // $model->anio_id = Yii::$app->user->identity->anio_predeterminado;
            // $model->cupo = 0;
            // $model->fecha_creacion = date("Y-m-d H:i:s");
            // $model->activo = 1;



            foreach ($alumnosPorNiveles as $key => $alumnosPorNivel) {






                $AlumnosPorLetas = ArrayHelper::index($alumnosPorNivel,null, 5);

                





                foreach ($AlumnosPorLetas as $key => $AlumnosPorLeta) {



                    // foreach ($AlumnosPorLeta as $key => $AlumnosPorLeta) {

                    //     var_dump($AlumnosPorLeta);
                    //     echo "<br><br><br>";
    
                    // }
                    


                    // primero busco el nivel al que corresponde
    

    
                    $Nivel = Nivel::getBuscarNivel($AlumnosPorLeta[0][4]);
    


                    if(!$Nivel){
    
                        $Nivel = new Nivel();
                        /* toma el id del usuario que está logeado*/
                        $Nivel->creado_por = Yii::$app->user->identity->id;
                        $Nivel->fecha_creacion = date("Y-m-d H:i:s");
                        $Nivel->activo = 1;
                        $Nivel->nombre = $AlumnosPorLeta[0][4];
    
    
                        $pos = strpos($AlumnosPorLeta[0][4], 'básico');
    
                        if ($pos === true) {
                            $Nivel->ciclo = 1;
                        }
    
                        $pos = strpos($AlumnosPorLeta[0][4], 'medio');
    
                        
    
                        if ($pos === true) {
                            $Nivel->ciclo = 2;
                        }
    
                        $Nivel->save();
    
                    }
    
    
    
                    // Despues Busco el id de la letra
    
                    $letra_excel = strtoupper($AlumnosPorLeta[0][5]);

                    $Letra = Letra::getBuscarLetra($letra_excel);
    


                    if(!$Letra){
    
                        $Letra = new Letra();
                        /* toma el id del usuario que está logeado*/
                        $Letra->creado_por = Yii::$app->user->identity->id;
                        $Letra->fecha_creacion = date("Y-m-d H:i:s");
                        $Letra->activo = 1;
                        $Letra->nombre = $letra_excel;
    
                        $Letra->save();
    
                    }
    
                    // Busco si existe el curso
    
                    $Curso = Curso::getBuscarCurso($Letra->id,$Nivel->id,$AlumnosPorLeta[0][4],Yii::$app->user->identity->colegio_predeterminada,Yii::$app->user->identity->anio_predeterminado);
    


                    if(!$Curso){
    
                        $Curso = new Curso();
                        /* toma el id del usuario que está logeado*/
                        $Curso->creado_por = Yii::$app->user->identity->id;
                        $Curso->colegio_id = Yii::$app->user->identity->colegio_predeterminada;
                        $Curso->anio_id = Yii::$app->user->identity->anio_predeterminado;
                        $Curso->cupo = 0;
                        $Curso->fecha_creacion = date("Y-m-d H:i:s");
                        $Curso->activo = 1;
                        $Curso->nivel_id = $Nivel->id;
                        $Curso->letra_id = $Letra->id;
                        $Curso->capacidad = count($AlumnosPorLeta);
                        $Curso->nombre = $AlumnosPorLeta[0][4] . " " . $Letra->nombre;
                        $Curso->descripcion = $AlumnosPorLeta[0][4] . " " . $Letra->nombre;
                        $Curso->codigo = $AlumnosPorLeta[0][4] . " " . $Letra->nombre;
    
                        $Curso->save();
    
                        // var_dump($Curso->getErrors());
                        // echo "<br><br>";
    
                    }
    

                    // var_dump($Curso);
                    // echo "<br>";

                    // var_dump(count($value));
                    // echo "<br><br>";
                    // var_dump($Curso->id);
                    // echo "<br><br>";
                    var_dump($Curso->nombre);
                    echo "<br><br>";
                    var_dump(count($AlumnosPorLeta));
                    echo "<br><br>";

                    // var_dump($AlumnosPorLeta);
                    // echo "<br><br>";
                    // exit;
                    // $i = 0;
                    foreach ($AlumnosPorLeta as $key => $alumno) {
    

                        // var_dump($i);
                        // echo "<br>";


                        
    
                        $rut_alumno = str_replace('.', '', $alumno[6]);
                        if($rut_alumno == ""){
                            continue;
                        }else{
                           $rut_alumno = str_replace('.', '', $alumno[6]);
                        }  
    
                        $rut_alumno .= "-" . $alumno[7];


    
                        $Alumno = Alumno::findOne(['rut'=>$rut_alumno]);                
                        $telefono2="";
                        if ($alumno[16] <> ""){
                            $telefono2=trim($alumno[16]);
        
                        }
    
                        // var_dump($rut_alumno);
                        // echo "<br>";

                        if($Alumno){
                            $email="";
                            if($Alumno->email == ""){
                                 $email = trim($alumno[15]);
                                 $Alumno->email=$email;
        
                            }
                            $Alumno->anio_predeterminado = Yii::$app->user->identity->anio_predeterminado;
        
                            if(!$Alumno->activo){
                                $Alumno->activo = true;
                            }
                            $Alumno->empresa_id = Yii::$app->user->identity->colegio_predeterminada;

                            $Alumno->colegio_predeterminada = Yii::$app->user->identity->colegio_predeterminada;

                            
        
                            //$CampaniaSede=CampaniaSede::findOne(['sede_id'=>$UsuarioCampana->sede_campania_id,'campania_id'=>$campana,'activo'=>true]);
                            //$CampaniaSede=CampaniaSede::findOne(['sede_id'=>Yii::$app->user->identity->sede_predeterminada,'campania_id'=>$campana,'activo'=>true]);
                            
                            if (!$Alumno->telefono2) {
                                $Alumno->telefono2=$telefono2;
                            }
                            
                            if ($Alumno->save()){

                                Empresa::AssignUsuarioEmpresa(Yii::$app->user->identity->colegio_predeterminada,$Alumno->id);
    
                                if (! Rol::getConfirnarAsignados ( $Alumno->id, 'alumno' )) {
                                                
                                    Rol::asignarRolUsuario( $Alumno->id, 'alumno' );
                
                                }
    
                                AlumnoCurso::matricularCursos($Alumno->id,$Curso->id);
    
    
    
                            }else{
                                $datos = ['rut'=>$rut_alumno,'nombre'=>strip_tags(html_entity_decode($Alumno->nombre.' '.$Alumno->apellido_paterno.' '.$Alumno->apellido_materno,ENT_COMPAT,'UTF-8')),
                                'apellido_paterno'=>$Alumno->apellido_paterno,'email'=>$Alumno->email,'tipo_error'=>'Usuario',
                                'errores'=>$Alumno->getErrors()];
                                //array_push($datos_usuarios_erroneos,$datos);
                            }
    
    
    
        
                        }else{
                            
        
                                //si el usuario no existe en la base de datos
                                $Alumno = new Alumno();
                                
                                $clave_parcial = explode( "-", $rut_alumno);
                                $clave = $clave_parcial[0];
                                $clave = substr ($clave, 0, 4);
                                $email="";
                                $email = trim($alumno[15]);
        
    
    
                                $Alumno->rut = $rut_alumno;
                                $Alumno->apellido_paterno = $alumno[10];
                                $Alumno->apellido_materno = $alumno[11];
                                $Alumno->nombre = $alumno[9];
                                $Alumno->username = $rut_alumno;
                                $Alumno->email = $email;//$alumno[5];
                                //se asigna la direccion del colegio
                                $Alumno->telefono2 = $telefono2;
                                $Alumno->setPassword($clave);
                                $Alumno->generateAuthKey();
                                $Alumno->anio_predeterminado = Yii::$app->user->identity->anio_predeterminado;
                                $Alumno->colegio_predeterminada = Yii::$app->user->identity->colegio_predeterminada;
                                $Alumno->empresa_id = Yii::$app->user->identity->colegio_predeterminada;
                                $Alumno->activo = true;
                                $Alumno->creado_por = Yii::$app->user->identity->id;
    
    
    
                                //sino hay error se crea el usuario         
                                if ($Alumno->save()) {

                                    Empresa::AssignUsuarioEmpresa(Yii::$app->user->identity->colegio_predeterminada,$Alumno->id);
                                        
                                    if (! Rol::getConfirnarAsignados ( $Alumno->id, 'alumno' )) {
                                                
                                        Rol::asignarRolUsuario( $Alumno->id, 'alumno' );
                    
                                    }
    
                                    AlumnoCurso::matricularCursos($Alumno->id,$Curso->id);
                                       
                                }else{
    
    
                                    
                                    //si hay error se guarda registro del error    
                                    $datos = ['rut'=>$rut_alumno,'nombre'=>strip_tags(html_entity_decode($Alumno->nombre.' '.$Alumno->apellido_paterno.' '.$Alumno->apellido_materno,ENT_COMPAT,'UTF-8')),
                                            'apellido_paterno'=>$Alumno->apellido_paterno,'email'=>$Alumno->email,'curso'=>$curso_id,'tipo_error'=>'Usuario',
                                            'errores'=>$Alumno->getErrors()];
                                    //array_push($datos_usuarios_erroneos,$datos);
                                    // var_dump('expression3:');
                                    // var_dump($datos_usuarios_erroneos);
                                }
                                //}
                        }    
    
                        
    
    
    
    
                    }

                    
    

                }

                



                
            }

            //exit;


            return $this->goHome();

        } else {

            return $this->render('@common/views/empresa/cargar_subir_form', [
                'model' => $model,
                'id' => Yii::$app->user->identity->colegio_predeterminada,
            ]);
        }

    }

}
