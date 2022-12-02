<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\PruebaTablaConversion;
use common\models\search\PruebaTablaConversion as PruebaTablaConversionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\PruebaTablaConversionDetalle;
use yii\base\Model;

/**
 * PruebaTablaConversionController Implementa las acciones del CRUD para el modeloPruebaTablaConversion .
 * */ 
class PruebaTablaConversionController extends Controller
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
                        'actions' => ['index','create','update','delete','view'],
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
                        'actions' => ['index','create','update','delete','view'],
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
        * Lista todo el modelo PruebaTablaConversion. 
        * no hay variable de retorno
        */
        $searchModel = new PruebaTablaConversionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/prueba-tabla-conversion/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {

        for($i = 1; $i <= 80; $i++) {

            $PruebaTablaConversionDetalle_guardado = PruebaTablaConversionDetalle::find()->where(['tabla_conversion_id'=>$id,'preguntas_correctas'=>$i])->one();  

            if(!$PruebaTablaConversionDetalle_guardado){
                $PruebaTablaConversionDetalle[] = new PruebaTablaConversionDetalle();
            }else{
                $PruebaTablaConversionDetalle[] = $PruebaTablaConversionDetalle_guardado;
            }
            

        }

        if (Model::loadMultiple($PruebaTablaConversionDetalle, Yii::$app->request->post())) {



            $error = false;
            foreach ($PruebaTablaConversionDetalle as &$PruebaTablaConversionDetall) {

                $PruebaTablaConversionDetalle_guardado = PruebaTablaConversionDetalle::find()->where(['tabla_conversion_id'=>$id,'preguntas_correctas'=>$PruebaTablaConversionDetall->preguntas_correctas])->one();  

                if($PruebaTablaConversionDetalle_guardado){

                    $PruebaTablaConversionDetalle_guardado->preguntas_correctas = $PruebaTablaConversionDetall->puntaje;
                    $PruebaTablaConversionDetalle_guardado->modificado_por = Yii::$app->user->identity->id;
                    $PruebaTablaConversionDetalle_guardado->preguntas_correctas = (int)$PruebaTablaConversionDetall->preguntas_correctas;
                    $PruebaTablaConversionDetall = $PruebaTablaConversionDetalle_guardado;
                    $PruebaTablaConversionDetall->activo = 1;

                }else{
                    $PruebaTablaConversionDetall->puntaje = $PruebaTablaConversionDetall->puntaje;
                    $PruebaTablaConversionDetall->tabla_conversion_id = $id;
                    $PruebaTablaConversionDetall->creado_por = Yii::$app->user->identity->id;
                }



                if($PruebaTablaConversionDetall->puntaje > 0){


                    if (!$PruebaTablaConversionDetall->save()) {

                        $error = true;
                        break;
                    }
                }




            }

            if (!$error) {
                return $this->redirect(['index'
                ]);
            }else{

                return $this->render('@common/views/prueba-tabla-conversion/view', [
                    'model' => $this->findModel($id),
                    'PruebaConversionDetalle' => $PruebaTablaConversionDetalle,
                ]); 

            }
        
        }else{


            return $this->render('@common/views/prueba-tabla-conversion/view', [
                'model' => $this->findModel($id),
                'PruebaConversionDetalle' => $PruebaTablaConversionDetalle,
            ]);
        }



    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo PruebaTablaConversion.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new PruebaTablaConversion();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/prueba-tabla-conversion/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente PruebaTablaConversion.
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
            return $this->render('@common/views/prueba-tabla-conversion/update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        /**
        * Elimina un modelo existente  PruebaTablaConversion.
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
        * Busca el modelo PruebaTablaConversion en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return PruebaTablaConversion el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = PruebaTablaConversion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
