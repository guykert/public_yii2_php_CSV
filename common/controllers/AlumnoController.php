<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Alumno;
use common\models\search\Alumno as AlumnoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Rol;
use common\models\UsuarioEmpresaHijo;
use common\models\Curso;
use common\models\UsuarioCurso;
use common\models\AlumnoMultiple;
use common\components\select\CursosComponent;
use yii\web\UploadedFile;
use common\models\CursoAsignatura;

/**
 * AlumnoController Implementa las acciones del CRUD para el modeloAlumno .
 * */ 
class AlumnoController extends Controller
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
                        'actions' => ['index','create','update','delete','view','cursos','assign-curso','cargar-excel','descargar-excel','cargar-form','carga-subir-excel'],
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
                        'actions' => ['index','create','update','delete','view','cursos','assign-curso','cargar-excel','descargar-excel','cargar-form','carga-subir-excel'],
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

    public function actionCursos()
    {

        $Cursos = new CursosComponent();

        echo $Cursos->RecibirInformacion();

    }

    public function actionCargaSubirExcel($colegio_id,$curso_id)
    {
       
        /**
        * Crea un nuevo modelo Alumno.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new AlumnoMultiple(['scenario' => 'tercer_paso']);

        if ($model->load(Yii::$app->request->post())) {

                //excel          
                $archivo = UploadedFile::getInstance($model,'excel');
                if($archivo){
                    $nombre = rand(0,9999).'-'. $archivo->name  ;
                    $model->excel = $nombre;
                    $archivo->saveAs(Yii::getAlias('@backend').'/uploads/base_alumnos/'.utf8_decode($model->excel));
                }
                $excel = Yii::getAlias('@backend').'/uploads/base_alumnos/'.utf8_decode($model->excel);

            
                try {
                    $inputFileTipe = \PhpOffice\PhpSpreadsheet\IOFactory::identify($excel);
                    $objReader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileTipe);
                    $objPhPExcel = $objReader->load($excel);
                } catch (Exception $e) {
                    die('error');
                }

                $sheet = $objPhPExcel->getSheet(0);
                $highestRow = $sheet->getHighestRow();
                $highestColumn = $sheet->getHighestColumn();
               
                for ($row=0; $row <= $highestRow ; $row++){ 
                    $rowData = $sheet->rangeToArray('a'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);
                    if ($row == 1 || $row == 0 || $row == 2  ){
                        continue;
                    }else{
                        $rut_alumno = str_replace('.', '', $rowData[0][0]);
                        if($rut_alumno == ""){
                            continue;
                        }else{
                           $rut_alumno = str_replace('.', '', $rowData[0][0]);
                        }               
                    }
    
                    //$curso_id = $rowData[0][4];
                    //valido que el usuario exista
                    //$rut_alumno = str_replace('.', '', $rowData[0][0]);
                    
                    $Alumno = Alumno::findOne(['rut'=>$rut_alumno]);                
                    $telefono2="";
                    if ($rowData[0][6] <> ""){
                        $telefono2=trim($rowData[0][6]);
    
                    }


                    
                    if($Alumno){
                        $email="";
                        if($Alumno->email == ""){
                             $email = trim($rowData[0][5]);
                             $Alumno->email=$email;
    
                        }
                        $Alumno->anio_predeterminado = Yii::$app->user->identity->anio_predeterminado;
    
                        if(!$Alumno->activo){
                            $Alumno->activo = true;
                        }
                        $Alumno->empresa_id = $colegio_id;
    
                        //$CampaniaSede=CampaniaSede::findOne(['sede_id'=>$UsuarioCampana->sede_campania_id,'campania_id'=>$campana,'activo'=>true]);
                        //$CampaniaSede=CampaniaSede::findOne(['sede_id'=>Yii::$app->user->identity->sede_predeterminada,'campania_id'=>$campana,'activo'=>true]);
                        
                        if (!$Alumno->telefono2) {
                            $Alumno->telefono2=$telefono2;
                        }
                        
                        if ($Alumno->save()){

                            if (! Rol::getConfirnarAsignados ( $Alumno->id, 'alumno' )) {
											
                                Rol::asignarRolUsuario( $Alumno->id, 'alumno' );
            
                            }

                            $this->matricularCursos($Alumno->id,$curso_id);

                        }else{
                            $datos = ['rut'=>$rut_alumno,'nombre'=>strip_tags(html_entity_decode($rowData[0][1].' '.$rowData[0][2].' '.$rowData[0][3],ENT_COMPAT,'UTF-8')),
                            'apellido_paterno'=>$rowData[0][2],'email'=>$rowData[0][5],'tipo_error'=>'Usuario',
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
                            $email = trim($rowData[0][5]);
    
                            $Alumno->rut = $rut_alumno;
                            $Alumno->apellido_paterno = $rowData[0][1];
                            $Alumno->apellido_materno = $rowData[0][2];
                            $Alumno->nombre = $rowData[0][3];
                            $Alumno->username = $rut_alumno;
                            $Alumno->email = $email;//$rowData[0][5];
                            //se asigna la direccion del colegio
                            $Alumno->telefono2 = $telefono2;
                            $Alumno->setPassword($clave);
                            $Alumno->generateAuthKey();
                            $Alumno->anio_predeterminado = Yii::$app->user->identity->anio_predeterminado;
                            $Alumno->empresa_id = $colegio_id;
                            $Alumno->activo = true;
                            $Alumno->creado_por = Yii::$app->user->identity->id;
                            //sino hay error se crea el usuario    



                            if ($Alumno->save()) {
                                    
                                if (! Rol::getConfirnarAsignados ( $Alumno->id, 'alumno' )) {
											
                                    Rol::asignarRolUsuario( $Alumno->id, 'alumno' );
                
                                }

                                $this->matricularCursos($Alumno->id,$curso_id);
                                   
                            }else{


                                
                                //si hay error se guarda registro del error    
                                $datos = ['rut'=>$rut_alumno,'nombre'=>strip_tags(html_entity_decode($rowData[0][1].' '.$rowData[0][2].' '.$rowData[0][3],ENT_COMPAT,'UTF-8')),
                                        'apellido_paterno'=>$rowData[0][2],'email'=>$rowData[0][5],'curso'=>$curso_id,'tipo_error'=>'Usuario',
                                        'errores'=>$Alumno->getErrors()];

                                foreach ($Alumno->getErrors() as $key => $value) {

                                    $model->addError('excel', 'El campo ' . $key . ' tiene el siguiente problema : ' . $value[0]);

                                }

                                




                            }


                            if ( !empty( $model->getErrors() ) ){
                                return $this->render('@common/views/alumno/cargar_subir_form', [
                                    'model' => $model,
                                    'colegio_id' => $colegio_id,
                                    'curso_id' => $curso_id,
                                ]);
                            }



                    }    

                    

                        
                    //}
                }

                return $this->redirect(['index']);

        } else {
            return $this->render('@common/views/alumno/cargar_subir_form', [
                'model' => $model,
                'colegio_id' => $colegio_id,
                'curso_id' => $curso_id,
            ]);
        }



    }

    public function matricularCursos($id_usuario,$curso_id)
    {




        // primero busco las asignaturas_curso qeu tiene este curso para asignarcelas al alumno

        $CursoAsignatura = CursoAsignatura::find()
        ->where(['curso_id' => $curso_id,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->all();



        foreach ($CursoAsignatura as $key => $CursoAsignat) {

            // pregunto si el alumno ya tiene asignado el curso.

            $UsuarioCurso = UsuarioCurso::find()
            ->where(['usuario_id' => $id_usuario,'curso_id'=>$curso_id,'activo' => 1]) 
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
                $UsuarioCurso->curso_id = $curso_id;
                $UsuarioCurso->activo = 1;
                $UsuarioCurso->save();

            }

        }


        // exit;


    }


    public function actionCargarForm()
    {
       
        /**
        * Crea un nuevo modelo Alumno.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new AlumnoMultiple(['scenario' => 'segundo_paso']);

        if ($model->load(Yii::$app->request->post())) {


            if($model->validate()){

                return $this->redirect(['carga-subir-excel', 'colegio_id' => $model->colegio_id, 'curso_id' => $model->curso_id]);

            }else{
                return $this->render('@common/views/alumno/cargar_form', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('@common/views/alumno/cargar_form', [
                'model' => $model,
            ]);
        }




    }

    public function actionDescargarExcel()
    {
       
        return $this->render('@common/views/alumno/excel');

    }

    public function actionCargarExcel()
    {
       

        return $this->render('@common/views/alumno/cargar_excel');

    }

    public function actionAssignCurso($Cursoid,$userid)
    {

        // Confirmo si tiene cursos para ver si elimino o cargo

        $UsuarioCurso = UsuarioCurso::find()
        ->where(['curso_asignatura.curso_id' => $Cursoid,'usuario_curso.usuario_id' => $userid,'usuario_curso.activo' => 1])
        ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id =usuario_curso.curso_id and curso_asignatura.activo = 1')
        ->count();


        
        if($UsuarioCurso > 0){
            $UsuarioCurso = UsuarioCurso::find()
            ->where(['curso_asignatura.curso_id' => $Cursoid,'usuario_curso.usuario_id' => $userid,'usuario_curso.activo' => 1])
            ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id =usuario_curso.curso_id and curso_asignatura.activo = 1')
            ->all();

            foreach ($UsuarioCurso as $key => $UsuarioCur) {
                $UsuarioCur->activo = 0;
                $UsuarioCur->save();
            }
        }else{

            $UsuarioCurso = new UsuarioCurso();
            $UsuarioCurso->curso_id = $Cursoid;
            $UsuarioCurso->usuario_id = $userid;
            $UsuarioCurso->creado_por = Yii::$app->user->identity->id;
            $UsuarioCurso->fecha_creacion = date("Y-m-d H:i:s");
            $UsuarioCurso->activo = 1;

            $UsuarioCurso->save();

        }





        // $UsuarioCurso = UsuarioCurso::find()
        // ->where(['usuario_id' => $userid,'curso_id' => $Cursoid,'activo' => 1]) 
        // // ->orWhere(['email2' => $model->email]) 
        // ->one();

        // if(!$UsuarioCurso){

        //     $UsuarioCurso = new UsuarioCurso();
        //     $UsuarioCurso->curso_id = $Cursoid;
        //     $UsuarioCurso->usuario_id = $userid;
        //     $UsuarioCurso->creado_por = Yii::$app->user->identity->id;
        //     $UsuarioCurso->fecha_creacion = date("Y-m-d H:i:s");
        //     $UsuarioCurso->activo = 1;

        //     $UsuarioCurso->save();

        // }else{

        //     $UsuarioCurso->activo = 0;

        //     $UsuarioCurso->save();

        // }

        Yii::$app->end();

    }


    public function actionIndex()
    {
        /**
        * Lista todo el modelo Alumno. 
        * no hay variable de retorno
        */
        $searchModel = new AlumnoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/alumno/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Alumno. 
        * @param integer $id
        * no tiene variable de retorno
        */

        // Primero busco el id del colegio del alumno

        $Cursos = Curso::getCursosColegio(Yii::$app->user->identity->colegio_predeterminada);

        return $this->render('@common/views/alumno/view', [
            'model' => $this->findModel($id),
            'Cursos' => $Cursos,
        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo Alumno.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Alumno();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post())) {
            $model->rut = Yii::$app->request->post()['Alumno']['rut'];
            $model->username = Yii::$app->request->post()['Alumno']['rut'];
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();




            $confirmar_email = Usuario::findOne ( [ 
                'email' => trim ( $model->email ) 
            ] );

            if (empty( $confirmar_email )) {
                $model->email = "";
                $model->addError('email', 'El email ya se encuentra asignado a otro usuario');
            } else {
                $model->email = trim ( $model->email );
            }

            // genero la clave para el alumno
            
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

                if (! Rol::getConfirnarAsignados ( $model->id, 'alumno' )) {
											
                    Rol::asignarRolUsuario( $model->id, 'alumno' );

                }
                



                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('@common/views/alumno/create', [
                    'model' => $model,
                ]);
            }
        } else {
            return $this->render('@common/views/alumno/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Alumno.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        // Primero confirmo si el usuario tiene el perfil de usuario

        if (Rol::getConfirnarAsignados ( $id, 'alumno' )) {
											
            // Primero confirmo que el usuario tena solo el perfil de alumno
            


            $model = $this->findModel($id);
            /* toma el id del usuario que está logeado*/
            $model->modificado_por = Yii::$app->user->identity->id ;     
            $model->fecha_modificacion = date("Y-m-d H:i:s");
            if ($model->load(Yii::$app->request->post()) && $model->save()) {

                $this->actionAssignEmpresa(Yii::$app->request->post()['Alumno']['empresa_id'],$id);



                return $this->redirect(['index']);
            } else {

                $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
                ->join('INNER JOIN', 'empresa','empresa.id =usuario_empresa_hijo.empresa_id') 
                ->join('INNER JOIN', 'curso','curso.colegio_id =empresa.id')
                ->where(['usuario_empresa_hijo.usuario_id' => $id,'usuario_empresa_hijo.activo' => 1,'curso.anio_id' => Yii::$app->user->identity->anio_predeterminado]) 
                // ->orWhere(['email2' => $model->email]) 
                ->one();

                if($UsuarioEmpresaHijo){

                    

                }

                

                return $this->render('@common/views/alumno/update', [
                    'model' => $model,
                ]);
            }

        }else{
            return $this->redirect(['index']);
        }



    }


    public function actionAssignEmpresa($empresaid,$usuarioid)
    {

        //los alumnos solo pueden tener un colegio por año por lo que busco todos los colegios del año actual para quitarcelos
        
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

    public function actionDelete($id)
    {



        if ( Rol::getConfirnarAsignados ( $id, 'alumno' )) {
											
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

                $model->rut = $model->rut. "E" . rand(0,9999);
                $model->username = $model->username. "E" . rand(0,9999);

                $model->setScenario('validacioneliminarRegistro');
                $model->save();

                // var_dump($model->save());
                // var_dump($model->getErrors());
                // exit;

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
        * Busca el modelo Alumno en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Alumno el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Alumno::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
