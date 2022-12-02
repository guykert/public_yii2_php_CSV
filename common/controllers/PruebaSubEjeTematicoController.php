<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\PruebaSubEjeTematico;
use common\models\search\PruebaSubEjeTematico as PruebaSubEjeTematicoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\components\select\EjeTematicoComponent;

/**
 * PruebaSubEjeTematicoController Implementa las acciones del CRUD para el modeloPruebaSubEjeTematico .
 * */ 
class PruebaSubEjeTematicoController extends Controller
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
                        'actions' => ['index','create','update','delete','view','eje-tematico'],
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
                        'actions' => ['index','create','update','delete','view','eje-tematico'],
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
        * Lista todo el modelo PruebaSubEjeTematico. 
        * no hay variable de retorno
        */
        $searchModel = new PruebaSubEjeTematicoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/prueba-sub-eje-tematico/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único PruebaSubEjeTematico. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/prueba-sub-eje-tematico/view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo PruebaSubEjeTematico.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new PruebaSubEjeTematico();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/prueba-sub-eje-tematico/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente PruebaSubEjeTematico.
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
            return $this->render('@common/views/prueba-sub-eje-tematico/update', [
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
        * Busca el modelo PruebaSubEjeTematico en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return PruebaSubEjeTematico el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = PruebaSubEjeTematico::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEjeTematico()
    {

        $EjeTematico = new EjeTematicoComponent();

        echo $EjeTematico->RecibirInformacion();

    }


}
