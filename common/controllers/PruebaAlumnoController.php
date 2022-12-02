<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\PruebaAlumno;
use common\models\search\PruebaAlumno as PruebaAlumnoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\PruebaPauta;
use common\models\SubRamo;
use yii\helpers\ArrayHelper;
use common\models\Prueba;
use common\models\Curso;
use common\models\PruebaAlumnoRespuesta;
use common\models\PruebaFormulaNota;
use common\models\PruebaTablaConversionDetalle;
use common\models\FormRut;
use common\models\JonEnviados;
use yii\db\Expression;
use yii\base\Model;
use yii\helpers\Json;
use yii\data\ArrayDataProvider;


/**
 * PruebaAlumnoController Implementa las acciones del CRUD para el modeloPruebaAlumno .
 * */ 
class PruebaAlumnoController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
    public $tituloAyuda='AYUDA INDEX';

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
                        'actions' => ['index','create','update','delete','view','reiniciar','recalcular-puntajes','create-respuesta','crear-respuesta-alternativas','finalizar-prueba-pdf','guardar-respuesta','historial-carga'],
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
                        'actions' => ['index','create','update','view','reiniciar','recalcular-puntajes','create-respuesta','crear-respuesta-alternativas','finalizar-prueba-pdf','guardar-respuesta','historial-carga'],
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

                    [
                        'actions' => ['index','create','update','delete','view','reiniciar','recalcular-puntajes','create-respuesta','crear-respuesta-alternativas','finalizar-prueba-pdf','guardar-respuesta','historial-carga'],
                        'allow' => true,
                        'roles' => ['mantenedores_sistema'],
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

    public function actionRecalcularPuntajes($prueba_alumno_id)
    {
       
        // cargamos la prueba del alumno

        $PruebaAlumno = PruebaAlumno::findOne($prueba_alumno_id);

        // Busco la data de la pauta de la prueba

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$PruebaAlumno->prueba_id,'activo'=>1])->asArray()->All(); 

        $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');


        if ($PruebaAlumno) {
            
            // traigo la data de la prueba
            $PruebaAlumno->detalle_malas = "";

            $PruebaAlumno->buenas = 0;
            $PruebaAlumno->malas = 0;
            $PruebaAlumno->omitidas = 0;

            $Prueba = Prueba::findOne($PruebaAlumno->prueba_id);




            foreach ($PruebaPauta as $key => $Pauta) {



                $PruebaAlumnoRespuesta=PruebaAlumnoRespuesta::findOne(['prueba_alumno_id'=>$prueba_alumno_id,'activo'=>1,'numero_pregunta'=>$Pauta["numero_pregunta"]]);

                // var_dump($PruebaAlumnoRespuesta);
                // echo "<br><br>";

                if(!$PruebaAlumnoRespuesta){


                    $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta();
                    $PruebaAlumnoRespuesta->fecha_creacion = date("Y-m-d H:i:s");
                    $PruebaAlumnoRespuesta->creado_por = 1;
                    $PruebaAlumnoRespuesta->numero_pregunta = $Pauta["numero_pregunta"];
                    $PruebaAlumnoRespuesta->respuesta = "-";
                    $PruebaAlumnoRespuesta->prueba_alumno_id = $prueba_alumno_id;
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

                $PruebaTablaConversionDetalle = PruebaTablaConversionDetalle::findOne(['tabla_conversion_id'=>$Prueba->tabla_conversion_id,'preguntas_correctas'=>$PruebaAlumno->buenas,'activo'=>true]);


                if($PruebaTablaConversionDetalle){
                    $PruebaAlumno->nota = $PruebaTablaConversionDetalle->puntaje;
                }else{
                    $PruebaAlumno->nota = $PruebaAlumno->buenas;
                }

            }



            $PruebaAlumno->save();

            

        }

        return $this->redirect(['index']);

    }

    public function actionIndex()
    {
        /**
        * Lista todo el modelo PruebaAlumno. 
        * no hay variable de retorno
        */
        $searchModel = new PruebaAlumnoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/prueba-alumno/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHistorialCarga($id_carga)
    {

        // obtengo el json de la carga

        

        $JonEnviados = JonEnviados::findOne($id_carga);



        $result =json_decode($JonEnviados->json, true);// to get json


        $Prueba = Prueba::findOne($result["pid"]);

        $SubRamo = SubRamo::findOne($result["rid"]);

        $Curso = Curso::findOne($result["cid"]);

        $ruts_buscar = [];

        // var_dump($Curso);
        // echo "<br><br>";
        // exit;

        foreach ($result["pAbList"] as $prueba) {


            $zonas_generales = ArrayHelper::index($prueba['altMarcL'],'rg');



            // desglozar is rut e id preguntas

            $id_general_rut = 0;

            $id_general_preguntas = 0;

            foreach ($zonas_generales as $zona_general) {

                if($id_general_rut == 0){
                    $id_general_rut = $zona_general['rg'];
                }else{
                    $id_general_preguntas = $zona_general['rg'];
                }


            }



            $zonas_generales = ArrayHelper::index($prueba['altMarcL'], null ,'rg');



            $rut = $this->construirRut($zonas_generales[$id_general_rut]);

            $PruebaAlumno = PruebaAlumno::find()
            ->where(['rut'=>$rut,'prueba_id'=>$result["pid"],'activo' => 1,'curso_id'=>$result["cid"]])
            ->andWhere(['is not', 'fecha_termino', null])
            ->one();

            $nombre_completo = "";

            $Usuario = Usuario::find()
            ->where(['rut'=>$rut])
            ->one();

            if($Usuario){
                $nombre_completo = $Usuario->nombre . " " . $Usuario->apellido_paterno . " " . $Usuario->apellido_materno;
            }
            


            $ruts_buscar[] = [
                'rut' => $rut,
                'id_prueba_alumno' => $PruebaAlumno->id,
                'nombre_completo' => $nombre_completo,
                'nota' => $PruebaAlumno->nota,
                'fecha_inicio' => $PruebaAlumno->fecha_inicio,
                'fecha_termino' => $PruebaAlumno->fecha_termino,
                'buenas' => $PruebaAlumno->buenas,
                'malas' => $PruebaAlumno->malas,
                'omitidas' => $PruebaAlumno->omitidas,
                'hoja_numero' => $prueba["hn"],
                'prueba_id' => $result["pid"],
            ];


        }




        
        


        // $AlumnoCurso = AlumnoCurso::alumnosPorCurso($id,Yii::$app->user->identity->colegio_predeterminada);

        $dataProvider = new ArrayDataProvider([
            'key'=>'id_prueba_alumno',
            'allModels' => $ruts_buscar,
            'pagination' => ['pageSize' => 1000,],
            'sort' => [
                'attributes' => ['id_prueba_alumno','hoja_numero','rut','nombre_completo','fecha_inicio','fecha_termino','nota','buenas','malas','omitidas','prueba_id'],
            ],
        ]);

        return $this->render('@common/views/prueba-alumno/historial_carga', [
            'dataProvider'=>$dataProvider,
            'Prueba'=>$Prueba,
            'SubRamo'=>$SubRamo,
            'Curso'=>$Curso,
        ]);

        // $Prueba


    }

    public function construirRut($array)
    {

        $id_primera_region = 0;

        $string_rut = "";

        $cantidad_registros = 0;

        foreach ($array as $arrayrut) {

            if($id_primera_region == 0){

                $id_primera_region = $arrayrut["rg"];

                $string_rut = $arrayrut["rm"];

            }else{

                if($arrayrut["rg"] == $id_primera_region){

                    if($cantidad_registros < 9){

                        if($cantidad_registros == 8){
                            $string_rut .= "-" . $arrayrut["rm"];
                        }else{
                            $string_rut .= $arrayrut["rm"];
                        }

                    }



                }



            }


            $cantidad_registros++;
        }

        return $string_rut;

    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único PruebaAlumno. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/prueba-alumno/view', [
            'model' => $this->findModel($id),
            
        ]);
    }

    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo PruebaAlumno.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new PruebaAlumno();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/prueba-alumno/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateRespuesta()
    {

        /**
        * Crea un nuevo modelo PruebaAlumno.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */




        $model = new FormRut();
        /* toma el id del usuario que está logeado*/


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->rut = Yii::$app->request->post()["FormRut"]["rut"];

            $Usuario = Usuario::find()->where(['usuario.activo'=>true,'usuario.rut'=>$model->rut,'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
            ->join('INNER JOIN','rol_usuario','rol_usuario.user_id =usuario.id')
            ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
            ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
            ->orderby(['id'=>SORT_ASC])->one();

            if($Usuario){
                return $this->redirect(['crear-respuesta-alternativas','rut'=>$model->rut,'prueba_id'=>$model->prueba_id]);
            }else{

                $model->addError($model->rut , "Rut no existe.");

                return $this->render('@common/views/prueba-alumno/create_respuesta', [
                    'model' => $model,
                ]);
            }


            
        } else {

            if ($model->load(Yii::$app->request->post())) {
                $model->rut = Yii::$app->request->post()["FormRut"]["rut"];
            }



            return $this->render('@common/views/prueba-alumno/create_respuesta', [
                'model' => $model,
            ]);
        }
    }

    public function actionCrearRespuestaAlternativas($rut,$prueba_id)
    {

        date_default_timezone_set('America/Santiago');

        $Usuario = Usuario::find()->where(['usuario.activo'=>true,'usuario.rut'=>$rut])
        ->join('INNER JOIN','usuario_curso','usuario_curso.usuario_id =usuario.id')
        ->select(['usuario_curso.curso_id as curso_id','usuario.id as usuario_id'])
        ->orderby(['usuario.id'=>SORT_ASC])->AsArray()->one();

        
        $Prueba = Prueba::findOne($prueba_id);

        $fecha_inicio_temporal = "";

        $CantidadPruebasAlumno = PruebaAlumno::find()
        ->where(['rut'=>$rut,'prueba_id'=>$prueba_id,'activo' => 1,'curso_id'=>$Usuario['curso_id']])
        ->andWhere(['is not', 'fecha_termino', null])
        ->count();

        
        // cargamos la prueba del alumno

        $PruebaAlumno = PruebaAlumno::findOne(['rut' => $rut,'prueba_id'=>$prueba_id,'curso_id'=>$Usuario['curso_id']]);


        if(!$PruebaAlumno){

            // si el alumno no tiene prueba con fecha abierta se crea una nueva prueba

            
            $PruebaAlumno=new PruebaAlumno;
            $PruebaAlumno->prueba_id = $prueba_id;
            $PruebaAlumno->creado_por = $Usuario['usuario_id'];
            $PruebaAlumno->fecha_inicio = new Expression('NOW()');
            $PruebaAlumno->rut = $rut;
            $PruebaAlumno->curso_id = $Usuario['curso_id'];

            $fecha_inicio_temporal = new \DateTime();
            $fecha_inicio_temporal2 = new \DateTime();

        }

        $PruebaAlumno->save();

        $Prueba_preguntas=$Prueba->getPreguntasPrueba();


        for($i = 1; $i <= $Prueba->numero_preguntas; $i++) {

            $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'numero_pregunta'=>$i,'activo'=>1])->one();  

            if(!$PruebaAlumnoRespuestaGuardado){
                $PruebaAlumnoRespuesta[$i] = new PruebaAlumnoRespuesta();
            }else{
                $PruebaAlumnoRespuesta[$i] = $PruebaAlumnoRespuestaGuardado;
            }
            
        }

        if($fecha_inicio_temporal == ""){
            $fecha_inicio = new \DateTime($PruebaAlumno->fecha_inicio);
            $fecha_inicio2 = new \DateTime($PruebaAlumno->fecha_inicio);
            $fecha_alerta = new \DateTime($PruebaAlumno->fecha_inicio);
            $fecha_alerta2 = new \DateTime($PruebaAlumno->fecha_inicio);
        }else{
            $fecha_inicio = $fecha_inicio_temporal;
            $fecha_inicio2 = $fecha_inicio_temporal;
            $fecha_alerta = $fecha_inicio_temporal2;
            $fecha_alerta2 = $fecha_inicio_temporal2;
        }

        $fecha_inicio2 = date_modify($fecha_inicio2, '+'.$Prueba->cantidad_minutos.' minutes');

        $intervalo_de_tiempo = $fecha_inicio2->getTimestamp() - $fecha_inicio->getTimestamp();

        $fecha_alerta2 = date_modify($fecha_alerta2, '+'.($Prueba->cantidad_minutos - 10).' minutes');

        $fecha_actual = new \DateTime(); 

        // if($fecha_actual >= $fecha_inicio2){
        //     if(!$PruebaAlumno->fecha_termino){
        //         $this->redirect(array('finalizar-prueba','prueba_id'=>$Prueba->id,'prueba_alumno'=>$PruebaAlumno->id,'curso_id'=>$curso_id));
        //     }else{
        //         //$this->redirect(array('resultados','id_ensayo'=>$ensayo->id));
        //     }

            
        // }

        $mostrar_alerta = 0;


        $this->info_superior = 1;

        $segundos =  $fecha_inicio2->getTimestamp() - $fecha_actual->getTimestamp();


        $segundos2 =  $fecha_alerta2->getTimestamp() - $fecha_actual->getTimestamp();


        $PruebaAlumno->save();

        $this->layout = "@alumno/views/layouts/rendir_prueba_pdf";



        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$Prueba->id,'activo'=>1])->asArray()->all();

        $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');



        return $this->render('@common/views/prueba-alumno/rendir', [
            'PruebaAlumno' => $PruebaAlumno,
            'PruebaAlumnoRespuesta' => $PruebaAlumnoRespuesta,
            'Prueba_preguntas' => $Prueba_preguntas,
            'CPruebasAlumno' => $CantidadPruebasAlumno,
            'segundos'=>$segundos,
            'segundos2'=>$segundos2,
            'prueba_id'=>$Prueba->id,
            'mostrar_alerta'=>$mostrar_alerta,
            'Prueba'=>$Prueba,
            'nombre'=>$Prueba->nombre,
            'curso_id'=>$Usuario['curso_id'],
            'PruebaPauta'=>$PruebaPauta,
            'rut'=>$rut,
        ]);

    }

    
    // public function actionUpdate($id)
    // {
        //     /**
        //     * Actualiza un modelo existente PruebaAlumno.
        //     * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        //     * @param integer $id
        //     *  no tiene variable de retorno
        //     */

        //     $model = $this->findModel($id);
        //     /* toma el id del usuario que está logeado*/
        //     $model->modificado_por = Yii::$app->user->identity->id ;     
        //     $model->fecha_modificacion = date("Y-m-d H:i:s");
        //     if ($model->load(Yii::$app->request->post()) && $model->save()) {
        //         return $this->redirect(['index']);
        //     } else {
        //         return $this->render('@common/views/prueba-alumno/update', [
        //             'model' => $model,
        //         ]);
        //     }
    // }

    public function actionFinalizarPruebaPdf($prueba_id,$prueba_alumno,$curso_id,$rut,$taller="")
    {
        // traigo la data de la prueba

        $Prueba = Prueba::findOne($prueba_id);

        $Usuario = Usuario::find()->where(['usuario.activo'=>true,'usuario.rut'=>$rut])
        ->join('INNER JOIN','usuario_curso','usuario_curso.usuario_id =usuario.id')
        ->select(['usuario_curso.curso_id as curso_id','usuario.id as usuario_id'])
        ->orderby(['usuario.id'=>SORT_ASC])->AsArray()->one();

        // cargamos la prueba del alumno

            $PruebaAlumno = PruebaAlumno::findOne(['rut' => $rut,'fecha_termino'=>null,'prueba_id'=>$prueba_id,'id'=>$prueba_alumno]);

            // Busco la data de la pauta de la prueba

            $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$Prueba->id,'activo'=>1])->asArray()->All(); 

            $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');



        if ($PruebaAlumno) {
            
            // traigo la data de la prueba
            $PruebaAlumno->detalle_malas = "";

            $PruebaAlumno->buenas = 0;
            $PruebaAlumno->malas = 0;
            $PruebaAlumno->omitidas = 0;

            $Prueba = Prueba::findOne($prueba_id);

            for($i = 1; $i <= $Prueba->numero_preguntas; $i++) {

                $PruebaAlumnoRespuesta[$i] = new PruebaAlumnoRespuesta();

            }



            // cargo las respuestas enviadas por el alumno

            if (Model::loadMultiple($PruebaAlumnoRespuesta, Yii::$app->request->post())) {
                $PruebaAlumnoRespuesta = [];

                foreach (Yii::$app->request->post()['PruebaAlumnoRespuesta'] as $PruebaAlumnoRespuesta2) {
                    $PruebaAlumnoRespuesta[$PruebaAlumnoRespuesta2['numero_pregunta']] = new PruebaAlumnoRespuesta();
                }

                Model::loadMultiple($PruebaAlumnoRespuesta, Yii::$app->request->post());


                $error = false;
                $cantidad_on = 0;



                foreach ($PruebaAlumnoRespuesta as &$AlumnoRespuesta) {

                    $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$PruebaAlumno->id,'numero_pregunta'=>$AlumnoRespuesta->numero_pregunta,'activo'=>1])->one();  

                    if(!$PruebaAlumnoRespuestaGuardado){

                        $AlumnoRespuesta->respuesta = $AlumnoRespuesta->respuesta;
                        $AlumnoRespuesta->pregunta_id = $AlumnoRespuesta->pregunta_id;
                        $AlumnoRespuesta->prueba_alumno_id = $PruebaAlumno->id;
                        $AlumnoRespuesta->creado_por = $Usuario['usuario_id'];

                    }else{
                        $PruebaAlumnoRespuestaGuardado->respuesta = $AlumnoRespuesta->respuesta;
                        $PruebaAlumnoRespuestaGuardado->modificado_por = $Usuario['usuario_id'];
                        
                        $AlumnoRespuesta = $PruebaAlumnoRespuestaGuardado;
                        $AlumnoRespuesta->activo = 1;
                    }

                    if (!$AlumnoRespuesta->save()) {
                        $error = true;
                        break;
                    }


                    if ($PruebaPauta[$AlumnoRespuesta->numero_pregunta]["correcta"] != "") {

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




                    $cantidad_on++;

                }
                


            }else{
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

                $PruebaTablaConversionDetalle = PruebaTablaConversionDetalle::findOne(['tabla_conversion_id'=>$Prueba->tabla_conversion_id,'preguntas_correctas'=>$PruebaAlumno->buenas,'activo'=>true]);


                if($PruebaTablaConversionDetalle){
                    $PruebaAlumno->nota = $PruebaTablaConversionDetalle->puntaje;
                }else{
                    $PruebaAlumno->nota = $PruebaAlumno->buenas;
                }

            }



            $PruebaAlumno->fecha_termino = new Expression('NOW()');

            $PruebaAlumno->save();

            

        }

        return $this->redirect(['/prueba-alumno/create-respuesta']);

        

    }

    public function actionDelete($id)
    {
        /**
        * Elimina un modelo existente  PruebaAlumno.
        * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" . 
        * @param integer $id
        * no tiene variable de retorno 
        */

        $model = $this->findModel($id);
        if($model->activo == true )
        {
            $model->activo = false ;
            $model->save();     
        }else{
            $model->activo = true ;
            $model->save();
        }

        return $this->redirect(['index']);
    }

    public function actionReiniciar($id)
    {
        /**
        * Elimina un modelo existente  PruebaAlumno.
        * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" . 
        * @param integer $id
        * no tiene variable de retorno 
        */

        $model = $this->findModel($id);
        $model->fecha_inicio = "";
        $model->fecha_termino = "";
        $model->save();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        /**
        * Busca el modelo PruebaAlumno en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return PruebaAlumno el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = PruebaAlumno::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGuardarRespuesta($prueba_id,$prueba_alumno,$rut,$respuesta,$numero_pregunta)
    {

        $Usuario = Usuario::find()->where(['usuario.activo'=>true,'usuario.rut'=>$rut])
        ->join('INNER JOIN','usuario_curso','usuario_curso.usuario_id =usuario.id')
        ->select(['usuario_curso.curso_id as curso_id','usuario.id as usuario_id'])
        ->orderby(['usuario.id'=>SORT_ASC])->AsArray()->one();

        $estado = 0;

        $PruebaAlumnoRespuesta = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$prueba_alumno,'numero_pregunta'=>$numero_pregunta,'activo'=>1])->one();  

        if(!$PruebaAlumnoRespuesta){
            $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta;
            $PruebaAlumnoRespuesta->prueba_alumno_id = $prueba_alumno;
            $PruebaAlumnoRespuesta->creado_por = $Usuario['usuario_id'];
            $PruebaAlumnoRespuesta->numero_pregunta = $numero_pregunta;

        }else{
            
            $PruebaAlumnoRespuesta->modificado_por = $Usuario['usuario_id'];
        }

        $PruebaAlumnoRespuesta->respuesta = $respuesta;

        if($PruebaAlumnoRespuesta->save()){
            $estado = 2;
        }else{
            $estado = 3;
        }

        echo Json::encode(['estado'=>$estado]);
 
    }
}
