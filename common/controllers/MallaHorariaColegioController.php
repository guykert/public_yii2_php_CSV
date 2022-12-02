<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\MallaHorariaColegio;
use common\models\search\MallaHorariaColegio as MallaHorariaColegioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\MallaHorariaColegioBloque;
use common\models\Dia;
use common\models\Bloque;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\widgets\ActiveForm;

/**
 * MallaHorariaColegioController Implementa las acciones del CRUD para el modeloMallaHorariaColegio .
 * */ 
class MallaHorariaColegioController extends Controller
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
                        'actions' => ['index','create','update','delete','view','guardarbloque'],
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
                        'actions' => ['index','create','update','delete','view','guardarbloque'],
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

    public function actionIndex()
    {
        /**
        * Lista todo el modelo MallaHorariaColegio. 
        * no hay variable de retorno
        */
        $searchModel = new MallaHorariaColegioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/malla-horaria-colegio/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {



        $MallaHorariaColegioBloque = new MallaHorariaColegioBloque();


        $dias = Dia::getDiasActivos();



        $bloques = Bloque::getBloquesActivos();

        $MatrizDatos = MallaHorariaColegioBloque::getMatrizDatos($id);



        $confirmacion = MallaHorariaColegioBloque::getConfirmacionActiva($id);




        $MatrizDatosMapa = ArrayHelper::map($MatrizDatos, 'dia_id', 'id','bloque');




        /**
        * Muestra un modelo único MallaHorariaColegio. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/malla-horaria-colegio/view', [
            'model' => $this->findModel($id),
            'MallaHorariaColegioBloque' => $MallaHorariaColegioBloque,
            'dias' => $dias,
            'bloques' => $bloques,
            'MatrizDatos' => $MatrizDatos,
            'confirmacion' => $confirmacion,
            'MatrizDatosMapa' => $MatrizDatosMapa,

        ]);
    }

    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo MallaHorariaColegio.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new MallaHorariaColegio();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        $model->anio_id = Yii::$app->user->identity->anio_predeterminado;
        $model->colegio_id = Yii::$app->user->identity->colegio_predeterminada;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/malla-horaria-colegio/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente MallaHorariaColegio.
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
            return $this->render('@common/views/malla-horaria-colegio/update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        /**
        * Elimina un modelo existente  MallaHorariaColegio.
        * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" . 
        * @param integer $id
        * no tiene variable de retorno 
        */

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        /**
        * Busca el modelo MallaHorariaColegio en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return MallaHorariaColegio el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = MallaHorariaColegio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionGuardarbloque()
    {

        $bloques = Bloque::getBloquesActivos();
        $dias = Dia::getDiasActivos();


        if((Yii::$app->request->post('semana') || Yii::$app->request->post('semana_sabado'))){
            if((Yii::$app->request->post('semana_sabado'))){
                foreach ($dias as $dia) {
                    $MallaHorariaColegioBloque = MallaHorariaColegioBloque::find()
                            ->where(['activo' => 1,'bloque' => Yii::$app->request->post('bloque'),'dia_id' => $dia->id,'maya_horaria_id' => Yii::$app->request->post('malla_horaria_id')])->one();

                    if(!$MallaHorariaColegioBloque){
                        $MallaHorariaColegioBloque = new MallaHorariaColegioBloque();
                        $MallaHorariaColegioBloque->dia_id = $dia->id; 
                        $MallaHorariaColegioBloque->bloque = Yii::$app->request->post('bloque');
                        $MallaHorariaColegioBloque->creado_por = Yii::$app->user->identity->id;
                        $MallaHorariaColegioBloque->maya_horaria_id = Yii::$app->request->post('malla_horaria_id');
                        $MallaHorariaColegioBloque->fecha_creacion = date("Y-m-d H:i:s");
                        $MallaHorariaColegioBloque->activo = 1;

                    }else{
                        $MallaHorariaColegioBloque->modificado_por = Yii::$app->user->identity->id;
                        $MallaHorariaColegioBloque->fecha_modificacion = date("Y-m-d H:i:s");
                    }

                    $hora_desde = Yii::$app->request->post('hora_desde');  

                    if($hora_desde){
                        $MallaHorariaColegioBloque->hora_desde = date('Y-m-d H:i:s', strtotime($hora_desde));

                        $fecha_alerta2 =  (new \DateTime($MallaHorariaColegioBloque->hora_desde));

                        $fecha_alerta2 = date_modify($fecha_alerta2, '+80 minutes');

                        $MallaHorariaColegioBloque->hora_hasta = date('Y-m-d H:i:s', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));
                    }
                        $MallaHorariaColegioBloque2 = MallaHorariaColegioBloque::find()->where(['activo' => 1,'dia_id' => $dia->id])->orderBy(['bloque'=>SORT_DESC])->select(['bloque','dia_id','hora_hasta'])->one();
                        

                         if($MallaHorariaColegioBloque2){

                            $hora_hasta = date('H:i', strtotime($MallaHorariaColegioBloque2->hora_hasta));
                            $hora_desdes = date('H:i', strtotime($MallaHorariaColegioBloque->hora_desde));
                            


                            if(isset($MallaHorariaColegioBloque2)){
                                 
                                if($MallaHorariaColegioBloque->dia_id == $MallaHorariaColegioBloque2->dia_id && $MallaHorariaColegioBloque->bloque > $MallaHorariaColegioBloque2->bloque && $hora_desdes < $hora_hasta){
                                     return Json::encode(['status'=>0, 'validacion'=>ActiveForm::validate($MallaHorariaColegioBloque) ]);
                                }else{
                                        $MallaHorariaColegioBloque->save();
                                }
                            }else{
                                 $MallaHorariaColegioBloque->save();
                                       
                            }

                         }else{
                            $MallaHorariaColegioBloque->save();
                         }
           
                            
                }
                     $dato_mostrar_boton = date('H:i', strtotime($hora_desde)) . ' a ' . date('H:i', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));
                     return Json::encode(['status'=>1,'dato_mostrar_boton'=>$dato_mostrar_boton,'semana'=>0,'semana_sabado'=>1]);
            }else{
                foreach ($dias as $dia) {
                    if($dia->id != 6){
                        $MallaHorariaColegioBloque = MallaHorariaColegioBloque::find()
                                ->where(['activo' => 1,'bloque' => Yii::$app->request->post('bloque'),'dia_id' => $dia->id,'maya_horaria_id' => Yii::$app->request->post('malla_horaria_id')])->one();

                        if(!$MallaHorariaColegioBloque){
                            $MallaHorariaColegioBloque = new MallaHorariaColegioBloque();
                            $MallaHorariaColegioBloque->dia_id = $dia->id; 
                            $MallaHorariaColegioBloque->bloque = Yii::$app->request->post('bloque'); 
                            $MallaHorariaColegioBloque->creado_por = Yii::$app->user->identity->id;
                            $MallaHorariaColegioBloque->maya_horaria_id = Yii::$app->request->post('malla_horaria_id');
                            $MallaHorariaColegioBloque->fecha_creacion = date("Y-m-d H:i:s");
                            $MallaHorariaColegioBloque->activo = 1;

                        }else{
                            $MallaHorariaColegioBloque->modificado_por = Yii::$app->user->identity->id;
                            $MallaHorariaColegioBloque->fecha_modificacion = date("Y-m-d H:i:s");
                        }

                        $hora_desde = Yii::$app->request->post('hora_desde');  

                        if($hora_desde){
                            $MallaHorariaColegioBloque->hora_desde = date('Y-m-d H:i:s', strtotime($hora_desde));

                            $fecha_alerta2 =  (new \DateTime($MallaHorariaColegioBloque->hora_desde));

                            $fecha_alerta2 = date_modify($fecha_alerta2, '+80 minutes');

                            $MallaHorariaColegioBloque->hora_hasta = date('Y-m-d H:i:s', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));
                        }

                         $MallaHorariaColegioBloque2 = MallaHorariaColegioBloque::find()->where(['activo' => 1,'dia_id' => $dia->id])->orderBy(['bloque'=>SORT_DESC])->select(['bloque','dia_id','hora_hasta'])->one();
                       
                         if($MallaHorariaColegioBloque2){

                            $hora_hasta = date('H:i', strtotime($MallaHorariaColegioBloque2->hora_hasta));
                            $hora_desdes = date('H:i', strtotime($MallaHorariaColegioBloque->hora_desde));


                            if(isset($MallaHorariaColegioBloque2)){
                                 
                                if($MallaHorariaColegioBloque->dia_id == $MallaHorariaColegioBloque2->dia_id && $MallaHorariaColegioBloque->bloque > $MallaHorariaColegioBloque2->bloque && $hora_desdes < $hora_hasta){
                                     return Json::encode(['status'=>0, 'validacion'=>ActiveForm::validate($MallaHorariaColegioBloque) ]);
                                }else{
                                        $MallaHorariaColegioBloque->save();
                                }
                            }else{
                                 $MallaHorariaColegioBloque->save();
                                       
                            }

                         }else{
                            $MallaHorariaColegioBloque->save();
                         }


                    }

                }
                $dato_mostrar_boton = date('H:i', strtotime($hora_desde)) . ' a ' . date('H:i', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));
                return Json::encode(['status'=>1,'bloque' => Yii::$app->request->post('bloque'),'dato_mostrar_boton'=>$dato_mostrar_boton,'semana'=>1,'semana_sabado'=>0]);
            }
        }else{


    

            $MallaHorariaColegioBloque = MallaHorariaColegioBloque::find()
                    ->where(['activo' => 1,'bloque' => Yii::$app->request->post('bloque'),'dia_id' => Yii::$app->request->post('dia_id'),'maya_horaria_id' => Yii::$app->request->post('malla_horaria_id')])->one();


               
            if(!$MallaHorariaColegioBloque){
                $MallaHorariaColegioBloque = new MallaHorariaColegioBloque();
                $MallaHorariaColegioBloque->dia_id = Yii::$app->request->post('dia_id'); 
                $MallaHorariaColegioBloque->bloque = Yii::$app->request->post('bloque');
                $MallaHorariaColegioBloque->creado_por = Yii::$app->user->identity->id;
                $MallaHorariaColegioBloque->maya_horaria_id = Yii::$app->request->post('malla_horaria_id');
                $MallaHorariaColegioBloque->fecha_creacion = date("Y-m-d H:i:s");
                $MallaHorariaColegioBloque->activo = 1;

            }else{
                $MallaHorariaColegioBloque->modificado_por = Yii::$app->user->identity->id;
                $MallaHorariaColegioBloque->fecha_modificacion = date("Y-m-d H:i:s");
            }

            $hora_desde = Yii::$app->request->post('hora_desde');  

            if($hora_desde){
                $MallaHorariaColegioBloque->hora_desde = date('Y-m-d H:i:s', strtotime($hora_desde));

                $fecha_alerta2 =  (new \DateTime($MallaHorariaColegioBloque->hora_desde));

                $fecha_alerta2 = date_modify($fecha_alerta2, '+80 minutes');

                $MallaHorariaColegioBloque->hora_hasta = date('Y-m-d H:i:s', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));

            }

            $MallaHorariaColegioBloque2 = MallaHorariaColegioBloque::find()->where(['activo' => 1, 'dia_id' => Yii::$app->request->post('dia_id')])->orderBy(['bloque'=>SORT_DESC])->select(['bloque','dia_id','hora_desde','hora_hasta'])->one();
                


            if($MallaHorariaColegioBloque2){

                $horas_desde = date('H:i', strtotime($MallaHorariaColegioBloque2->hora_desde));
                $hora_desdes = date('H:i', strtotime($MallaHorariaColegioBloque->hora_desde));
                $horas_hasta = date('H:i', strtotime($MallaHorariaColegioBloque2->hora_hasta));


          
                if($MallaHorariaColegioBloque->dia_id == $MallaHorariaColegioBloque2->dia_id && $MallaHorariaColegioBloque->bloque > $MallaHorariaColegioBloque2->bloque && $hora_desdes < $horas_hasta  )
                {       

                     return Json::encode(['hora_desde'=>$MallaHorariaColegioBloque->hora_hasta,'dia_id'=>$MallaHorariaColegioBloque->dia_id,'status'=>0, 'validacion'=>ActiveForm::validate($MallaHorariaColegioBloque) ]);
                   

                }else{

                    if ($MallaHorariaColegioBloque->save()) {
                        $dato_mostrar_boton = date('H:i', strtotime($hora_desde)) . ' a ' . date('H:i', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));
                        return Json::encode(['status'=>1,'dato_mostrar_boton'=>$dato_mostrar_boton,'semana'=>0,'semana_sabado'=>0]);
                
                    }else {
                        return Json::encode(['hora_desde'=>$MallaHorariaColegioBloque->hora_hasta,'dia_id'=>$MallaHorariaColegioBloque->dia_id,'status'=>0, 'validacion'=>ActiveForm::validate($MallaHorariaColegioBloque) ]);
                    }
                }

            }else{

                    if ($MallaHorariaColegioBloque->save()) {
                        $dato_mostrar_boton = date('H:i', strtotime($hora_desde)) . ' a ' . date('H:i', strtotime($fecha_alerta2->format('Y-m-d H:i:s')));
                        return Json::encode(['status'=>1,'dato_mostrar_boton'=>$dato_mostrar_boton,'semana'=>0,'semana_sabado'=>0]);
                
                    }else {
                        return Json::encode(['hora_desde'=>$MallaHorariaColegioBloque->hora_hasta,'dia_id'=>$MallaHorariaColegioBloque->dia_id,'status'=>0, 'validacion'=>ActiveForm::validate($MallaHorariaColegioBloque) ]);
                    }

            }

               


        }

    }

}
