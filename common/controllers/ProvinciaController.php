<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Provincia;
use common\models\search\Provincia as ProvinciaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;

/**
 * ProvinciaController Implementa las acciones del CRUD para el modeloProvincia .
 * */ 
class ProvinciaController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
    public $tituloAyuda='AYUDA INDEX';

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','create','update','delete'],

                //esto permite definir una determinada acción en caso de que no se cumplan las reglas
                // lo dejare comentado para ver si posteriormente sirve en algún caso particular
                // 'denyCallback' => function ($rule, $action) {
                //     //Esta es la acción a ejecutar en caso de que no se cumplan las reglas

                //     throw new \Exception('error');
                // },
                'rules' => [
                    [
                        'actions' => ['index','create','update','delete','guias'],
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
                        'actions' => ['index','create','update','delete','guias'],
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
        * Lista todo el modelo Provincia. 
        * no hay variable de retorno
        */
        $searchModel = new ProvinciaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/provincia/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Provincia. 
        * @param string $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/provincia/view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo Provincia.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Provincia();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/provincia/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Provincia.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param string $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
         /* toma el id del usuario que está logeado*/
          $model->modificado_por = Yii::$app->user->identity->id ;     
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/provincia/update', [
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
        * Busca el modelo Provincia en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param string $id
        * @return Provincia el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Provincia::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
