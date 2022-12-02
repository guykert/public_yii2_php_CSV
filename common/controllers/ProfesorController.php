<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Profesor;
use common\models\search\Profesor as ProfesorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Rol;
use common\models\UsuarioEmpresaHijo;
use common\models\Curso;
use common\models\UsuarioCurso;
use common\models\ProfesorMultiple;
use common\components\select\CursosComponent;
use common\components\select\AsignaturaComponent;
use yii\web\UploadedFile;
use common\models\CursoAsignatura;
use common\models\Template;
use common\models\TemplateHijo;
use common\models\Empresa;
use common\models\MallaHorariaProfesor;
use common\models\Dia;



/**
 * ProfesorController Implementa las acciones del CRUD para el modeloProfesor .
 * */ 
class ProfesorController extends Controller
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
                        'actions' => ['index','create','update','delete','view','cursos','assign-curso','assign-template','assign-empresa','horario-profesor','asignar-asignatura-curso','asignatura','update-horario-profesor','delete-horario-profesor'],
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
                        'actions' => ['index','create','update','delete','view','cursos','assign-curso','assign-template','assign-empresa','horario-profesor','asignar-asignatura-curso','asignatura','update-horario-profesor','delete-horario-profesor'],
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

    public function actionAsignarAsignaturaCurso($id)
    {

        // $model = new MallaHorariaCurso();


        // return $this->renderAjax('@common/views/curso/crear_horario_curso', [
        //     'model_horario_curso' => $this->findModel($id),
        //     'model' => $model,
        // ]);



        $model = new MallaHorariaProfesor();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        //if ($model->load(Yii::$app->request->post()) && $model->save()) {
        if ($model->load(Yii::$app->request->post())) {


            $model->profesor_id = Yii::$app->request->post()["profesor_id"];

            $model->save();


            return $this->redirect(['horario-profesor','id'=>$model->profesor_id]);

 

        } else {

            return $this->render('@common/views/profesor/asignar_asignatura', [
                'model' => $model,
                'profesor' => $this->findModel($id),
            ]);
        }


    }

    public function actionUpdateHorarioProfesor($id_horario)
    {

        /**
        * Actualiza un modelo existente Curso.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        $model = $this->findModelMayaHorariaProfesor($id_horario);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['horario-profesor','id'=>$model->profesor_id]);
        } else {
            return $this->render('@common/views/profesor/update_asignar_asignatura', [
                'model' => $model,
                'profesor' => $this->findModel($model->profesor_id),
            ]);
        }

    }

    public function actionHorarioProfesor($id)
    {

        /**
        * Actualiza un modelo existente Curso.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        // busco los horarios creados apra este curso

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_profesor.profesor_id','malla_horaria_curso.id','malla_horaria_profesor.id as id_maya_horaria','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo', 'curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.activo'=>true,'malla_horaria_profesor.profesor_id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->all();


        $dias = Dia::getDiasActivos();

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");

        return $this->render('@common/views/profesor/horario_profesor', [
            'model' => $model,
            'MallaHoraria' => $MallaHorariaProfesor,
            'dias' => $dias,
        ]);


    }

    public function actionAssignTemplate($Templateid,$userid)
    {

        $TemplateHijo = TemplateHijo::find()
        ->where(['usuario_id' => $userid,'template_id' => $Templateid,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();

        if(!$TemplateHijo){

            $TemplateHijo = new TemplateHijo();
            $TemplateHijo->template_id = $Templateid;
            $TemplateHijo->usuario_id = $userid;
            $TemplateHijo->creado_por = Yii::$app->user->identity->id;
            $TemplateHijo->fecha_creacion = date("Y-m-d H:i:s");
            $TemplateHijo->activo = 1;

            $TemplateHijo->save();

        }else{

            $TemplateHijo->activo = 0;

            $TemplateHijo->save();

        }

        Yii::$app->end();

    }

    public function actionCursos()
    {

        $Cursos = new CursosComponent();

        echo $Cursos->RecibirInformacion();

    }

    public function actionAsignatura()
    {

        $Data = new AsignaturaComponent();

        echo $Data->AsignaturasPorCurso();

    }

    public function matricularCursos($id_usuario,$curso_id)
    {




        // primero busco las asignaturas_curso qeu tiene este curso para asignarcelas al Profesor

        $CursoAsignatura = CursoAsignatura::find()
        ->where(['curso_id' => $curso_id,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->all();



        foreach ($CursoAsignatura as $key => $CursoAsignat) {

            // pregunto si el Profesor ya tiene asignado el curso.

            $UsuarioCurso = UsuarioCurso::find()
            ->where(['usuario_id' => $id_usuario,'curso_id'=>$CursoAsignat->id,'activo' => 1]) 
            // ->orWhere(['email2' => $model->email]) 
            ->one();

            // var_dump($CursoAsignat->curso_id);
            // echo "<br>";
            // var_dump($id_usuario);

            // echo "<br><br>";

            if(!$UsuarioCurso){
                $UsuarioCurso = new UsuarioCurso();
                $UsuarioCurso->creado_por = Yii::$app->user->identity->id;
                $UsuarioCurso->fecha_creacion = date("Y-m-d H:i:s");
                $UsuarioCurso->usuario_id = $id_usuario;
                $UsuarioCurso->curso_id = $CursoAsignat->id;
                $UsuarioCurso->activo = 1;
                $UsuarioCurso->save();

            }

        }


        // exit;


    }

    public function actionCargarForm()
    {
       
        /**
        * Crea un nuevo modelo Profesor.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new ProfesorMultiple(['scenario' => 'segundo_paso']);

        if ($model->load(Yii::$app->request->post())) {


            if($model->validate()){

                return $this->redirect(['carga-subir-excel', 'colegio_id' => $model->colegio_id, 'curso_id' => $model->curso_id]);

            }else{
                return $this->render('@common/views/Profesor/cargar_form', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('@common/views/Profesor/cargar_form', [
                'model' => $model,
            ]);
        }




    }

    public function actionAssignCurso($Cursoid,$userid)
    {


        $UsuarioCurso = UsuarioCurso::find()
        ->where(['usuario_id' => $userid,'curso_id' => $Cursoid,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();

        if(!$UsuarioCurso){

            $UsuarioCurso = new UsuarioCurso();
            $UsuarioCurso->curso_id = $Cursoid;
            $UsuarioCurso->usuario_id = $userid;
            $UsuarioCurso->creado_por = Yii::$app->user->identity->id;
            $UsuarioCurso->fecha_creacion = date("Y-m-d H:i:s");
            $UsuarioCurso->activo = 1;

            $UsuarioCurso->save();

        }else{

            $UsuarioCurso->activo = 0;

            $UsuarioCurso->save();

        }

        Yii::$app->end();

    }

    public function actionIndex()
    {
        /**
        * Lista todo el modelo Profesor. 
        * no hay variable de retorno
        */


        $searchModel = new ProfesorSearch();



        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/profesor/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Profesor. 
        * @param integer $id
        * no tiene variable de retorno
        */

        // Primero busco el id del colegio del Profesor

        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        ->join('INNER JOIN', 'empresa','empresa.id =usuario_empresa_hijo.empresa_id') 
        ->join('INNER JOIN', 'curso','curso.colegio_id =empresa.id')
        ->where(['usuario_empresa_hijo.usuario_id' => $id,'usuario_empresa_hijo.activo' => 1,'curso.anio_id' => Yii::$app->user->identity->anio_predeterminado]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();

        $Cursos = [];

        if($UsuarioEmpresaHijo){
            $Cursos = Curso::getCursosColegio($UsuarioEmpresaHijo->empresa_id);
        }

        $subRoles = Rol::getSubroles();

        $Roles = Rol::getRoles();

        $Templates = Template::getTemplatesAsignables();

        $Empresas = Empresa::getEmpresasExterno();

        $Corporaciones = Empresa::getCorporacionesExterno();

        $Colegios = Empresa::getColegiosExterno();


        return $this->render('@common/views/profesor/view', [
            'model' => $this->findModel($id),
            'Cursos' => $Cursos,
            'subRoles'=> $subRoles,
            'Roles'=> $Roles,
            'Templates'=> $Templates,
            'Empresas'=> $Empresas,
            'Corporaciones'=> $Corporaciones,
            'Colegios'=> $Colegios,

        ]);
    }

    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo Profesor.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Profesor();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->rut = Yii::$app->request->post()['Profesor']['rut'];
            $model->username = Yii::$app->request->post()['Profesor']['rut'];
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();




            $confirmar_email = Usuario::findOne ( [ 
                'email' => trim ( $model->email ) 
            ] );
            
            //if (count ( $confirmar_email ) > 0) {
            if ( ! empty( $confirmar_email ) ){
                $model->email = "";
                $model->addError('email', 'El email ya se encuentra asignado a otro usuario');
            } else {
                $model->email = trim ( $model->email );
            }

            // genero la clave para el Profesor
            
            // separo el guion del rut
            $clave_parcial = explode ( "-", $model->rut );
            // asigno el rut sin el guion
            $clave = $clave_parcial [0];
            
            // invierto el rut
            $clave = strrev ( $clave );
            
            // tomo los 4 primeros numeros
            $clave = substr ( $clave, 0, 4 );
            // invierto nuevamente la clave
            $clave = strrev ( $clave );
            
            $model->setPassword ( $clave );
            $model->generateAuthKey ();


            if($model->save()){

                if (! Rol::getConfirnarAsignados ( $model->id, 'Profesor' )) {
											
                    Rol::asignarRolUsuario( $model->id, 'Profesor' );

                }
                



                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('@common/views/profesor/create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('@common/views/profesor/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {

        /**
        * Actualiza un modelo existente Usuario.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param string $id
        *  no tiene variable de retorno
        */
        $model = new Profesor(['scenario' => 'validacionParcial']);
        $model = $this->findModel($id);

          /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id;
        $clave_vieja = '';

        $clave_vieja = $model->password_hash;
        $model->password_hash = $clave_vieja ;
        if ($model->load(Yii::$app->request->post())) {
            $model->rut = Yii::$app->request->post()['Profesor']['rut'];
            $model->username = Yii::$app->request->post()['Profesor']['username'];
            // solo si se relizó cambio en la clave la actualiza
            // $model->password_hash es la clave que llega por post, se compara con la clave que tenía em modelo
            if($model->password_hash  !==  "")
            {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
            }else{
                $model->password_hash = $clave_vieja;
            }

            if($model->save()){
       
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->password_hash="";
                return $this->render('@common/views/usuario/update', [
                    'model' => $model,
                ]);
            }
        } else {

            $model->password_hash="";
            return $this->render('@common/views/usuario/update', [
                'model' => $model,
            ]);

        }

    }

    public function actionAssignEmpresa($empresaid,$usuarioid)
    {

        //los Profesors solo pueden tener un colegio por año por lo que busco todos los colegios del año actual para quitarcelos
        
        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        ->join('INNER JOIN', 'empresa','empresa.id =usuario_empresa_hijo.empresa_id') 
        ->where(['usuario_empresa_hijo.usuario_id' => $usuarioid,'usuario_empresa_hijo.activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->all();

        $existe = 0;
        
        foreach ($UsuarioEmpresaHijo as $key => $value) {

            if($empresaid == $value->empresa_id  ){

                $existe = 1;

            }else{
                $value->activo = 0;
                $value->save();
            }


        }



        if($existe == 0){
            $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
            ->where(['usuario_id' => $usuarioid,'empresa_id' => $empresaid,'activo' => 1]) 
            // ->orWhere(['email2' => $model->email]) 
            ->one();
    
            $UsuarioEmpresaHijo = new UsuarioEmpresaHijo();
            $UsuarioEmpresaHijo->empresa_id = $empresaid;
            $UsuarioEmpresaHijo->usuario_id = $usuarioid;
            $UsuarioEmpresaHijo->creado_por = Yii::$app->user->identity->id;
            $UsuarioEmpresaHijo->fecha_creacion = date("Y-m-d H:i:s");
            $UsuarioEmpresaHijo->activo = 1;
    
            $UsuarioEmpresaHijo->save();
        }




    }

    public function actionDeleteHorarioProfesor($id)
    {


        /**
        * Si el campo activo del registro está activo lo desactiva y viceversa
        * Si lo desactiva, el navegador será redirigido a la página "index" de lo contrario a "inactivo" 
        *.      * @param string $id
        * no tiene variable de retorno 
        */
        $model = $this->findModelMayaHorariaProfesor($id);
        if($model->activo == true )
        {


            $model->activo = false ;
            $model->save();


            return $this->redirect(['horario-profesor','id'=>$model->profesor_id]);     
        }else{
            $model->activo = true ;
            $model->save();
            return $this->redirect(['horario-profesor','id'=>$model->profesor_id]);
        }


    }

    public function actionDelete($id)
    {


        if ( Rol::getConfirnarAsignados ( $id, 'profesor' )) {
											
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

                $model->rut = $model->rut. "E";
                $model->username = $model->username. "E";

                $model->setScenario('validacioneliminarRegistro');
                $model->save();



                return $this->redirect(['index']);        
            }else{
                $model->activo = true ;
                $model->save();
                return $this->redirect(['inactivo']);  
            }

        }else{
            return $this->redirect(['index']);
        }


    }

    protected function findModel($id)
    {
        /**
        * Busca el modelo Profesor en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Profesor el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Profesor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelMayaHorariaProfesor($id)
    {
        /**
        * Busca el modelo Profesor en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Profesor el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = MallaHorariaProfesor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    
}
