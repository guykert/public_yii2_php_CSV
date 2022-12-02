<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Empresa;
use common\models\search\Empresa as EmpresaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\PruebaCategoria;
use common\models\PruebaCategoriaHijo;
use common\models\Ramo;
use common\models\SubRamo;
use common\models\AlumnoMultiple;
use common\models\Nivel;
use common\models\Letra;
use common\models\Curso;
use common\models\Alumno;
use common\models\Rol;
use common\models\AlumnoCurso;
use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * EmpresaController Implementa las acciones del CRUD para el modeloEmpresa .
 * */ 
class EmpresaController extends Controller
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
                        'actions' => ['index','create','update','delete','view','assign','assign-categoria','assign-ramo','assign-sub-ramo','carga-excel-colegio'],
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
                        'actions' => ['index','create','update','delete','view','assign','assign-categoria','assign-ramo','assign-sub-ramo','carga-excel-colegio'],
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

    public function actionIndex()
    {
        /**
        * Lista todo el modelo Empresa. 
        * no hay variable de retorno
        */
        $searchModel = new EmpresaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/empresa/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCargaExcelColegio($id)
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


            return $this->redirect(['index']);

        } else {

            return $this->render('@common/views/empresa/cargar_subir_form', [
                'model' => $model,
                'id' => $id,
            ]);
        }

    }

    public function actionAssign($padreid,$padrename,$hijoid,$hijoname)
    {

        if(Empresa::getConfirnarCargados($padreid,$hijoid)){
            // Si ya está asignado se reboca la asignación
            Empresa::eliminarHijo($padreid,$hijoid);

        }else{
            // en caos de no estar asignado se asigna
            Empresa::asignarHijo($hijoid,$hijoname,$padreid,$padrename);

        }
         
        Yii::$app->end();

    }

    public function actionAssignCategoria($Categoriaid,$userid)
    {

        $PruebaCategoriaHijo = PruebaCategoriaHijo::find()
        ->where(['empresa_id' => $userid,'categoria_id' => $Categoriaid,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();

        if(!$PruebaCategoriaHijo){

            $PruebaCategoriaHijo = new PruebaCategoriaHijo();
            $PruebaCategoriaHijo->categoria_id = $Categoriaid;
            $PruebaCategoriaHijo->empresa_id = $userid;
            $PruebaCategoriaHijo->creado_por = Yii::$app->user->identity->id;
            $PruebaCategoriaHijo->fecha_creacion = date("Y-m-d H:i:s");
            $PruebaCategoriaHijo->activo = 1;

            $PruebaCategoriaHijo->save();

        }else{

            $PruebaCategoriaHijo->activo = 0;

            $PruebaCategoriaHijo->save();

        }

        Yii::$app->end();

    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Empresa. 
        * @param integer $id
        * no tiene variable de retorno
        */

        $Corporaciones = Empresa::getCorporaciones($id);

        $Colegios = Empresa::getColegios($id);

        $PruebaCategoria = PruebaCategoria::getCategoriaObj($id);

        $Ramos = Ramo::getRamosObj();

        $SubRamos = SubRamo::getSubRamosObj($Ramos);

        

        return $this->render('@common/views/empresa/view', [
            'model' => $this->findModel($id),
            'Corporaciones' => $Corporaciones,
            'Colegios' => $Colegios,
            'PruebaCategoria' => $PruebaCategoria,
            'Ramos' => $Ramos,
            'SubRamos' => $SubRamos,
            
        ]);
    }

    public function actionCreate()
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




            } 


            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/empresa/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Empresa.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;   
        $model->fecha_modificacion = date("Y-m-d H:i:s");  



        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            if (!$model->errors) {

                Yii::$app->params['uploadPath'] = Yii::getAlias('@common') . '/uploads/';
                Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/uploads/';

                $image = $model->uploadImage();

                // upload only if valid uploaded file instance found
                if ($image !== false) {

                    $path = $model->getImageFile();




                    $model->imagen = "/uploads/empresa/" .$model->id."/" . $image->name;



                    $directorios = $model->creoDirectorios("/empresa/" .$model->id."/");

                    



                    $image->saveAs($path);



                    
                }



                $model->save();




            } 


            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/empresa/update', [
                'model' => $model,
            ]);
        }
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
        * Busca el modelo Empresa en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Empresa el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Empresa::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionAssignRamo($Ramoid,$Ramoname,$empresaid,$empresaname)
    {



        if(Ramo::getConfirnarCargados($Ramoid,$empresaid)){
            // Si ya está asignado se reboca la asignación
            Ramo::eliminarHijo($Ramoid,$empresaid);

        }else{
            // en caos de no estar asignado se asigna
            Ramo::asignarHijo($empresaid,$empresaname,$Ramoid,$Ramoname);

        }
         
        Yii::$app->end();

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

}
