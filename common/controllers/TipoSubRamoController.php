<?php

namespace backend\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\TipoSubRamo;
use common\models\search\TipoSubRamo as TipoSubRamoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Usuario;
use common\models\Configuracion;

use yii\filters\AccessControl;

class TipoSubRamoController extends Controller
{
 /**
 * TipoSubRamoController Implementa las acciones del CRUD para el modeloTipoSubRamo .
 * */ 

    public $layout = "general";

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
                        'actions' => ['index','create','update','delete'],
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
                        'actions' => ['index','create','update','delete'],
                        'allow' => true,
                        'roles' => ['administradorRamo'],
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
     * Lista todo el modelo TipoSubRamo. 
     * no hay variable de retorno
     */

        $searchModel = new TipoSubRamoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionView($id)
    {
      /**
     * Muestra un modelo único TipoSubRamo. 
     * @param string $id
     * no tiene variable de retorno
     */

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionCreate()
    {
      /**
     * Crea un nuevo modelo TipoSubRamo.
     * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
     */

        $model = new TipoSubRamo();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;

        $configuracion = Configuracion::findOne(Yii::$app->user->identity->anio_predeterminado);


        $model->sanio_id = $configuracion->estructura_id;

        var_dump($model);
        exit;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
      /**
     * Actualiza un modelo existente TipoSubRamo.
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
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
      /**
     * Elimina un modelo existente  TipoSubRamo.
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
     * Busca el modelo TipoSubRamo en función de su llave primaria.
     * Si no se encuentra el modelo, se emite una excepción HTTP 404.
     * @param string $id
     * @return TipoSubRamo el modelo cargado.
     * Devuelve NotFoundHttpException si el modelo no se puede encontrar
     */

        if (($model = TipoSubRamo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
