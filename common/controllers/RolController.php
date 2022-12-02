<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Rol;
use common\models\search\Rol as RolSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;

/**
 * RolController Implementa las acciones del CRUD para el modeloRol .
 * */ 
class RolController extends Controller
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
        * Lista todo el modelo Rol. 
        * no hay variable de retorno
        */
        $searchModel = new RolSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/rol/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionAssign($subRolid,$subRolname,$rolid,$rolname)
    {

        /**
        * Asigna un sub rol a un rol o lo elimina si ya está asignado Rol.
        * Si la actualización se realiza correctamente, no se asignará respuesta ya que es una petición por ajax
        * @param string $subRolid,$subRolname,$rolid,$rolname
        *  $subRolid este es el id del subrol
        *  $subRolname Este es el nombre del subrol
        *  $rolid Este es el id del rol principal
        *  $rolname Este es el nombre del rol principal
        */


        //confirmo si el subrol ya está asignado al rol principal
        if(Rol::getConfirnarCargados($rolname,$subRolname)){
            // Si ya está asignado se reboca la asignación
            Rol::eliminarSubRol($subRolname,$rolname);

        }else{
            // en caos de no estar asignado se asigna
            Rol::asignarSubRol($subRolname,$rolname);

        }
         
        Yii::$app->end();

    }
    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Rol. 
        * @param string $id
        * no tiene variable de retorno
        */

        $subRoles = Rol::getSubroles();


        return $this->render('@common/views/rol/view', [
            'model' => $this->findModel($id),
            'subRoles'=> $subRoles,
        ]);
    }

    
    public function actionCreate()
    {

        /**
         * Crea un nuevo modelo Rol.
         * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
         */

        $model = new Rol();
        $auth = Yii::$app->authManager;


        if ($model->load(Yii::$app->request->post()) ) {

            // $rol = $auth->createRole($model->name);
            // $rol->description  = $model->description;
            // $auth->add($rol);

            $auth = Yii::$app->authManager;

            // // Creamos el permiso para crear por post
            // $createPost = $auth->createPermission('createPost');
            // $createPost->description = 'Create a post';
            // $auth->add($createPost);

            // // Creamos el permiso para modificar por post
            // $updatePost = $auth->createPermission('updatePost');
            // $updatePost->description = 'Update post';
            // $auth->add($updatePost);


            // // Creamos el rol admin
            // $nombreRol = $auth->createRole('admin');
            // $auth->add($nombreRol);
            // $auth->addChild($author, $createPost);

            // // add "admin" role and give this role the "updatePost" permission
            // // as well as the permissions of the "author" role
            if($model->type == 1){
                $admin = $auth->createRole($model->name);
            }
            if($model->type == 2){
                $admin = $auth->createPermission($model->name);
            }

            $auth->add($admin);
            // $auth->addChild($admin, $updatePost);
            // $auth->addChild($admin, $author);

            $Rol = Rol::findOne(['name' => $model->name,]);


            $Rol->description = $model->description;
            $Rol->type = $model->type;
            $Rol->save();
            // $model->created_at = Yii::$app->user->identity->id;
            // $model->save();

            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/rol/create', [
                'model' => $model,
            ]);
        }
    }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Rol.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param string $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
         /* toma el id del usuario que está logeado*/
          $model->updated_at = Yii::$app->user->identity->id ;     
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/rol/update', [
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
        * Busca el modelo Rol en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param string $id
        * @return Rol el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Rol::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
