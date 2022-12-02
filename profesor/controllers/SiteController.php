<?php
namespace profesor\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\Usuario;
use common\models\Configuracion;
use common\models\UsuarioCurso;
use common\models\UsuarioEmpresaHijo;
use common\controllers\SiteController as SiteControllerCommon;



/**
 * Site controller
 */
class SiteController extends SiteControllerCommon
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => false,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['acceso_profesores'],
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
            // 'verbs' => [
            //     'class' => VerbFilter::className(),
            //     'actions' => [
            //         'logout' => ['post'],
            //     ],
            // ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        


        if(Yii::$app->session->get('ramo_seleccionado') == ""){

            return $this->redirect(['/seleccionar-curso']);

        }else{

    
    
            $this->layout ='/views/layouts/general';
            return $this->render('/views/site/index');

        }

    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin($error="")
    {



        $this->layout = 'login';


        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if($error == 1){
            $model->addError('username', 'Este usuario no tiene permisos para acceder al sitio');
        }


        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = $model->getUser();

            // Primedo chequeo si el usuario está activo

            if (!empty($user) && $user->activo == true) {


                

                $Configuracion = Configuracion::find()
                
                ->where(['anio_forzado'=>1,'activo' => 1])

                ->one();

                $user->anio_predeterminado = $Configuracion->id;


                if($user->colegio_predeterminada == ""){

                    $UsuarioEmpresaHijo = UsuarioEmpresaHijo::find()
                    ->select(['empresa_id'])
                    ->where(['usuario_id'=>$user->id,'activo' => 1])
                    ->one();
    

    
                    $user->colegio_predeterminada = $UsuarioEmpresaHijo->empresa_id;
    

                }




                $user->save();



                $model->login(false);





                return $this->goBack();


            } else {
                $model->addError('username', 'Este usuario ya no está activo');
                return $this->render('@common/views/site/login', [
                    'model' => $model,
                ]);
            }

        } else {
            $model->password = '';


            return $this->render('@common/views/site/login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout($error="")
    {
        Yii::$app->user->logout();

        return $this->redirect(['site/login', 'error' => 1]);

        // return $this->goHome($error);
    }

    // /**
        //  * Signs user up.
        //  *
        //  * @return mixed
    //  */
    public function actionGoHome()
    {



        return $this->redirect(['/']);

        //return $this->goBack();
        
    }

}
