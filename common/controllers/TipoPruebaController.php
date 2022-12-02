<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\TipoPrueba;
use common\models\search\TipoPrueba as TipoPruebaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;

/**
 * TipoPruebaController Implementa las acciones del CRUD para el modeloTipoPrueba .
 * */ 
class TipoPruebaController extends Controller
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
        * Lista todo el modelo TipoPrueba. 
        * no hay variable de retorno
        */
        $searchModel = new TipoPruebaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/tipo-prueba/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único TipoPrueba. 
        * @param string $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/tipo-prueba/view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo TipoPrueba.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new TipoPrueba();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/tipo-prueba/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente TipoPrueba.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param string $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/tipo-prueba/update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        /**
        * Elimina un modelo existente  TipoPrueba.
        * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" . 
        * @param string $id
        * no tiene variable de retorno 
        */

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    protected function findModel($id)
    {
        /**
        * Busca el modelo TipoPrueba en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param string $id
        * @return TipoPrueba el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = TipoPrueba::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
