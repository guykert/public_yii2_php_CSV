<?php
namespace common\controllers;

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

/**
 * Site controller
 */
class SiteController extends Controller
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
                        'roles' => ['acceso_frontend'],
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
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionAyudaExterno($id="")
    {

        var_dump($id);
        exit;

    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {

        // if(!(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'sub_administrador'))){
        
        //     return $this->redirect(['site/logout', 'error' => 1]);

        // }



        $this->layout ='@common/views/layouts/general';
        return $this->render('@common/views/site/index');
    }
    


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin($error="")
    {


        $this->layout = '@common/views/layouts/login2';

        
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
                $model->login(false);

                $Usuario = Usuario::findOne(Yii::$app->user->identity->id);

                if (!Yii::$app->user->identity->anio_predeterminado || Yii::$app->user->identity->anio_predeterminado == 0) {

                    

                    $Configuracion = Configuracion::findOne(['anio_academico'=>date('Y')]);

                    $Usuario->anio_predeterminado = $Configuracion->id;

                    $Usuario->save();

                }else{
                    $Configuracion = Configuracion::findOne(['anio_forzado'=>1]);

                    if($Configuracion){

                        if($Configuracion->id != $Usuario->anio_predeterminado){

                            
                            $Usuario->anio_predeterminado = $Configuracion->id;

                            $Usuario->save();
                        }

                    }


                }


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

    // /**
    //  * Signs user up.
    //  *
    //  * @return mixed
    //  */
    public function actionSignup()
    {

        $this->layout = '@common/views/layouts/login2';

        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('@common/views/site/signup', [
            'model' => $model,
        ]);
    }

    // /**
    //  * Signs user up.
    //  *
    //  * @return mixed
    //  */
    public function actionGoHome()
    {

        return $this->goBack();
        
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {

        $this->layout = '@common/views/layouts/login2';
        


        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail()) {

                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {

                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('@common/views/site/requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            // change layout for error action
            if ($action->id=='error')
                    $this->layout ='@common/views/layouts/error';
            return true;
        } else {
            return false;
        }

        if (Yii::$app->session['sessionTimeout'] < time()) {
            //Yii::$app->getSession()->troy();
            return $this->redirect(['site/logout']);
        } 

        //     //si esta logeado
        // if (\Yii::$app->user->isGuest) {
        //       //return $this->goHome();
        //       return $this->redirect(['login']);
        // }
        
        return true;
    }



    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
                'view' => '@common/views/site/error.php'
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
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

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    // /**
    //  * Displays about page.
    //  *
    //  * @return mixed
    //  */
    // public function actionAbout()
    // {
    //     return $this->render('about');
    // }




    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
