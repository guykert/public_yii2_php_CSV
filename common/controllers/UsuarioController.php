<?php

namespace common\controllers;

use Yii;
use common\models\Usuario;
use common\models\search\UsuarioSearch;
use common\models\Rol;
use common\models\Template;
use common\models\TemplateHijo;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Empresa;
use common\models\UsuarioEmpresaHijo;

/**
 * UsuarioController implements the CRUD actions for Usuario model.
 */
class UsuarioController extends Controller
{
    public $layout = "@common/views/layouts/mantenedor";


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
                        'actions' => ['index','create','update','delete','guias','assign-template','assign-empresa'],
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
                        'actions' => ['index','create','update','delete','guias','assign-template','assign-empresa'],
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

    public function actionAssignTemplate($Templateid,$userid)
    {

        $TemplateHijo = TemplateHijo::find()
        ->where(['usuario_id' => $userid,'template_id' => $Templateid,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();

        if(!$TemplateHijo){

            $TemplateHijo = new TemplateHijo();
            $TemplateHijo->template_id = $Templateid;
            $TemplateHijo->usuario_id = $userid;
            $TemplateHijo->creado_por = Yii::$app->user->identity->id;
            $TemplateHijo->fecha_creacion = date("Y-m-d H:i:s");
            $TemplateHijo->activo = 1;

            $TemplateHijo->save();

        }else{

            $TemplateHijo->activo = 0;

            $TemplateHijo->save();

        }

        Yii::$app->end();

    }

    public function actionAssignEmpresa($empresaid,$usuarioid)
    {

        $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
        ->where(['usuario_id' => $usuarioid,'empresa_id' => $empresaid,'activo' => 1]) 
        // ->orWhere(['email2' => $model->email]) 
        ->one();

        if(!$UsuarioEmpresaHijo){

            $UsuarioEmpresaHijo = new UsuarioEmpresaHijo();
            $UsuarioEmpresaHijo->empresa_id = $empresaid;
            $UsuarioEmpresaHijo->usuario_id = $usuarioid;
            $UsuarioEmpresaHijo->creado_por = Yii::$app->user->identity->id;
            $UsuarioEmpresaHijo->fecha_creacion = date("Y-m-d H:i:s");
            $UsuarioEmpresaHijo->activo = 1;

            $UsuarioEmpresaHijo->save();

        }else{

            $UsuarioEmpresaHijo->activo = 0;

            $UsuarioEmpresaHijo->save();

        }

        Yii::$app->end();

    }

    public function actionIndex()
    {

        $searchModel = new UsuarioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/usuario/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    public function actionCreate()
    {
        /**
        * Crea un nuevo modelo Usuario.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */



        $model = new Usuario(['scenario' => 'validacionCompletaCrear']);
        /* toma el id del usuario que está logeado y lo deja en creado_por*/

        $model->creado_por = Yii::$app->user->identity->id ;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {



            $model->rut = Yii::$app->request->post()['Usuario']['rut'];
            $model->setPassword($model->password_hash);
            $model->generateAuthKey();

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return $this->render('@common/views/usuario/create', [
                    'model' => $model,
                ]);
            }
        } else {

            if ($model->load(Yii::$app->request->post())) {
                $model->rut = Yii::$app->request->post()['Usuario']['rut'];
            }

            return $this->render('@common/views/usuario/create', [
                'model' => $model,
            ]);
        }

    }

    public function actionAssignpermiso($Rolid,$Rolname,$userid,$username)
    {



        if(Rol::getConfirnarAsignados($userid,$Rolname)){

            Rol::eliminarRolUsuarioPermiso($userid,$Rolname);

        }else{

            Rol::asignarRolUsuarioPermiso($userid,$Rolname);

        }

        Yii::$app->end();

    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Usuario.
        * @param string $id
        * no tiene variable de retorno
        */

        $auth = Yii::$app->authManager ;

        $subRoles = Rol::getSubroles();

        $Roles = Rol::getRoles();

        $Templates = Template::getTemplatesAsignables();

        $Empresas = Empresa::getEmpresasExterno();

        $Corporaciones = Empresa::getCorporacionesExterno();

        $Colegios = Empresa::getColegiosExterno();

        return $this->render('@common/views/usuario/view', [
            'model' => $this->findModel($id),
            'subRoles'=> $subRoles,
            'Roles'=> $Roles,
            'Templates'=> $Templates,
            'Empresas'=> $Empresas,
            'Corporaciones'=> $Corporaciones,
            'Colegios'=> $Colegios,
        ]);

    }

    public function actionDelete($id)
    {
        // /**
        // * Elimina un modelo existente  Usuario.
        // * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" .
        // * @param string $id
        // * no tiene variable de retorno
        // */
        // // $this->findModel($id)->delete();
        // $model = $this->findModel($id);
        // if($model->activo == 1 ){
        //         // //si este usuario es profesor desactiva los cursos que tiene asignado
        //         // $rol_profe=RolUsuario::find()->where(['user_id'=>$model->id,'item_name'=>'profesor'])->one();            
                 
        //         // if($rol_profe){
        //         //     //desactiva el o los curso(s) que tiene asignado en la sede 
        //         //     $cursos_profesor = AlumnoCurso::find()->where(['usuario_id'=>$model->id,'rol_id'=>38,'activo'=>1])->all();
        //         //     if($cursos_profesor){
        //         //       foreach($cursos_profesor as $curso){
        //         //         $curso->activo =false;
        //         //         $curso->modificado_por =Yii::$app->user->identity->id;
        //         //         $curso->save();  
        //         //       }

        //         //     }
        //         // }    

        //     $model->activo = false;

        //     $model->save();
        // }

        // return $this->redirect(['index']);


        
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

            $model->rut = $model->rut. "E";
            $model->username = $model->username. "E";

            $model->setScenario('validacioneliminarRegistro');
            $model->save();
            return $this->redirect(['index']);        
        }else{
            $model->activo = true ;
            $model->save();
            return $this->redirect(['inactivo']);  
        }
        

    }

    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Usuario.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param string $id
        *  no tiene variable de retorno
        */
        $model = new Usuario(['scenario' => 'validacionParcial']);
        $model = $this->findModel($id);

          /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id;
        $clave_vieja = '';

        $clave_vieja = $model->password_hash;
        $model->password_hash = $clave_vieja ;
        if ($model->load(Yii::$app->request->post())) {
            $model->rut = Yii::$app->request->post()['Usuario']['rut'];
            $model->username = Yii::$app->request->post()['Usuario']['username'];
            // solo si se relizó cambio en la clave la actualiza
            // $model->password_hash es la clave que llega por post, se compara con la clave que tenía em modelo
            if($model->password_hash  !==  "")
            {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
            }else{
                $model->password_hash = $clave_vieja;
            }

            if($model->save()){
       
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                $model->password_hash="";
                return $this->render('@common/views/usuario/update', [
                    'model' => $model,
                ]);
            }
        } else {

            $model->password_hash="";
            return $this->render('@common/views/usuario/update', [
                'model' => $model,
            ]);

        }

    }

    protected function findModel($id)
    {
        /**
        * Busca el modelo Usuario en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param string $id
        * @return Usuario el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Usuario::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    public function actionAssign($Rolid,$Rolname,$userid,$username)
    {


        if(Rol::getConfirnarAsignados($userid,$Rolname)){

            Rol::eliminarRolUsuario($userid,$Rolname);

        }else{

            // var_dump('actionAssign');
            // var_dump($Rolid);
            // var_dump($Rolname);
            // var_dump($userid);
            // var_dump($username);
            // var_dump(Rol::getConfirnarAsignados($userid,$Rolname));
            // exit;
            Rol::asignarRolUsuario($userid,$Rolname);

        }

        Yii::$app->end();

    }

}
