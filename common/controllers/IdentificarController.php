<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Usuario;
use common\models\User;
use common\models\PerfilForm;
use common\models\Configuracion;
use yii\filters\AccessControl;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\helpers\Json;
use common\models\Empresa;
use common\models\FormSettings;
use common\models\TemplateHijo;


class IdentificarController extends Controller
{
/**
 * DiaController Implementa las acciones del CRUD para el modeloDia .
 * */ 

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
    public $tituloAyuda='AYUDA INDEX';

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                // 'only' => ['index','actualizar-clave','actualizar-email','actualizar-email-ok','reset-password'],

                //esto permite definir una determinada acción en caso de que no se cumplan las reglas
                // lo dejare comentado para ver si posteriormente sirve en algún caso particular
                // 'denyCallback' => function ($rule, $action) {
                //     //Esta es la acción a ejecutar en caso de que no se cumplan las reglas

                //     throw new \Exception('error');
                // },
                'rules' => [
                    [
                        'actions' => ['index','actualizar-clave','actualizar-email','actualizar-email-ok','reset-password','perfil','subir-imagen','image-delete','settings'],
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
                        'actions' => ['index','actualizar-clave','actualizar-email','actualizar-email-ok','reset-password','perfil','subir-imagen','image-delete','settings'],
                        'allow' => true,
                        'roles' => ['accesoAcademico','sub_administrador','administrador','alumno','Profesor'],
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
        ];
    }

    public function actionImageDelete($name)
    {
        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id;
        if (is_file($directory . DIRECTORY_SEPARATOR . $name)) {
            unlink($directory . DIRECTORY_SEPARATOR . $name);
        }
    
        $files = FileHelper::findFiles($directory);
        $output = [];
        foreach ($files as $file) {
            $fileName = basename($file);
            $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
            $output['files'][] = [
                'name' => $fileName,
                'size' => filesize($file),
                'url' => $path,
                'thumbnailUrl' => $path,
                'deleteUrl' => 'image-delete?name=' . $fileName,
                'deleteType' => 'POST',
            ];
        }
        return Json::encode($output);
    }

    public function actionPerfil()
    {




        $model = new PerfilForm();



        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/uploads/';
        Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/uploads/';

        // $cantidadSedesUsuario = UsuarioSede::getCantidadSedesUsuario(Yii::$app->user->identity->id);

        // $cantidadRolesUsuario = RolUsuario::getCantidadRolesUsuario(Yii::$app->user->identity->id);

        $cantidadColegiosUsuario = Empresa::getColegiosAsignadosUsuario(Yii::$app->user->identity->id);

        if ($model->load(Yii::$app->request->post())) {

  

            $image = $model->uploadImage();

            

            if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'cambioDeAnio')){

                $model->anio_predeterminado = Yii::$app->request->post()['PerfilForm']['anio_predeterminado'];

            }else{



                $Configuracion = Configuracion::findOne(['anio_forzado'=>1]);



                $model->anio_predeterminado = $Configuracion->id;

            }

            $usuario = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'id' => Yii::$app->user->identity->id,
            ]);


            if(!$model->password == ""){

                $usuario->setPassword($model->password);

            }

            $usuario->anio_predeterminado = $model->anio_predeterminado;

            $usuario->colegio_predeterminada = Yii::$app->request->post()['PerfilForm']['colegio_predeterminada'];

            if (!$model->errors) {

                // upload only if valid uploaded file instance found
                if ($image !== false) {

                    $path = $model->getImageFile();




                    $usuario->image = $path;
                    $usuario->image_name = "/uploads/" .Yii::$app->user->identity->id."/profile/" . $image->name;



                    $directorios = $model->creoDirectorios();

                    



                    $image->saveAs($path);



                    
                }



                $usuario->save();




            } 


            Yii::$app->getSession()->setFlash('success', 'Los datos del perfil fueron modificados.');

            return $this->goHome();
        }

        // $model->sede_predeterminada = Yii::$app->user->identity->sede_predeterminada;

        // $model->rol_predeterminado = Yii::$app->user->identity->rol_predeterminado;
        
        $model->anio_predeterminado = Yii::$app->user->identity->anio_predeterminado;

        $model->colegio_predeterminada = Yii::$app->user->identity->colegio_predeterminada;

        // $sedesUsuario = UsuarioSede::getSedesUsuario(Yii::$app->user->identity->id);

        // $rolesUsuario = RolUsuario::getRolesUsuario(Yii::$app->user->identity->id);


        return $this->render('@common/views/identificar/perfil', [
            'model' => $model,
            'cantidadColegiosUsuario' => $cantidadColegiosUsuario,
            // 'sedesUsuario' => $sedesUsuario,
            // 'cantidadRolesUsuario' => $cantidadRolesUsuario,
            // 'rolesUsuario' => $rolesUsuario,
        ]);

    }

    public function actionSettings()
    {




        $model = new FormSettings();


        $cantidadColegiosUsuario = Empresa::getColegiosAsignadosUsuario(Yii::$app->user->identity->id);

        $cantidadTemplatesUsuario = TemplateHijo::getTemplatesAsignadosUsuario(Yii::$app->user->identity->id);



        if ($model->load(Yii::$app->request->post())) {

  

            $image = $model->uploadImage();

            

            if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'cambio_anio')){

                $model->anio_predeterminado = Yii::$app->request->post()['FormSettings']['anio_predeterminado'];

            }else{



                $Configuracion = Configuracion::findOne(['anio_forzado'=>1]);



                $model->anio_predeterminado = $Configuracion->id;

            }

            

            $usuario = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'id' => Yii::$app->user->identity->id,
            ]);


            if(!$model->password == ""){

                $usuario->setPassword($model->password);

            }

            $usuario->template_predeterminado = Yii::$app->request->post()['FormSettings']['template_predeterminado'];

            $usuario->anio_predeterminado = $model->anio_predeterminado;

            $usuario->colegio_predeterminada = Yii::$app->request->post()['FormSettings']['colegio_predeterminada'];

            if (!$model->errors) {

                // upload only if valid uploaded file instance found
                if ($image !== false) {

                    $path = $model->getImageFile();




                    $usuario->image = $path;
                    $usuario->image_name = "/uploads/" .Yii::$app->user->identity->id."/profile/" . $image->name;



                    $directorios = $model->creoDirectorios();

                    



                    $image->saveAs($path);



                    
                }



                $usuario->save();




            } 


            Yii::$app->getSession()->setFlash('success', 'Los datos del perfil fueron modificados.');

            return $this->goHome();
        }


        
        $model->anio_predeterminado = Yii::$app->user->identity->anio_predeterminado;

        $model->colegio_predeterminada = Yii::$app->user->identity->colegio_predeterminada;

        $model->template_predeterminado = Yii::$app->user->identity->template_predeterminado;



        return $this->render('@common/views/identificar/settings', [
            'model' => $model,
            'cantidadColegiosUsuario' => $cantidadColegiosUsuario,
            'cantidadTemplatesUsuario' => $cantidadTemplatesUsuario,

            // 'sedesUsuario' => $sedesUsuario,
            // 'cantidadRolesUsuario' => $cantidadRolesUsuario,
            // 'rolesUsuario' => $rolesUsuario,
        ]);

    }

    public function actionSubirImagen()
    {
        $model = new PerfilForm();
    
        $imageFile = UploadedFile::getInstance($model, 'image');
    


        $directory = Yii::getAlias('@frontend/web/img/temp') . DIRECTORY_SEPARATOR . Yii::$app->session->id . DIRECTORY_SEPARATOR;
        if (!is_dir($directory)) {
            FileHelper::createDirectory($directory);
        }
    
        if ($imageFile) {
            $uid = uniqid(time(), true);
            $fileName = $uid . '.' . $imageFile->extension;
            $filePath = $directory . $fileName;
            if ($imageFile->saveAs($filePath)) {
                $path = '/img/temp/' . Yii::$app->session->id . DIRECTORY_SEPARATOR . $fileName;
                return Json::encode([
                    'files' => [
                        [
                            'name' => $fileName,
                            'size' => $imageFile->size,
                            'url' => 'http://localhost/academico.csv/yii2-app' . $path,
                            'thumbnailUrl' => 'http://localhost/academico.csv/yii2-app' . $path,
                            'deleteUrl' => 'image-delete?name=' . $fileName,
                            'deleteType' => 'POST',
                        ],
                    ],
                ]);
            }
        }
    
        return '';
    }

    public function actionIndex()
    {
    
        // if(!(Yii::$app->user->identity->clave_actualizada)){
        //     return $this->redirect(['actualizar-email']);
        // }

    }

    public function actionActualizarClave()
    {
    
        $this->layout = 'main';
        $model = new ActualizarClave();

        
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

            Yii::$app->getSession()->setFlash('success', 'Nuevo password ha sido guardado.');

            return $this->goHome();

        }

        return $this->render('actualizarClave', [
            'model' => $model,
        ]);

    }

    public function actionActualizarEmail()
    {
    
        $this->layout = 'main';
        $model = new ActualizarEmail();

        
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if($model->email != Yii::$app->user->identity->email){

                //realizo la busqueda para ver si el rut existe.

                $cantidad_emails = Usuario::find()
                    ->select(['COUNT(*) AS cnt'])
                    ->where(['email' => $model->email]) 
                    // ->orWhere(['email2' => $model->email]) 
                    ->count();

                if($cantidad_emails > 0){
                    $model->addError('email', 'El email ya existe en el sistema');

                }else{
                    // Actualizo el modelo con el nuevo email


                    $Usuario = User::findOne([
                        'status' => User::STATUS_ACTIVE,
                        'id' => Yii::$app->user->identity->id,
                    ]);

                    $Usuario->email = $model->email;

                    $Usuario->save();

                    if ($model->sendEmail('academico')) {
                             
                        Yii::$app->getSession()->setFlash('success', 'Revise su correo electrónico '.Yii::$app->user->identity->email.' para obtener más instrucciones.');

                    } else {
                        Yii::$app->getSession()->setFlash('error', 'Lo sentimos, no podemos restablecer la contraseña para el correo electrónico proporcionado.');

                    }

                    return $this->redirect(['actualizar-email-ok']);
                }

                

            }else{
                if ($model->sendEmail('academico')) {
                         
                    Yii::$app->getSession()->setFlash('success', '  ');

                } else {
                    Yii::$app->getSession()->setFlash('error', 'Lo sentimos, no podemos restablecer la contraseña para el correo electrónico proporcionado.');

                }

                return $this->redirect(['actualizar-email-ok']);
            }

            //     $cantidad_emails = Usuario::find()
            //         ->select(['COUNT(*) AS cnt'])
            //         ->where(['email' => $model->email]) 
            //         ->orWhere(['email2' => $model->email]) 
            //         ->count();

            //     var_dump($cantidad_emails);

            // var_dump("expression");
            // exit;

            // Yii::$app->getSession()->setFlash('success', 'Nuevo password ha sido guardado.');

            // return $this->goHome();

        }

        if(!$model->email){
            $model->email = Yii::$app->user->identity->email;
        }

        

        return $this->render('actualizarEmail', [
            'model' => $model,
        ]);

    }

    public function actionActualizarEmailOk()
    {
    
        $this->layout = 'main';

        return $this->render('actualizarEmailOk');

    }

    public function actionResetPassword($token)
    {

        $this->layout = 'main';
        try {

            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {

            $Usuario = User::findOne([
                'status' => User::STATUS_ACTIVE,
                'id' => Yii::$app->user->identity->id,
            ]);

            $Usuario->clave_actualizada = 1;

            $Usuario->save();

            Yii::$app->getSession()->setFlash('success', 'Nuevo password ha sido guardado.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }


}
