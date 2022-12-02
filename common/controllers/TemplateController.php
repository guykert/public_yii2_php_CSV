<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\Template;
use common\models\search\Template as TemplateSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use yii\web\UploadedFile;

/**
 * TemplateController Implementa las acciones del CRUD para el modeloTemplate .
 * */ 
class TemplateController extends Controller
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
        * Lista todo el modelo Template. 
        * no hay variable de retorno
        */
        $searchModel = new TemplateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/template/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único Template. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/template/view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo Template.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Template();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('@common/views/template/create', [
                'model' => $model,
            ]);
        }
    }

    

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente Template.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");

        if ($model->load(Yii::$app->request->post())) {

            $archivo = UploadedFile::getInstance($model,'imagen');
            if($archivo){
                $nombre = rand(0,9999).'-'. $archivo->name  ;
                $model->imagen_original = $nombre;

                $nombre = rand(0,9999).'-'. $model->imagen_original  ;

                $model->imagen = $nombre;
            }
            $model->creado_por = Yii::$app->user->identity->id;



            if($model->save()){
                if($archivo)
                {   

                    $archivo->saveAs(Yii::getAlias('@backend').'/web/img/uploads/templates/'.utf8_decode($model->imagen_original));


            
                    //Cambio el tamaño de la imagen
            
                    $archivo = $this->resizeImage(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$model->imagen_original, '800', '1100',Yii::getAlias('@backend').'/web/img/uploads/templates/'.utf8_decode($model->imagen));

                }

                return $this->redirect(['index']);
            } else{

                return $this->render('@common/views/template/update', [
                    'model' => $model,
                ]);

            }

            
        } else {
            return $this->render('@common/views/template/update', [
                'model' => $model,
            ]);
        }
    }

    private function resizeImage($filename, $newwidth, $newheight,$nuevoNombre){

        $src = imagecreatefromjpeg($filename);

        list($width, $height) = getimagesize($filename);

        $tmp = imagecreatetruecolor($newwidth, $newheight);

        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);

        if (file_exists($nuevoNombre)) {
            unlink($nuevoNombre);
        }
        imagejpeg($tmp, $nuevoNombre, 95);

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
        * Busca el modelo Template en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Template el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Template::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
