<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\PruebaFormulaNota;
use common\models\search\PruebaFormulaNota as PruebaFormulaNotaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;

/**
 * PruebaFormulaNotaController Implementa las acciones del CRUD para el modeloPruebaFormulaNota .
 * */ 
class PruebaFormulaNotaController extends Controller
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
        * Lista todo el modelo PruebaFormulaNota. 
        * no hay variable de retorno
        */
        $searchModel = new PruebaFormulaNotaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/prueba-formula-nota/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único PruebaFormulaNota. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/prueba-formula-nota/view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo PruebaFormulaNota.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new PruebaFormulaNota();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/prueba-formula-nota/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente PruebaFormulaNota.
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
            return $this->render('@common/views/prueba-formula-nota/update', [
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
        * Busca el modelo PruebaFormulaNota en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return PruebaFormulaNota el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = PruebaFormulaNota::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
