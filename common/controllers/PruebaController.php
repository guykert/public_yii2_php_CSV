<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Prueba;
use common\models\search\Prueba as PruebaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use yii\base\Model;
use yii\helpers\Json;
use common\components\select\SubRamoComponent;
use common\components\select\PaginaAlumnoAreaComponent;
use common\models\PruebaPauta;
use common\models\PruebaEjeTematico;
use common\models\PruebaSubEjeTematico;
use common\models\PruebaHabilidad;
use common\models\PruebaAlumno;
use common\models\PruebaAlumnoRespuesta;
use common\models\PruebaFormulaNota;

use yii\web\UploadedFile;
use yii\helpers\ArrayHelper;

/**
 * PruebaController Implementa las acciones del CRUD para el modeloPrueba .
 * */ 
class PruebaController extends Controller
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
                        'actions' => ['index','create','update','delete','view','pauta','sub-ramo','eje-tematico','asignar-eliminar-ejes-tematicos','habilidades','asignar-eliminar-habilidad','cargar','descargar-excel','carga-subir-excel','sub-eje-tematico','sub-eje-tematico-preguntas','asignar-eliminar-sub-ejes-tematicos','ver-sub-eje-tematico','pagina-alumno-area','recalcular-puntajes'],
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
                        'actions' => ['index','create','update','delete','view','pauta','sub-ramo','eje-tematico','asignar-eliminar-ejes-tematicos','habilidades','asignar-eliminar-habilidad','cargar','descargar-excel','carga-subir-excel','sub-eje-tematico','sub-eje-tematico-preguntas','asignar-eliminar-sub-ejes-tematicos','ver-sub-eje-tematico','pagina-alumno-area','recalcular-puntajes'],
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

    public function actionRecalcularPuntajes($id)
    {

        $PruebaAlumnos = PruebaAlumno::find()->where(['prueba_id'=>$id,'activo'=>1])->All(); 

        // Busco la data de la pauta de la prueba

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$id,'activo'=>1])->asArray()->All(); 

        $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');

        $Prueba = Prueba::findOne($id);

        foreach ($PruebaAlumnos as $key => $PruebaAlumno) {
            // traigo la data de la prueba
            $PruebaAlumno->detalle_malas = "";

            $PruebaAlumno->buenas = 0;
            $PruebaAlumno->malas = 0;
            $PruebaAlumno->omitidas = 0;

            




            foreach ($PruebaPauta as $key => $Pauta) {



                $PruebaAlumnoRespuesta=PruebaAlumnoRespuesta::findOne(['prueba_alumno_id'=>$PruebaAlumno->id,'activo'=>1,'numero_pregunta'=>$Pauta["numero_pregunta"]]);

                // var_dump($PruebaAlumnoRespuesta);
                // echo "<br><br>";

                if(!$PruebaAlumnoRespuesta){


                    $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta();
                    $PruebaAlumnoRespuesta->fecha_creacion = date("Y-m-d H:i:s");
                    $PruebaAlumnoRespuesta->creado_por = 1;
                    $PruebaAlumnoRespuesta->numero_pregunta = $Pauta["numero_pregunta"];
                    $PruebaAlumnoRespuesta->respuesta = "-";
                    $PruebaAlumnoRespuesta->prueba_alumno_id = $PruebaAlumno->id;
                    $PruebaAlumnoRespuesta->save();



                }



            }  


            // En caso de que la data no venga por post se tomará la información que este cargada en la base de datos 

            $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'activo'=>1])->All();

            foreach ($PruebaAlumnoRespuestaGuardado as $AlumnoRespuesta) {
                if ($AlumnoRespuesta->respuesta == "" || $AlumnoRespuesta->respuesta == "-") {
                    $PruebaAlumno->omitidas++;
                    if($PruebaAlumno->detalle_malas == ""){
                        $PruebaAlumno->detalle_malas .= $AlumnoRespuesta->numero_pregunta;
                    }else{
                        $PruebaAlumno->detalle_malas .= ",".$AlumnoRespuesta->numero_pregunta;
                    }
                }else{
                    if ($PruebaPauta[$AlumnoRespuesta->numero_pregunta]["correcta"] == $AlumnoRespuesta->respuesta) {
                        $PruebaAlumno->buenas++;
                    }else{
                        $PruebaAlumno->malas++;
                        if($PruebaAlumno->detalle_malas == ""){
                            $PruebaAlumno->detalle_malas .= $AlumnoRespuesta->numero_pregunta;
                        }else{
                            $PruebaAlumno->detalle_malas .= ",".$AlumnoRespuesta->numero_pregunta;
                        }
                    }
                }
            } 



            // al tener las buenas hay que ver is la prueba trabaja con formula lineal o con tabla de conversión

            if ($Prueba->formula_id > 0) {
                $PruebaFormulaNota = PruebaFormulaNota::findOne(['id' => $Prueba->formula_id,'activo'=>1]);

                if($PruebaFormulaNota){
                    $PruebaAlumno->nota = (int)($PruebaAlumno->buenas * $PruebaFormulaNota->multiplicados) + $PruebaFormulaNota->sumar;
                }else{
                    $PruebaAlumno->nota = $PruebaAlumno->buenas;
                }
            }else{

                // $PruebaConversionDetalle = PruebaConversionDetalle::findOne(['tabla_conversion_id'=>$Prueba->tabla_conversion_id,'preguntas_correctas'=>$PruebaAlumno->buenas,'activo'=>true]);


                // if($PruebaConversionDetalle){
                //     $PruebaAlumno->nota = $PruebaConversionDetalle->puntaje;
                // }else{
                //     $PruebaAlumno->nota = $PruebaAlumno->buenas;
                // }

            }



            $PruebaAlumno->save();
        }


        return $this->redirect(['index']);

    }

    public function actionCargaSubirExcel($prueba_id)
    {
       
        /**
        * Crea un nuevo modelo Alumno.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new PruebaPauta(['scenario' => 'carga_excel']);

        $prueba=Prueba::findOne($prueba_id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->validate() || UploadedFile::getInstance($model,'excel')){
                //excel          
                $archivo = UploadedFile::getInstance($model,'excel');

                Yii::$app->params['uploadPath'] = Yii::getAlias('@backend') . '/uploads/pautas_prueba/' . $prueba_id . '/';


                $directorios = $model->creoDirectorios($prueba_id);


                if($archivo){
                    $nombre = rand(0,9999).'-'. $archivo->name  ;
                    $model->excel = $nombre;
                    $archivo->saveAs(Yii::getAlias('@backend').'/uploads/pautas_prueba/' . $prueba_id . "/" .utf8_decode($model->excel));
                }
                $excel = Yii::getAlias('@backend').'/uploads/pautas_prueba/' . $prueba_id . "/" .utf8_decode($model->excel);

            
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
               
                for ($row=3; $row <= $prueba->numero_preguntas ; $row++){ 
                    $rowData = $sheet->rangeToArray('a'.$row.':'.$highestColumn.$row,NULL,TRUE,FALSE);

                    $rowData = $rowData[0];


                    if (!($rowData[1] == NULL)) {



                        $PruebaPaut = PruebaPauta::find()->where(['prueba_id'=>$prueba_id,'numero_pregunta'=>(int)$rowData[0]])->one();
                        



                        if(!$PruebaPaut){
        
                            $PruebaPaut = new PruebaPauta();
                            $PruebaPaut->creado_por = Yii::$app->user->identity->id;
                            $PruebaPaut->correcta = strtoupper($rowData[1]);
                            $PruebaPaut->prueba_id = $prueba_id;
                            $PruebaPaut->numero_pregunta = (int)$rowData[0];
                            $PruebaPaut->activo = 1;

                        }else{

                            $PruebaPaut->correcta = strtoupper($rowData[1]);
                            $PruebaPaut->modificado_por = Yii::$app->user->identity->id;
                            $PruebaPaut->modificado_por = Yii::$app->user->identity->id;

                        }
        
                        $PruebaPaut->save();



                    }

                }




                return $this->redirect(['view','id'=>$prueba_id]);
            }else{

                return $this->render('@common/views/prueba/cargar_subir_form', [
                    'model' => $model,
                    'prueba_id' => $prueba_id
                ]);

            }



        } else {
            return $this->render('@common/views/prueba/cargar_subir_form', [
                'model' => $model,
                'prueba_id' => $prueba_id
            ]);
        }



    }


    public function actionDescargarExcel($prueba_id)
    {
       
        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$prueba_id])->all();

        return $this->render('@common/views/prueba/excel', [
            'PruebaPauta' => $PruebaPauta,
        ]);

    }

    public function actionCargar($prueba_id){
        //$prueba=Prueba::find()->where(['id'=>$prueba_id,'activo'=>true])->all();
       $prueba=Prueba::findOne($prueba_id);
       //jornada presencial y control
       return $this->render('@common/views/prueba/cargar', [
        'prueba_id' => $prueba_id,
        ]); 

       
    }

    public function actionEjeTematico($id)
    {

        $Prueba = $this->findModel($id);

        //busco los ejes tematicos para asignarlos

        $PruebaEjeTematico = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>$Prueba->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$Prueba->id])->orderBy('numero_pregunta')->all();


        return $this->renderAjax('@common/views/prueba/_eje_tematico', [
            'model' => $Prueba,
            'PruebaEjeTematico' => $PruebaEjeTematico,
            'PruebaPauta' => $PruebaPauta,
        ]);

    }
    
    public function actionSubEjeTematico($id)
    {

        $Prueba = $this->findModel($id);

        //busco los ejes tematicos para asignarlos

        $PruebaEjeTematico = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>$Prueba->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$Prueba->id])->orderBy('numero_pregunta')->all();


        return $this->renderAjax('@common/views/prueba/_sub_eje_tematico', [
            'model' => $Prueba,
            'PruebaEjeTematico' => $PruebaEjeTematico,
            'PruebaPauta' => $PruebaPauta,
        ]);

    }

    public function actionVerSubEjeTematico($id)
    {

        $Prueba = $this->findModel($id);

        //busco los ejes tematicos para asignarlos

        $PruebaSubEjeTematico = PruebaSubEjeTematico::find()->where(['activo'=>true,'ramo_id'=>$Prueba->ramo_id])->orderBy('nombre')->all();


        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$Prueba->id])->orderBy('numero_pregunta')->all();



        return $this->renderAjax('@common/views/prueba/_sub_eje_tematico_ver', [
            'model' => $Prueba,
            'PruebaSubEjeTematico' => $PruebaSubEjeTematico,
            'PruebaPauta' => $PruebaPauta,
        ]);

    }

    public function actionSubEjeTematicoPreguntas($id,$id_eje)
    {


 
        $Prueba = $this->findModel($id);

        $PruebaEjeTematico = PruebaEjeTematico::findOne($id_eje);

        //busco los ejes tematicos para asignarlos

        $PruebaSubEjeTematico = PruebaSubEjeTematico::find()->where(['activo'=>true,'eje_tematico_id'=>$id_eje])->orderBy('nombre')->all();


        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$Prueba->id,'eje_tematico'=>$id_eje])->orderBy('numero_pregunta')->all();


        return $this->renderAjax('@common/views/prueba/_sub_eje_tematico_pregunta', [
            'model' => $Prueba,
            'PruebaSubEjeTematico' => $PruebaSubEjeTematico,
            'PruebaPauta' => $PruebaPauta,
            'PruebaEjeTematico' => $PruebaEjeTematico,
        ]);

    }

    public function actionHabilidades($id)
    {

        $Prueba = $this->findModel($id);

        //busco los ejes tematicos para asignarlos

        $PruebaHabilidades = PruebaHabilidad::find()->where(['activo'=>true,'ramo_id'=>$Prueba->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$Prueba->id])->orderBy('numero_pregunta')->all();


        return $this->renderAjax('@common/views/prueba/_habilidad', [
            'model' => $Prueba,
            'PruebaHabilidades' => $PruebaHabilidades,
            'PruebaPauta' => $PruebaPauta,
        ]);

    }

    public function actionIndex()
    {

        /**
        * Lista todo el modelo Prueba. 
        * no hay variable de retorno
        */
        $searchModel = new PruebaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/prueba/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionPauta($id)
    {
        /**
        * Muestra un modelo único Prueba. 
        * @param integer $id
        * no tiene variable de retorno
        */

        $Prueba = $this->findModel($id);

        for($i = 1; $i <= $Prueba->numero_preguntas; $i++) {

            $PruebaPauta_guardado = PruebaPauta::find()->where(['prueba_id'=>$id,'numero_pregunta'=>$i])->one();

            if(!($PruebaPauta_guardado)){
                $PruebaPauta[] = new PruebaPauta();
            }else{
                $PruebaPauta[] = $PruebaPauta_guardado;
            }

        }





        if (Model::loadMultiple($PruebaPauta, Yii::$app->request->post())) {



            $error = false;
            $cantidad_on = 0;
            foreach ($PruebaPauta as &$PruebaPaut) {
                $PruebaPaut->creado_por = Yii::$app->user->identity->id;

                $PruebaPauta_guardado = PruebaPauta::find()->where(['prueba_id'=>$PruebaPaut->prueba_id,'numero_pregunta'=>$PruebaPaut->numero_pregunta])->one();
                $PruebaPaut->correcta = strtoupper($PruebaPaut->correcta);
                if($PruebaPauta_guardado){

                    $PruebaPauta_guardado->correcta = strtoupper($PruebaPaut->correcta);
                    $PruebaPauta_guardado->modificado_por = Yii::$app->user->identity->id;
                    $PruebaPauta_guardado->numero_pregunta = (int)$PruebaPaut->numero_pregunta;
                    $PruebaPaut = $PruebaPauta_guardado;
                    $PruebaPaut->activo = 1;

                }

                $PruebaPaut->prueba_id = $id;
                $PruebaPaut->creado_por = Yii::$app->user->identity->id;

                // var_dump($PruebaPaut->save());
                // exit;

                if (!$PruebaPaut->save()) {
                    $error = true;
                    break;
                }

                $cantidad_on++;

            }

            return $this->renderPartial('@common/views/prueba/_pauta', [
                'model' => $Prueba,
                'PruebaPauta' => $PruebaPauta,
    
            ]);

        }else{

            if (Yii::$app->request->isAjax && Model::loadMultiple($PruebaPauta, Yii::$app->request->post())) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
        
            }else {
                return $this->renderAjax('@common/views/prueba/_pauta', [
                    'model' => $Prueba,
                    'PruebaPauta' => $PruebaPauta,
                ]);
            }



        }


        // if ($Prueba->load(Yii::$app->request->post())) {

        //     $Prueba->tabla_conversion_id = Yii::$app->request->post('Prueba')['tabla_conversion_id'];

        //     if($Prueba->tabla_conversion_id == "" || $Prueba->tabla_conversion_id == 0){

        //         $Prueba->addError('tabla_conversion_id', 'El campo Tabla Conversión es obligatorio.');

        //         $PruebaFormulaLineal = new PruebaFormulaLineal();

        //         // $PruebaPauta = new PruebaPauta();

        //         // $PruebaPauta->prueba_id = $id;

        //         $dataProvider = PruebaPauta::find()->where(['prueba_id'=>$id,'activo'=>1])->orderBy('numero_pregunta','desc')->all();

        //         return $this->render('@common/views/prueba/view', [
        //             'model' => $Prueba,
        //             'PruebaFormulaLineal' => $PruebaFormulaLineal,
        //             'dataProvider' => $dataProvider,
        //             'PruebaPauta' => $PruebaPauta,
        //             'Prueba_id' => $id,
        //             'PruebaPauta_Ejes' => $PruebaPauta_Ejes,
        //             'PruebaEjetematicoRamo' => $PruebaEjetematicoRamo,
        //             'PruebaHabilidades' => $PruebaHabilidades,
                    
        //         ]);

        //         exit;
        //     }else{

        //         if($Prueba->save()){

        //             $post = 1;

        //         }else{
        //             var_dump($Prueba);
        //         }

        //     }

        // }



        // return $this->renderPartial('@common/views/prueba/_pauta', [
        //     'model' => $Prueba,

        // ]);


    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Prueba. 
        * @param integer $id
        * no tiene variable de retorno
        */

        $Prueba = $this->findModel($id);



        return $this->render('@common/views/prueba/view', [
            'model' => $Prueba,

        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo Prueba.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Prueba();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->empresa_id = Yii::$app->user->identity->colegio_predeterminada;
        $model->anio_id = Yii::$app->user->identity->anio_predeterminado;
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/prueba/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Prueba.
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
            return $this->render('@common/views/prueba/update', [
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

        $model->setScenario('delete');

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
        * Busca el modelo Prueba en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Prueba el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Prueba::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionPaginaAlumnoArea()
    {

        $PaginaAlumnoArea = new PaginaAlumnoAreaComponent();

        echo $PaginaAlumnoArea->RecibirInformacion();

    }

    public function actionSubRamo()
    {

        $SubRamo = new SubRamoComponent();

        echo $SubRamo->RecibirInformacion();

    }

    public function actionAsignarEliminarEjesTematicos()
    {

        $pauta_id = Yii::$app->request->post('pauta_id', '');
        $id_eje = Yii::$app->request->post('id_eje', '');
        $numero_pregunta = Yii::$app->request->post('numero_pregunta', '');
        $estado = 0;
        $list=[];

        if($pauta_id > 0 && $id_eje > 0 && $numero_pregunta > 0)
        {

            $PruebaPauta = PruebaPauta::findOne($pauta_id);

            if($PruebaPauta){
                if($PruebaPauta->eje_tematico == $id_eje){
                    $PruebaPauta->eje_tematico = null;
                }else{
                    $PruebaPauta->eje_tematico = $id_eje;
                }
                if ($PruebaPauta->save()) {
                    $estado =1;
                }

            }else{
                $estado = 99;
            }
        }else{
            $estado = 98;
        }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionAsignarEliminarHabilidad()
    {

        $pauta_id = Yii::$app->request->post('pauta_id', '');
        $id_habilidad = Yii::$app->request->post('id_habilidad', '');
        $numero_pregunta = Yii::$app->request->post('numero_pregunta', '');
        $estado = 0;
        $list=[];

        if($pauta_id > 0 && $id_habilidad > 0 && $numero_pregunta > 0)
        {

            $PruebaPauta = PruebaPauta::findOne($pauta_id);

            if($PruebaPauta){
                if($PruebaPauta->habilidad_id == $id_habilidad){
                    $PruebaPauta->habilidad_id = null;
                }else{
                    $PruebaPauta->habilidad_id = $id_habilidad;
                }
                if ($PruebaPauta->save()) {
                    $estado =1;
                }

            }else{
                $estado = 99;
            }
        }else{
            $estado = 98;
        }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionAsignarEliminarSubEjesTematicos()
    {

        $pauta_id = Yii::$app->request->post('pauta_id', '');
        $id_eje = Yii::$app->request->post('id_eje', '');
        $numero_pregunta = Yii::$app->request->post('numero_pregunta', '');
        $estado = 0;
        $list=[];

        if($pauta_id > 0 && $id_eje > 0 && $numero_pregunta > 0)
        {

            $PruebaPauta = PruebaPauta::findOne($pauta_id);

            if($PruebaPauta){
                if($PruebaPauta->sub_eje_tematico == $id_eje){
                    $PruebaPauta->sub_eje_tematico = null;
                }else{
                    $PruebaPauta->sub_eje_tematico = $id_eje;
                }
                if ($PruebaPauta->save()) {
                    $estado =1;
                }

            }else{
                $estado = 99;
            }
        }else{
            $estado = 98;
        }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

}
