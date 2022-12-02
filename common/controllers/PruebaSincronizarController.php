<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Dia;
use common\models\search\Dia as DiaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Prueba;
use common\models\moodle\MdlilMoodleCourseModule;
use common\models\moodle\MdlilMoodleQuizSlots;
use common\models\moodle\MdlilMoodleQuestion;
use common\models\moodle\MdlilMoodleFiles;
use common\models\moodle\MdlilMoodleQuestionAttempts;
use common\models\moodle\MdlilMoodleQuestionAnswers;
use common\models\MdlilQuizQuestionInstances;
use common\models\MdlilQuestion;
use common\models\MdlilQuestionAnswers;
use common\models\PruebaPauta;
use yii\helpers\Json;

/**
 * DiaController Implementa las acciones del CRUD para el modeloDia .
 * */ 
class PruebaSincronizarController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';

    public $moodle_session=''; 

    public $tituloAyuda='AYUDA INDEX';

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],

                //esto permite definir una determinada acción en caso de que no se cumplan las reglas
                // lo dejare comentado para ver si posteriormente sirve en algún caso particular
                // 'denyCallback' => function ($rule, $action) {
                //     //Esta es la acción a ejecutar en caso de que no se cumplan las reglas

                //     throw new \Exception('error');
                // },
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
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

    public function actionIndex($id)
    {

        // busco todas las pruebas del full que tienen asignado migración

        $Prueba = Prueba::find()
        ->where(['activo' => 1,'migrar' => 1])
        ->all();

        return $this->render('@common/views/prueba-sincronizar/index', [
            'Pruebas' => $Prueba,
            'id' => $id,
        ]);
    }

    public function actionSincronizarPrueba()
    {

        $this->moodle_session = Yii::$app->request->post('id_moodle');


        $status = 0;
        $cantidad_errores = 0;

        

        // busco el modelo de la prueba

            $Prueba = Prueba::findOne(Yii::$app->request->post('id_prueba'));



        // Veo si la prueba tiene un id de moodle

            if ($Prueba->externo_id) {
                // Creamos un contador para los errores

                    $alternativas [] = 'A';
                    $alternativas [] = 'B';
                    $alternativas [] = 'C';
                    $alternativas [] = 'D';
                    $alternativas [] = 'E';
                    
                    $cantidad_errores_prueba = 0;
                    $cantidad_errores_preguntas = 0;
                    $cantidad_errores_alternativas = 0;

                    // Realizo la consulta a la base de datos del moodle con el id externo

                    $i = 1;

                    $MdlilMoodleCourseModule = MdlilMoodleCourseModule::find()
                    ->select('mdlil_quiz.id')
                    // ->select(' mdl_course_modules.id AS cm_id,     mdl_course_modules.module,    mdl_course_modules.instance')

                    ->where(['mdlil_course_modules.id'=>$Prueba->externo_id])
                    ->join('LEFT JOIN','mdlil_quiz','mdlil_quiz.id =mdlil_course_modules.instance')
                    ->asArray()
                    
                    ->one();




                    $MdlilQuizQuestionInstancesDelete = MdlilQuizQuestionInstances::find()->where(['quiz'=>$Prueba->externo_id])->All();




                    foreach ($MdlilQuizQuestionInstancesDelete as $key => $MdlQuizQuestionInstanceDelete) {
                        $MdlQuizQuestionInstanceDelete->delete();
                    }


                    $MdlilMoodleQuizSlots = MdlilMoodleQuizSlots::find()->where(['quizid'=>$MdlilMoodleCourseModule['id']])->All();
                    


                    foreach ($MdlilMoodleQuizSlots as $key => $QuizSlotsNuevo) {

                        

                            // Consulto si existe la instancia
                            $MdlilQuizQuestionInstances = MdlilQuizQuestionInstances::findOne(['question'=>(int)$QuizSlotsNuevo->questionid,'quiz'=>$Prueba->externo_id,'anio_id'=>Yii::$app->user->identity->anio_predeterminado]);


                            // si no existe la creo
                                if(!$MdlilQuizQuestionInstances){



                                    $MdlilQuizQuestionInstances=new MdlilQuizQuestionInstances;

                                    $MdlilQuizQuestionInstances->mencion           = null;
                                    $MdlilQuizQuestionInstances->quiz              = $Prueba->externo_id;

                                }

                            $MdlilQuizQuestionInstances->numero_pregunta   = $QuizSlotsNuevo->slot;
                            $MdlilQuizQuestionInstances->question          = (int)$QuizSlotsNuevo->questionid;
                            $MdlilQuizQuestionInstances->anio_id          = Yii::$app->user->identity->anio_predeterminado;



                            if($MdlilQuizQuestionInstances->save()){



                                // Realizo el select de las preguntas
                                $MdlilMoodleQuestion = MdlilMoodleQuestion::findOne((int)$MdlilQuizQuestionInstances->question);



                                // busco si existe en nuestra base
                                $MdlilQuestion = MdlilQuestion::findOne((int)$MdlilQuizQuestionInstances->question);





                                $MdlilMoodleQuestion->questiontext = $this->actionProcesarImagenesQuestion($MdlilMoodleQuestion);


                                //exit;
                                
                                //echo $src;

                                // $imgs = $dom->query("//img");
                                // for ($i=0; $i < $imgs->length; $i++) {
                                //     $img = $imgs->item($i);
                                //     $src = $img->getAttribute("src");

                                //     echo "src : " . $src . "<br>";


                                // }
                                // $scraped_img = $src;

                                // var_dump($MdlilMoodleQuestion->questiontext);
                                // // var_dump($MdlilQuizQuestionInstances->question);

                                // echo "<br><br><br>";

                                $imgs ="";
                                
                                // if($imgs->length >= 1){
                                //     var_dump($MdlilMoodleQuestion->questiontext);
                                //     exit;
                                // }


                                

                                // Si no existe la creo
                                if(!$MdlilQuestion){
                                    $MdlilQuestion=new MdlilQuestion;
                                }
                                $MdlilQuestion->id                    = $MdlilMoodleQuestion->id;
                                $MdlilQuestion->category              = $MdlilMoodleQuestion->category ;
                                $MdlilQuestion->parent                = $MdlilMoodleQuestion->parent;
                                $MdlilQuestion->name                  = $MdlilMoodleQuestion->name;
                                $MdlilQuestion->questiontext          = $MdlilMoodleQuestion->questiontext;
                                $MdlilQuestion->questiontextformat    = $MdlilMoodleQuestion->questiontextformat;
                                $MdlilQuestion->generalfeedback       = $MdlilMoodleQuestion->generalfeedback;
                                $MdlilQuestion->generalfeedbackformat = $MdlilMoodleQuestion->generalfeedbackformat;
                                $MdlilQuestion->defaultmark           = $MdlilMoodleQuestion->defaultmark;
                                $MdlilQuestion->penalty               = $MdlilMoodleQuestion->penalty;
                                $MdlilQuestion->qtype                 = $MdlilMoodleQuestion->qtype;
                                $MdlilQuestion->length1               = $MdlilMoodleQuestion->length;
                                $MdlilQuestion->stamp                 = $MdlilMoodleQuestion->stamp;
                                $MdlilQuestion->version1              = $MdlilMoodleQuestion->version;
                                $MdlilQuestion->hidden                = $MdlilMoodleQuestion->hidden;
                                $MdlilQuestion->timecreated           = $MdlilMoodleQuestion->timecreated;
                                $MdlilQuestion->timemodified          = $MdlilMoodleQuestion->timemodified;
                                $MdlilQuestion->createdby             = $MdlilMoodleQuestion->createdby;
                                $MdlilQuestion->modifiedby            = $MdlilMoodleQuestion->modifiedby;                                   

                                $MdlilQuestion->migrado              = 1;
                                $MdlilQuestion->reparar_imagenes      = null;

                                

                                if($MdlilQuestion->save()){

                                    $MdlilMoodleQuestionAnswers =   MdlilMoodleQuestionAnswers::find()
                                                            ->select('*')
                                                            ->where(['question' => (int)$MdlilQuestion->id])
                                                            ->all(); 



                                    $i_alternativa = 0;
                                    $correcta= 0;
                                    foreach($MdlilMoodleQuestionAnswers as $ExternoQuestionAnswer){


                                        $MdlilQuestionAnswers = MdlilQuestionAnswers::findOne($ExternoQuestionAnswer->id);

                                        // if($imgs->length >= 1){
                                        //     var_dump($ExternoQuestionAnswer->id);
                                        //     exit;
                                        // }
    
                                        $ExternoQuestionAnswer->answer = $this->actionProcesarImagenesAnswer($ExternoQuestionAnswer,$MdlilMoodleQuestion,$QuizSlotsNuevo);



                                        // Si no existe la creo
                                        if(!$MdlilQuestionAnswers){
                                            $MdlilQuestionAnswers=new MdlilQuestionAnswers;
                                        }
                                        $MdlilQuestionAnswers->id                     = $ExternoQuestionAnswer->id;
                                        $MdlilQuestionAnswers->question               = $ExternoQuestionAnswer->question  ;
                                        $MdlilQuestionAnswers->answer                 = $ExternoQuestionAnswer->answer;
                                        $MdlilQuestionAnswers->fraction           = $ExternoQuestionAnswer->fraction;
                                        $MdlilQuestionAnswers->feedback           = $ExternoQuestionAnswer->feedback;
                                        $MdlilQuestionAnswers->migrado           = 1;
                                        $MdlilQuestionAnswers->reparar_imagenes   = null;



                                        if($MdlilQuestionAnswers->save()){
                                            if ($MdlilQuestionAnswers->fraction == 1) {
                                                $correcta = $i_alternativa;
                                            }

                                            $i_alternativa++;


                                        }else{
                                            $cantidad_errores++;
                                            $cantidad_errores_alternativas++;
                                            // En caso de que no se guarde la pregunta

                                                $datos = "";
                                                $errores = 0;
                                                foreach ($MdlilQuestionAnswers->getErrors() as $errors) {
                                                    foreach ($errors as $error) {
                                                        if ($error != ''){
                                                            $errores++;
                                                            $datos .= "<tr>";
                                                            //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                                            $datos .= "<td><div title=\"nombre\" class=\"nombre_div\"></div></td>";
                                                            $datos .= "<td>".$error."</td>";
                                                            $datos .= "</tr>";
                                                        }
                                                    }
                                                }

                                                var_dump($datos);
                                        }

                                    }

                                    // Guardo la respuesta correcta en la tabla de pauta PruebaPauta
                                    // Tomo el número de pregunta de $MdlilQuizQuestionInstances->numero_pregunta

                                    // Busco si ya exoste la pauta




                                    if ($Prueba->migrar_pauta == 1) {

                                        $PruebaPauta = PruebaPauta::findOne(['prueba_id' => $Prueba->id,'numero_pregunta'=>$MdlilQuizQuestionInstances->numero_pregunta,'activo'=>1]);

                                        if (!$PruebaPauta) {
                                            $PruebaPauta = new PruebaPauta;
                                            $PruebaPauta->creado_por = Yii::$app->user->identity->id;
                                            $PruebaPauta->prueba_id = $Prueba->id;
                                            $PruebaPauta->numero_pregunta = $MdlilQuizQuestionInstances->numero_pregunta;
                                        }else{
                                            $PruebaPauta->modificado_por = Yii::$app->user->identity->id;
                                        }

                                        $PruebaPauta->correcta = $alternativas[$correcta];

                                        if ($PruebaPauta->save()) {
                                            # code...
                                        }else{
                                            $cantidad_errores++;
                                            $cantidad_errores_preguntas++;
                                            // En caso de que no se guarde la pregunta

                                                $datos = "";
                                                $errores = 0;
                                                foreach ($MdlilQuestion->getErrors() as $errors) {
                                                    foreach ($errors as $error) {
                                                        if ($error != ''){
                                                            $errores++;
                                                            $datos .= "<tr>";
                                                            //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                                            $datos .= "<td><div title=\"nombre\" class=\"nombre_div\"></div></td>";
                                                            $datos .= "<td>".$error."</td>";
                                                            $datos .= "</tr>";
                                                        }
                                                    }
                                                }

                                                var_dump($datos);
                                        }

                                    }




                                }else{

                                }




                            }else{
                                $cantidad_errores++;
                                $cantidad_errores_prueba++;

                                $errors = "";
                                $errores = 0;
                                $datos = "";

                                // print_r($model->getErrors());
                                // exit;
                                foreach ($MdlilQuizQuestionInstances->getErrors() as $errors) {
                                    foreach ($errors as $error) {
                                        if ($error != ''){
                                            $errores++;
                                            $datos .= "<tr>";
                                            //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                            $datos .= "<td><div title=\"nombre\" class=\"nombre_div\">{$MdlilQuizQuestionInstances->question}</div></td>";
                                            $datos .= "<td>".$error."</td>";
                                            $datos .= "</tr>";
                                        }
                                    }
                                }

                                var_dump($datos);

                            } 
                    }

            }


        $status_errores_alinear = 0;

        if(Yii::$app->user->identity->anio_predeterminado >= 4){

            // Recorro las preguntas que neesiten alinearce
                $MdlilQuestions =   MdlilQuestion::find()
                ->select('*')
                ->where(['reparar_imagenes' => null])
                ->all(); 

                foreach ($MdlilQuestions as $MdlilQuestion) {
                    $MdlilQuestion->questiontext            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestion->questiontext);
                    $MdlilQuestion->reparar_imagenes  = 1;

                    if($MdlilQuestion->save()){

                    }else{
                        $cantidad_errores++;
                        $status_errores_alinear++;
                    }
                }

            // Recorro las alternativas que neesiten alinearce
                $MdlilQuestionAnswers =   MdlilQuestionAnswers::find()
                        ->select('*')
                        ->where(['reparar_imagenes' => null])
                        ->all(); 

                foreach ($MdlilQuestionAnswers as $MdlilQuestionAnswer) {
                    $MdlilQuestionAnswer->answer            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestionAnswer->answer);
                    $MdlilQuestionAnswer->reparar_imagenes  = 1;

                    if($MdlilQuestionAnswer->save()){

                    }else{
                        $cantidad_errores++;
                        $status_errores_alinear++;
                    }
                }

        }else{

            // Recorro las preguntas que neesiten alinearce
            $MdlilQuestions =   MdlilQuestion::find()
            ->select('*')
            ->where(['reparar_imagenes' => null])
            ->all(); 

            foreach ($MdlilQuestions as $MdlilQuestion) {
                $MdlilQuestion->questiontext            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestion->questiontext);
                $MdlilQuestion->reparar_imagenes  = 1;

                if($MdlilQuestion->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

            // Recorro las alternativas que neesiten alinearce
                $MdlilQuestionAnswers =   MdlilQuestionAnswers::find()
                        ->select('*')
                        ->where(['reparar_imagenes' => null])
                        ->all(); 

                foreach ($MdlilQuestionAnswers as $MdlilQuestionAnswer) {
                    $MdlilQuestionAnswer->answer            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestionAnswer->answer);
                    $MdlilQuestionAnswer->reparar_imagenes  = 1;

                    if($MdlilQuestionAnswer->save()){

                    }else{
                        $cantidad_errores++;
                        $status_errores_alinear++;
                    }
                }

        }


        if($cantidad_errores == 0){
            $status = 1;
        }


        return Json::encode(['status_errores_alinear'=>$status_errores_alinear,'cantidad_errores_alternativas'=>$cantidad_errores_alternativas,'cantidad_errores_preguntas'=>$cantidad_errores_preguntas,'cantidad_errores_prueba'=>$cantidad_errores_prueba,'status'=>$status,'id_prueba'=>Yii::$app->request->post('id_prueba')]);

    }

    public function actionSincronizarSolucionario()
    {

        $this->moodle_session = Yii::$app->request->post('id_moodle');

        $status = 0;
        $cantidad_errores = 0;
        $cantidad_errores_solucionario = 0;
        $cantidad_errores_preguntas_solucionario = 0;
        $cantidad_errores_alternativas_solucionario = 0;
        // busco el modelo de la prueba

            $Prueba = Prueba::findOne(Yii::$app->request->post('id_prueba'));

        // Veo si la prueba tiene un id de solucionario

            if ($Prueba->solucionario_id) {
                // Creamos un contador para los errores


                $MdlilMoodleCourseModule = MdlilMoodleCourseModule::find()
                ->select('mdlil_quiz.id')
                // ->select(' mdl_course_modules.id AS cm_id,     mdl_course_modules.module,    mdl_course_modules.instance')

                ->where(['mdlil_course_modules.id'=>$Prueba->solucionario_id])
                ->join('LEFT JOIN','mdlil_quiz','mdlil_quiz.id =mdlil_course_modules.instance')
                ->asArray()
                
                ->one();




                $MdlilQuizQuestionInstancesDelete = MdlilQuizQuestionInstances::find()->where(['quiz'=>$Prueba->solucionario_id])->All();




                foreach ($MdlilQuizQuestionInstancesDelete as $key => $MdlQuizQuestionInstanceDelete) {
                    $MdlQuizQuestionInstanceDelete->delete();
                }


                $MdlilMoodleQuizSlots = MdlilMoodleQuizSlots::find()->where(['quizid'=>$MdlilMoodleCourseModule['id']])->All();
                

                foreach ($MdlilMoodleQuizSlots as $key => $QuizSlotsNuevo) {

                    // Consulto si existe la instancia
                    $MdlilQuizQuestionInstances = MdlilQuizQuestionInstances::findOne(['question'=>(int)$QuizSlotsNuevo->questionid,'quiz'=>$Prueba->solucionario_id,'anio_id'=>Yii::$app->user->identity->anio_predeterminado]);


                    // si no existe la creo
                        if(!$MdlilQuizQuestionInstances){



                            $MdlilQuizQuestionInstances=new MdlilQuizQuestionInstances;

                            $MdlilQuizQuestionInstances->mencion           = null;
                            $MdlilQuizQuestionInstances->quiz              = $Prueba->solucionario_id;

                        }

                    $MdlilQuizQuestionInstances->numero_pregunta   = $QuizSlotsNuevo->slot;
                    $MdlilQuizQuestionInstances->question          = (int)$QuizSlotsNuevo->questionid;
                    $MdlilQuizQuestionInstances->anio_id          = Yii::$app->user->identity->anio_predeterminado;



                    if($MdlilQuizQuestionInstances->save()){



                        // Realizo el select de las preguntas
                        $MdlilMoodleQuestion = MdlilMoodleQuestion::findOne((int)$MdlilQuizQuestionInstances->question);



                        // busco si existe en nuestra base
                        $MdlilQuestion = MdlilQuestion::findOne((int)$MdlilQuizQuestionInstances->question);





                        $MdlilMoodleQuestion->questiontext = $this->actionProcesarImagenesQuestion($MdlilMoodleQuestion);


                        //exit;
                        
                        //echo $src;

                        // $imgs = $dom->query("//img");
                        // for ($i=0; $i < $imgs->length; $i++) {
                        //     $img = $imgs->item($i);
                        //     $src = $img->getAttribute("src");

                        //     echo "src : " . $src . "<br>";


                        // }
                        // $scraped_img = $src;

                        // var_dump($MdlilMoodleQuestion->questiontext);
                        // // var_dump($MdlilQuizQuestionInstances->question);

                        // echo "<br><br><br>";

                        $imgs ="";
                        
                        // if($imgs->length >= 1){
                        //     var_dump($MdlilMoodleQuestion->questiontext);
                        //     exit;
                        // }


                        

                        // Si no existe la creo
                        if(!$MdlilQuestion){
                            $MdlilQuestion=new MdlilQuestion;
                        }
                        $MdlilQuestion->id                    = $MdlilMoodleQuestion->id;
                        $MdlilQuestion->category              = $MdlilMoodleQuestion->category ;
                        $MdlilQuestion->parent                = $MdlilMoodleQuestion->parent;
                        $MdlilQuestion->name                  = $MdlilMoodleQuestion->name;
                        $MdlilQuestion->questiontext          = $MdlilMoodleQuestion->questiontext;
                        $MdlilQuestion->questiontextformat    = $MdlilMoodleQuestion->questiontextformat;
                        $MdlilQuestion->generalfeedback       = $MdlilMoodleQuestion->generalfeedback;
                        $MdlilQuestion->generalfeedbackformat = $MdlilMoodleQuestion->generalfeedbackformat;
                        $MdlilQuestion->defaultmark           = $MdlilMoodleQuestion->defaultmark;
                        $MdlilQuestion->penalty               = $MdlilMoodleQuestion->penalty;
                        $MdlilQuestion->qtype                 = $MdlilMoodleQuestion->qtype;
                        $MdlilQuestion->length1               = $MdlilMoodleQuestion->length;
                        $MdlilQuestion->stamp                 = $MdlilMoodleQuestion->stamp;
                        $MdlilQuestion->version1              = $MdlilMoodleQuestion->version;
                        $MdlilQuestion->hidden                = $MdlilMoodleQuestion->hidden;
                        $MdlilQuestion->timecreated           = $MdlilMoodleQuestion->timecreated;
                        $MdlilQuestion->timemodified          = $MdlilMoodleQuestion->timemodified;
                        $MdlilQuestion->createdby             = $MdlilMoodleQuestion->createdby;
                        $MdlilQuestion->modifiedby            = $MdlilMoodleQuestion->modifiedby;                                   

                        $MdlilQuestion->migrado              = 1;
                        $MdlilQuestion->reparar_imagenes      = null;

                        

                        if($MdlilQuestion->save()){

                            $MdlilMoodleQuestionAnswers =   MdlilMoodleQuestionAnswers::find()
                                                    ->select('*')
                                                    ->where(['question' => (int)$MdlilQuestion->id])
                                                    ->all(); 



                            $i_alternativa = 0;
                            $correcta= 0;
                            foreach($MdlilMoodleQuestionAnswers as $ExternoQuestionAnswer){


                                $MdlilQuestionAnswers = MdlilQuestionAnswers::findOne($ExternoQuestionAnswer->id);

                                // if($imgs->length >= 1){
                                //     var_dump($ExternoQuestionAnswer->id);
                                //     exit;
                                // }

                                $ExternoQuestionAnswer->answer = $this->actionProcesarImagenesAnswer($ExternoQuestionAnswer,$MdlilMoodleQuestion,$QuizSlotsNuevo);



                                // Si no existe la creo
                                if(!$MdlilQuestionAnswers){
                                    $MdlilQuestionAnswers=new MdlilQuestionAnswers;
                                }
                                $MdlilQuestionAnswers->id                     = $ExternoQuestionAnswer->id;
                                $MdlilQuestionAnswers->question               = $ExternoQuestionAnswer->question  ;
                                $MdlilQuestionAnswers->answer                 = $ExternoQuestionAnswer->answer;
                                $MdlilQuestionAnswers->fraction           = $ExternoQuestionAnswer->fraction;
                                $MdlilQuestionAnswers->feedback           = $ExternoQuestionAnswer->feedback;
                                $MdlilQuestionAnswers->migrado           = 1;
                                $MdlilQuestionAnswers->reparar_imagenes   = null;



                                if($MdlilQuestionAnswers->save()){
                                    if ($MdlilQuestionAnswers->fraction == 1) {
                                        $correcta = $i_alternativa;
                                    }

                                    $i_alternativa++;


                                }else{
                                    $cantidad_errores++;
                                    $cantidad_errores_alternativas++;
                                    // En caso de que no se guarde la pregunta

                                        $datos = "";
                                        $errores = 0;
                                        foreach ($MdlilQuestionAnswers->getErrors() as $errors) {
                                            foreach ($errors as $error) {
                                                if ($error != ''){
                                                    $errores++;
                                                    $datos .= "<tr>";
                                                    //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                                    $datos .= "<td><div title=\"nombre\" class=\"nombre_div\"></div></td>";
                                                    $datos .= "<td>".$error."</td>";
                                                    $datos .= "</tr>";
                                                }
                                            }
                                        }

                                        var_dump($datos);
                                }

                            }

                            // Guardo la respuesta correcta en la tabla de pauta PruebaPauta
                            // Tomo el número de pregunta de $MdlilQuizQuestionInstances->numero_pregunta

                            // Busco si ya exoste la pauta









                        }else{

                        }




                    }else{
                        $cantidad_errores++;
                        $cantidad_errores_prueba++;

                        $errors = "";
                        $errores = 0;
                        $datos = "";

                        // print_r($model->getErrors());
                        // exit;
                        foreach ($MdlilQuizQuestionInstances->getErrors() as $errors) {
                            foreach ($errors as $error) {
                                if ($error != ''){
                                    $errores++;
                                    $datos .= "<tr>";
                                    //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                    $datos .= "<td><div title=\"nombre\" class=\"nombre_div\">{$MdlilQuizQuestionInstances->question}</div></td>";
                                    $datos .= "<td>".$error."</td>";
                                    $datos .= "</tr>";
                                }
                            }
                        }

                        var_dump($datos);

                    }                        

 
                }

                    





            }


        $status_errores_alinear = 0;

        if(Yii::$app->user->identity->anio_predeterminado >= 4){

        // Recorro las preguntas que neesiten alinearce
            $MdlilQuestion =   MdlilQuestion::find()
            ->select('*')
            ->where(['reparar_imagenes' => null])
            ->all(); 

            foreach ($MdlilQuestion as $MdlilQuestion) {
                $MdlilQuestion->questiontext            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestion->questiontext);
                $MdlilQuestion->reparar_imagenes  = 1;

                if($MdlilQuestion->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

        // Recorro las alternativas que neesiten alinearce
            $MdlilQuestionAnswers =   MdlilQuestionAnswers35::find()
                    ->select('*')
                    ->where(['reparar_imagenes' => null])
                    ->all(); 

            foreach ($MdlilQuestionAnswers as $MdlilQuestionAnswer) {
                $MdlilQuestionAnswer->answer            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestionAnswer->answer);
                $MdlilQuestionAnswer->reparar_imagenes  = 1;

                if($MdlilQuestionAnswer->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

        }else{

        // Recorro las preguntas que neesiten alinearce
            $MdlilQuestion =   MdlilQuestion::find()
            ->select('*')
            ->where(['reparar_imagenes' => null])
            ->all(); 

            foreach ($MdlilQuestion as $MdlilQuestion) {
                $MdlilQuestion->questiontext            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestion->questiontext);
                $MdlilQuestion->reparar_imagenes  = 1;

                if($MdlilQuestion->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

        // Recorro las alternativas que neesiten alinearce
            $MdlilQuestionAnswers =   MdlilQuestionAnswers::find()
                    ->select('*')
                    ->where(['reparar_imagenes' => null])
                    ->all(); 

            foreach ($MdlilQuestionAnswers as $MdlilQuestionAnswer) {
                $MdlilQuestionAnswer->answer            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestionAnswer->answer);
                $MdlilQuestionAnswer->reparar_imagenes  = 1;

                if($MdlilQuestionAnswer->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

        }




        if($cantidad_errores == 0){
            $status = 1;
        }


        return Json::encode(['cantidad_errores_alternativas_solucionario'=>$cantidad_errores_alternativas_solucionario,'cantidad_errores_preguntas_solucionario'=>$cantidad_errores_preguntas_solucionario,'cantidad_errores_solucionario'=>$cantidad_errores_solucionario,'status_errores_alinear'=>$status_errores_alinear,'status'=>$status,'id_prueba'=>Yii::$app->request->post('id_prueba')]);

    }


    public function actionProcesarImagenesAnswer($ExternoQuestionAnswer,$MdlilMoodleQuestion,$QuizSlotsNuevo)
    {



        $dom = new \DOMDocument;

        libxml_use_internal_errors(true);

        $dom->loadHTML($ExternoQuestionAnswer->answer);

        $alternativa_final = $ExternoQuestionAnswer->answer;

        $xpath = new \DOMXPath($dom);
        $imgs = $xpath->query("//img");

        $src = "";
        for ($i=0; $i < $imgs->length; $i++) {
            $img = $imgs->item($i);
            $src = $img->getAttribute("src");
            $url_externa = 0;

            $src_remplazar = $src;

            //var_dump($src_remplazar);

            $src = explode("@@PLUGINFILE@@/", $src);
            
            if(count($src) < 2){
                $url_externa = 1;
            }

            if($url_externa == 0){

                $MdlilMoodleFiles = MdlilMoodleFiles::findOne(['filename'=>urldecode($src[1])]);

                if(!$MdlilMoodleFiles){
                    $src = explode("?", $src[1]);
                
                    $src[1] = $src[0];
                
                    $MdlilMoodleFiles = MdlilMoodleFiles::findOne(['filename'=>urldecode($src[1])]);
                }

                $MdlilMoodleQuestionAttempts =   MdlilMoodleQuestionAttempts::find()
                ->join('INNER JOIN','mdlil_question_attempt_steps','mdlil_question_attempt_steps.questionattemptid  = mdlil_question_attempts.id')
                ->where(['questionid'=>$MdlilMoodleQuestion->id,'mdlil_question_attempt_steps.userid'=>2])
                ->orderBy(['id'=>SORT_DESC])
                ->one();

                // construyo la url para llamar a la imagen

                $url = "/pluginfile.php/26/question/answer/" . $MdlilMoodleQuestionAttempts->questionusageid . "/" . $MdlilMoodleQuestionAttempts->slot . "/" . $ExternoQuestionAnswer->id . "/" . $src[1];

                $rut=  explode('-', Yii::$app->user->identity->rut);
                $uid = "csantibanez";
                $salt = "A4MLGJzlPWwJXSlMR5rOtYrywX59QKieDm9grS2m3jZtl6pbUSmP2hbmb0nvaamo";
                $fecha = 20200324;
                $hash = hash('sha512',$uid.$salt.$fecha); //Generacion de hash para validacion de seguridad
                
                $pdvOnlineToken=$hash;
                $pdvOnlineId=$uid;
                
                
                
                $url2 = 'https://moodle.desarrollos-csv.com/login/sso_v2.php?uid=' . $pdvOnlineId . '&shash=' .$pdvOnlineToken . '&link=' .$url;



                $opts = array(
                    'http'=>array(
                        'method'=>"GET",
                        
                        'header'=>"Accept-language: es\r\n" .
                                "Cookie: MoodleSession=$this->moodle_session\r\n"
                    )
                    );
                    
                $context = stream_context_create($opts);
                  
                  // Open the file using the HTTP headers set above
                  //$file = file_get_contents('http://www.example.com/', false, $context);

                //$imageData = file_get_contents($url2, false, $context);


                //$imageData = base64_encode(file_get_contents($url2, false, $context));

                // if(($src[1] == "image3025e89f74a.gif")){

                //     var_dump($QuizSlotsNuevo->slot);
                //     echo "<br>";
                //     var_dump($MdlilMoodleQuestion->id);
                //     echo "<br>";
                //     var_dump($url2);
                //     exit;
                // }

                try {
                    $imageData = base64_encode(file_get_contents($url2, false, $context));
                } catch (ErrorException $e) {



                    $MdlilMoodleFiles =   MdlilMoodleFiles::find()
                    ->where(['filename'=>$src[1]])
                    ->all(); 

                    if(count($MdlilMoodleFiles) == 0){
                        $src = explode("?", $src[1]);

                        $src[1] = $src[0];

                        $MdlilMoodleFiles =   MdlilMoodleFiles::find()

                        ->where(['filename'=>$src[1]])
                        ->all(); 

                    }

                    foreach ($MdlilMoodleFiles as $key => $value) {
                        // construyo la url para llamar a la imagen

                        $url = "/pluginfile.php/" . $value->contextid . "/question/questiontext/" . $MdlilMoodleQuestionAttempts->questionusageid . "/" . $MdlilMoodleQuestionAttempts->slot . "/" . $ExternoQuestions->id . "/" . $src[1];

                        $url2 = 'http://campus35.preupdvonline.cl/login/sso_v2.php?uid=' . $pdvOnlineId . '&shash=' .$pdvOnlineToken . '&link=' .$url;

                        try {
                            $imageData = base64_encode(file_get_contents($url2, false, $context));

                            break;

                        } catch (ErrorException $e) {



                        }

                    }


                }


            }else{

                $opts = array(
                    'http'=>array(
                      'method'=>"GET",
                      
                      'header'=>"Accept-language: es\r\n"
                    )
                  );
                  
                  $context = stream_context_create($opts);

                try {
                    $imageData = base64_encode(file_get_contents($src[0], false, $context));

                    break;

                } catch (ErrorException $e) {



                }

            }







            // obtengo el path de fullejercicios para crear la carpeta donde se guardará la imagen

            // $path_directorio = utf8_decode(Yii::getAlias('@fullEjercicios')."/web/cuestionarios2020/q" . $MdlilMoodleQuestion->id);

            // $this->creoDirectorios($path_directorio);

            // var_dump($imageData);

            $alternativa_final = str_replace($src_remplazar, 'data:;base64,'.$imageData, $alternativa_final);


            //echo "url : " . $url . "<br>";
            // exit;
        }


        return  $alternativa_final;

    }

    public function actionProcesarImagenesQuestion($MdlilMoodleQuestion)
    {

        $dom = new \DOMDocument;

        libxml_use_internal_errors(true);

        $dom->loadHTML($MdlilMoodleQuestion->questiontext);

        $texto_pregunta_final = $MdlilMoodleQuestion->questiontext;

        $xpath = new \DOMXPath($dom);
        $imgs = $xpath->query("//img");

        $src = "";
        for ($i=0; $i < $imgs->length; $i++) {
            $img = $imgs->item($i);
            $src = $img->getAttribute("src");

            // var_dump($src);
            // exit;

            // if(!($src == "@@PLUGINFILE@@/image0015c795914.jpg")){

            //     var_dump($src);
            //     exit;

            // }

            $url_externa = 0;

            $src_remplazar = $src;



            $src = explode("@@PLUGINFILE@@/", $src);



            
            if(count($src) < 2){
                $url_externa = 1;
            }





            if($url_externa == 0){

                $MdlilMoodleFiles = MdlilMoodleFiles::findOne(['filename'=>urldecode($src[1]),'component'=>'question']);






                if(!$MdlilMoodleFiles){
                    $src = explode("?", $src[1]);

                    $src[1] = $src[0];

                    $MdlilMoodleFiles = MdlilMoodleFiles::findOne(['filename'=>urldecode($src[1]),'component'=>'question']);
                }



                //$MdlilMoodleQuestionAttempts = MdlilMoodleQuestionAttempts::findOne(['questionid'=>$MdlilMoodleQuestion->id])->orderBy(['id'=>SORT_DESC]);
                $MdlilMoodleQuestionAttempts =   MdlilMoodleQuestionAttempts::find()

                                        ->where(['questionid'=>$MdlilMoodleQuestion->id])
                                        ->orderBy(['id'=>SORT_DESC])
                                        ->one(); 



                // construyo la url para llamar a la imagen



                // var_dump($MdlilMoodleQuestion);

                // var_dump($MdlilMoodleQuestionAttempts);

                // var_dump($MdlilMoodleFiles);
                // exit;


                // if(!($src[1] == "image0015e14e418.jpg" || $src[1] == "image0025e14e418.jpg" || $src[1] == "image0035e14e418.jpg" || $src[1] == "image0045e14e418.jpg" || $src[1] == "image0055e14e418.jpg" || $src[1] == "P12.jpg" || $src[1] == "P14.jpg" || $src[1] == "P16.jpg" || $src[1] == "P18.jpg")){
                    
                //     var_dump($MdlilMoodleFiles);
                //     var_dump($src[1]);

                //     var_dump($url);
                //     exit;

                // }


                $url = "/pluginfile.php/" . $MdlilMoodleFiles->contextid . "/question/questiontext/" . $MdlilMoodleQuestionAttempts->questionusageid . "/" . $MdlilMoodleQuestionAttempts->slot . "/" . $MdlilMoodleQuestion->id . "/" . $src[1];







                // $draftitemid = rand(1, 999999999);

                // $url = "https://campus35.preupdvonline.cl/draftfile.php/175/user/draft/" . $draftitemid . "/" . $src[1];

                //var_dump($MdlilMoodleFiles);

                // var_dump($MdlilMoodleQuestion);

                // var_dump($QuizSlotsNuevo);
                
                // var_dump($ExternoMdl35CourseModule);




                $rut=  explode('-', Yii::$app->user->identity->rut);
                $uid = "csantibanez";
                $salt = "A4MLGJzlPWwJXSlMR5rOtYrywX59QKieDm9grS2m3jZtl6pbUSmP2hbmb0nvaamo";
                $fecha = 20200324;
                $hash = hash('sha512',$uid.$salt.$fecha); //Generacion de hash para validacion de seguridad




                $url2 = 'https://moodle.desarrollos-csv.com/login/sso_v2.php?uid=' . $uid . '&shash=' .$hash . '&link=' .$url;


                $opts = array(
                    'http'=>array(
                        'method'=>"GET",
                        
                        'header'=>"Accept-language: es\r\n" .
                                "Cookie: MoodleSession=$this->moodle_session\r\n"
                    )
                );
                    
                $context = stream_context_create($opts);
                    
                    // Open the file using the HTTP headers set above
                    //$file = file_get_contents('http://www.example.com/', false, $context);

                //$imageData = file_get_contents($url2, false, $context);


                //$imageData = base64_encode(file_get_contents($url2, false, $context));



                try {
                    $imageData = base64_encode(file_get_contents($url2, false, $context));


                } catch (ErrorException $e) {
                    $MdlilMoodleFiles =   MdlilMoodleFiles::find()

                    ->where(['filename'=>$src[1]])
                    ->all(); 

                    if(count($MdlilMoodleFiles) == 0){
                        $src = explode("?", $src[1]);

                        $src[1] = $src[0];

                        $MdlilMoodleFiles =   MdlilMoodleFiles::find()

                        ->where(['filename'=>$src[1]])
                        ->all(); 

                    }

                    foreach ($MdlilMoodleFiles as $key => $value) {
                        // construyo la url para llamar a la imagen

                        $url = "/pluginfile.php/" . $value->contextid . "/question/questiontext/" . $MdlilMoodleQuestionAttempts->questionusageid . "/" . $MdlilMoodleQuestionAttempts->slot . "/" . $MdlilMoodleQuestion->id . "/" . $src[1];

                        $url2 = 'http://campus35.preupdvonline.cl/login/sso_v2.php?uid=' . $pdvOnlineId . '&shash=' .$pdvOnlineToken . '&link=' .$url;

                        try {
                            $imageData = base64_encode(file_get_contents($url2, false, $context));

                            break;

                        } catch (ErrorException $e) {



                        }

                    }


                }



            }else{

                $opts = array(
                    'http'=>array(
                        'method'=>"GET",
                        
                        'header'=>"Accept-language: es\r\n"
                    )
                    );
                    
                    $context = stream_context_create($opts);

                try {
                    $imageData = base64_encode(file_get_contents($src[0], false, $context));

                    break;

                } catch (ErrorException $e) {



                }

            }

            // var_dump($MdlilMoodleQuestion);

            // var_dump($MdlilMoodleQuestionAttempts);

            // var_dump($MdlilMoodleFiles);
            // exit;

            // obtengo el path de fullejercicios para crear la carpeta donde se guardará la imagen

            // $path_directorio = utf8_decode(Yii::getAlias('@fullEjercicios')."/web/cuestionarios2020/q" . $MdlilMoodleQuestion->id);

            // $this->creoDirectorios($path_directorio);

            // var_dump($imageData);

            $texto_pregunta_final = str_replace($src_remplazar, 'data:;base64,'.$imageData, $texto_pregunta_final);


            //echo "url : " . $url . "<br>";
            // exit;
        }

        return  $texto_pregunta_final;

    }
    
    public function actionSincronizarSolucionarioTeorico()
    {

        $this->moodle_session = Yii::$app->request->post('id_moodle');

        $status = 0;
        $cantidad_errores = 0;
        $cantidad_errores_solucionario_t = 0;
        $cantidad_errores_preguntas_solucionario_t = 0;
        $cantidad_errores_alternativas_solucionario_t = 0;
        // busco el modelo de la prueba

            $Prueba = Prueba::findOne(Yii::$app->request->post('id_prueba'));

        // Veo si la prueba tiene un id de solucionario teorico

            if ($Prueba->solucionario_teorico_id) {
                // Creamos un contador para los errores


                $MdlilMoodleCourseModule = MdlilMoodleCourseModule::find()
                ->select('mdlil_quiz.id')
                // ->select(' mdl_course_modules.id AS cm_id,     mdl_course_modules.module,    mdl_course_modules.instance')

                ->where(['mdlil_course_modules.id'=>$Prueba->solucionario_teorico_id])
                ->join('LEFT JOIN','mdlil_quiz','mdlil_quiz.id =mdlil_course_modules.instance')
                ->asArray()
                
                ->one();




                $MdlilQuizQuestionInstancesDelete = MdlilQuizQuestionInstances::find()->where(['quiz'=>$Prueba->externo_id])->All();




                foreach ($MdlilQuizQuestionInstancesDelete as $key => $MdlQuizQuestionInstanceDelete) {
                    $MdlQuizQuestionInstanceDelete->delete();
                }


                $MdlilMoodleQuizSlots = MdlilMoodleQuizSlots::find()->where(['quizid'=>$MdlilMoodleCourseModule['id']])->All();
                
                

                foreach ($ExternoQuizSlotsNuevo as $key => $QuizSlotsNuevo) {

                    // Consulto si existe la instancia
                    $MdlilQuizQuestionInstances = MdlilQuizQuestionInstances::findOne(['question'=>(int)$QuizSlotsNuevo->questionid,'quiz'=>$Prueba->externo_id,'anio_id'=>Yii::$app->user->identity->anio_predeterminado]);


                    // si no existe la creo
                        if(!$MdlilQuizQuestionInstances){



                            $MdlilQuizQuestionInstances=new MdlilQuizQuestionInstances;

                            $MdlilQuizQuestionInstances->mencion           = null;
                            $MdlilQuizQuestionInstances->quiz              = $Prueba->externo_id;

                        }

                    $MdlilQuizQuestionInstances->numero_pregunta   = $QuizSlotsNuevo->slot;
                    $MdlilQuizQuestionInstances->question          = (int)$QuizSlotsNuevo->questionid;
                    $MdlilQuizQuestionInstances->anio_id          = Yii::$app->user->identity->anio_predeterminado;



                    if($MdlilQuizQuestionInstances->save()){



                        // Realizo el select de las preguntas
                        $MdlilMoodleQuestion = MdlilMoodleQuestion::findOne((int)$MdlilQuizQuestionInstances->question);



                        // busco si existe en nuestra base
                        $MdlilQuestion = MdlilQuestion::findOne((int)$MdlilQuizQuestionInstances->question);





                        $MdlilMoodleQuestion->questiontext = $this->actionProcesarImagenesQuestion($MdlilMoodleQuestion);


                        //exit;
                        
                        //echo $src;

                        // $imgs = $dom->query("//img");
                        // for ($i=0; $i < $imgs->length; $i++) {
                        //     $img = $imgs->item($i);
                        //     $src = $img->getAttribute("src");

                        //     echo "src : " . $src . "<br>";


                        // }
                        // $scraped_img = $src;

                        // var_dump($MdlilMoodleQuestion->questiontext);
                        // // var_dump($MdlilQuizQuestionInstances->question);

                        // echo "<br><br><br>";

                        $imgs ="";
                        
                        // if($imgs->length >= 1){
                        //     var_dump($MdlilMoodleQuestion->questiontext);
                        //     exit;
                        // }


                        

                        // Si no existe la creo
                        if(!$MdlilQuestion){
                            $MdlilQuestion=new MdlilQuestion;
                        }
                        $MdlilQuestion->id                    = $MdlilMoodleQuestion->id;
                        $MdlilQuestion->category              = $MdlilMoodleQuestion->category ;
                        $MdlilQuestion->parent                = $MdlilMoodleQuestion->parent;
                        $MdlilQuestion->name                  = $MdlilMoodleQuestion->name;
                        $MdlilQuestion->questiontext          = $MdlilMoodleQuestion->questiontext;
                        $MdlilQuestion->questiontextformat    = $MdlilMoodleQuestion->questiontextformat;
                        $MdlilQuestion->generalfeedback       = $MdlilMoodleQuestion->generalfeedback;
                        $MdlilQuestion->generalfeedbackformat = $MdlilMoodleQuestion->generalfeedbackformat;
                        $MdlilQuestion->defaultmark           = $MdlilMoodleQuestion->defaultmark;
                        $MdlilQuestion->penalty               = $MdlilMoodleQuestion->penalty;
                        $MdlilQuestion->qtype                 = $MdlilMoodleQuestion->qtype;
                        $MdlilQuestion->length1               = $MdlilMoodleQuestion->length;
                        $MdlilQuestion->stamp                 = $MdlilMoodleQuestion->stamp;
                        $MdlilQuestion->version1              = $MdlilMoodleQuestion->version;
                        $MdlilQuestion->hidden                = $MdlilMoodleQuestion->hidden;
                        $MdlilQuestion->timecreated           = $MdlilMoodleQuestion->timecreated;
                        $MdlilQuestion->timemodified          = $MdlilMoodleQuestion->timemodified;
                        $MdlilQuestion->createdby             = $MdlilMoodleQuestion->createdby;
                        $MdlilQuestion->modifiedby            = $MdlilMoodleQuestion->modifiedby;                                   

                        $MdlilQuestion->migrado              = 1;
                        $MdlilQuestion->reparar_imagenes      = null;

                        

                        if($MdlilQuestion->save()){

                            $MdlilMoodleQuestionAnswers =   MdlilMoodleQuestionAnswers::find()
                                                    ->select('*')
                                                    ->where(['question' => (int)$MdlilQuestion->id])
                                                    ->all(); 



                            $i_alternativa = 0;
                            $correcta= 0;
                            foreach($MdlilMoodleQuestionAnswers as $ExternoQuestionAnswer){


                                $MdlilQuestionAnswers = MdlilQuestionAnswers::findOne($ExternoQuestionAnswer->id);

                                // if($imgs->length >= 1){
                                //     var_dump($ExternoQuestionAnswer->id);
                                //     exit;
                                // }

                                $ExternoQuestionAnswer->answer = $this->actionProcesarImagenesAnswer($ExternoQuestionAnswer,$MdlilMoodleQuestion,$QuizSlotsNuevo);



                                // Si no existe la creo
                                if(!$MdlilQuestionAnswers){
                                    $MdlilQuestionAnswers=new MdlilQuestionAnswers;
                                }
                                $MdlilQuestionAnswers->id                     = $ExternoQuestionAnswer->id;
                                $MdlilQuestionAnswers->question               = $ExternoQuestionAnswer->question  ;
                                $MdlilQuestionAnswers->answer                 = $ExternoQuestionAnswer->answer;
                                $MdlilQuestionAnswers->fraction           = $ExternoQuestionAnswer->fraction;
                                $MdlilQuestionAnswers->feedback           = $ExternoQuestionAnswer->feedback;
                                $MdlilQuestionAnswers->migrado           = 1;
                                $MdlilQuestionAnswers->reparar_imagenes   = null;



                                if($MdlilQuestionAnswers->save()){
                                    if ($MdlilQuestionAnswers->fraction == 1) {
                                        $correcta = $i_alternativa;
                                    }

                                    $i_alternativa++;


                                }else{
                                    $cantidad_errores++;
                                    $cantidad_errores_alternativas++;
                                    // En caso de que no se guarde la pregunta

                                        $datos = "";
                                        $errores = 0;
                                        foreach ($MdlilQuestionAnswers->getErrors() as $errors) {
                                            foreach ($errors as $error) {
                                                if ($error != ''){
                                                    $errores++;
                                                    $datos .= "<tr>";
                                                    //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                                    $datos .= "<td><div title=\"nombre\" class=\"nombre_div\"></div></td>";
                                                    $datos .= "<td>".$error."</td>";
                                                    $datos .= "</tr>";
                                                }
                                            }
                                        }

                                        var_dump($datos);
                                }

                            }

                            // Guardo la respuesta correcta en la tabla de pauta PruebaPauta
                            // Tomo el número de pregunta de $MdlilQuizQuestionInstances->numero_pregunta

                            // Busco si ya exoste la pauta




                            if ($Prueba->migrar_pauta == 1) {

                                $PruebaPauta = PruebaPauta::findOne(['prueba_id' => $Prueba->id,'numero_pregunta'=>$MdlilQuizQuestionInstances->numero_pregunta,'activo'=>1]);

                                if (!$PruebaPauta) {
                                    $PruebaPauta = new PruebaPauta;
                                    $PruebaPauta->creado_por = Yii::$app->user->identity->id;
                                    $PruebaPauta->prueba_id = $Prueba->id;
                                    $PruebaPauta->numero_pregunta = $MdlilQuizQuestionInstances->numero_pregunta;
                                }else{
                                    $PruebaPauta->modificado_por = Yii::$app->user->identity->id;
                                }

                                $PruebaPauta->correcta = $alternativas[$correcta];

                                if ($PruebaPauta->save()) {
                                    # code...
                                }else{
                                    $cantidad_errores++;
                                    $cantidad_errores_preguntas++;
                                    // En caso de que no se guarde la pregunta

                                        $datos = "";
                                        $errores = 0;
                                        foreach ($MdlilQuestion->getErrors() as $errors) {
                                            foreach ($errors as $error) {
                                                if ($error != ''){
                                                    $errores++;
                                                    $datos .= "<tr>";
                                                    //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                                    $datos .= "<td><div title=\"nombre\" class=\"nombre_div\"></div></td>";
                                                    $datos .= "<td>".$error."</td>";
                                                    $datos .= "</tr>";
                                                }
                                            }
                                        }

                                        var_dump($datos);
                                }

                            }




                        }else{

                        }




                    }else{
                        $cantidad_errores++;
                        $cantidad_errores_prueba++;

                        $errors = "";
                        $errores = 0;
                        $datos = "";

                        // print_r($model->getErrors());
                        // exit;
                        foreach ($MdlilQuizQuestionInstances->getErrors() as $errors) {
                            foreach ($errors as $error) {
                                if ($error != ''){
                                    $errores++;
                                    $datos .= "<tr>";
                                    //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                                    $datos .= "<td><div title=\"nombre\" class=\"nombre_div\">{$MdlilQuizQuestionInstances->question}</div></td>";
                                    $datos .= "<td>".$error."</td>";
                                    $datos .= "</tr>";
                                }
                            }
                        }

                        var_dump($datos);

                    }                        

 
                }





            }



        $status_errores_alinear = 0;
        // Recorro las preguntas que neesiten alinearce
            $MdlilQuestion =   MdlilQuestion::find()
                                    ->select('*')
                                    ->where(['reparar_imagenes' => null])
                                    ->all(); 

            foreach ($MdlilQuestion as $MdlilQuestion) {
                $MdlilQuestion->questiontext            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestion->questiontext);
                $MdlilQuestion->reparar_imagenes  = 1;

                if($MdlilQuestion->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

        // Recorro las alternativas que neesiten alinearce
            $MdlilQuestionAnswers =   MdlilQuestionAnswers::find()
                                    ->select('*')
                                    ->where(['reparar_imagenes' => null])
                                    ->all(); 

            foreach ($MdlilQuestionAnswers as $MdlilQuestionAnswer) {
                $MdlilQuestionAnswer->answer            = str_replace('style="vertical-align:text-bottom;"', 'style="vertical-align:text-top;"', $MdlilQuestionAnswer->answer);
                $MdlilQuestionAnswer->reparar_imagenes  = 1;
                
                if($MdlilQuestionAnswer->save()){

                }else{
                    $cantidad_errores++;
                    $status_errores_alinear++;
                }
            }

        if($cantidad_errores == 0){
            
            $Prueba->migrar = null;
            $Prueba->migrar_pauta = null;
            if ($Prueba->save()) {
                $status = 1;
            }else{
                // exit;
                foreach ($Prueba->getErrors() as $errors) {
                    foreach ($errors as $error) {
                        if ($error != ''){
                            $errores++;
                            $datos .= "<tr>";
                            //Yii::app()->user->setFlash('error', GxHtml::encode($error));
                            $datos .= "<td><div title=\"nombre\" class=\"nombre_div\"></div></td>";
                            $datos .= "<td>".$error."</td>";
                            $datos .= "</tr>";
                        }
                    }
                }

                var_dump($datos);
            }
        }


        return Json::encode(['cantidad_errores_solucionario_t'=>$cantidad_errores_solucionario_t,'cantidad_errores_preguntas_solucionario_t'=>$cantidad_errores_preguntas_solucionario_t,'cantidad_errores_alternativas_solucionario_t'=>$cantidad_errores_alternativas_solucionario_t,'status'=>$status,'id_prueba'=>Yii::$app->request->post('id_prueba')]);

    }

}
