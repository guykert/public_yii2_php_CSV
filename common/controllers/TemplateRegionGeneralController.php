<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use common\models\TemplateRegionGeneral;
use common\models\search\TemplateRegionGeneral as TemplateRegionGeneralSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Template;
use yii\web\UploadedFile;
use common\components\SimpleImage;

/**
 * TemplateRegionGeneralController Implementa las acciones del CRUD para el modeloTemplateRegionGeneral .
 * */ 
class TemplateRegionGeneralController extends Controller
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
                        'actions' => ['index','create','update','delete','view','create-dos','guardar-imagen'],
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
                        'actions' => ['index','create','update','delete','view','create-dos','guardar-imagen'],
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
        * Lista todo el modelo TemplateRegionGeneral. 
        * no hay variable de retorno
        */
        $searchModel = new TemplateRegionGeneralSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/template-region-general/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        /**
        * Muestra un modelo único TemplateRegionGeneral. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/template-region-general/view', [
            'model' => $this->findModel($id),
        ]);
    }
    
    public function actionCreate()
    {

        /**
        * Crea un nuevo modelo TemplateRegionGeneral.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new TemplateRegionGeneral();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        /* toma el id del usuario que está logeado*/
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            

            return $this->redirect(['create-dos','id_template'=>$model->template_id,'id_template_general'=>$model->id]);
        } else {
            return $this->render('@common/views/template-region-general/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateDos($id_template,$id_template_general)
    {

        /**
        * Crea un nuevo modelo Template.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $Template = Template::findOne($id_template);



        $model = new TemplateRegionGeneral();
        /* toma el id del usuario que está logeado*/
        return $this->render('@common/views/template-region-general/create_dos', [
            'model' => $model,
            'Template' => $Template,
            'id_template_general' => $id_template_general,
        ]);
    }

    public function actionGuardarImagen($imageId_x="",$imageId_x2="",$imageId_y="",$imageId_y2="",$imageId_h="",$imageId_w="",$id_template_general="",$id_template="")
    {
        $post = Yii::$app->request->post();




        $Template = Template::findOne($post['id_template']);



        $TemplateRegionGeneral = TemplateRegionGeneral::findOne($post['id_template_general']);




        $nombre = rand(0,9999).'-'. $Template->imagen  ;

        $TemplateRegionGeneral->imagen = $nombre;

        //Cambio el tamaño de la imagen


        $nombre2 = rand(0,9999).'-'. $Template->imagen  ;

        
        $archivo = $this->recortarImage(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$Template->imagen, $post['imageId_x'], $post['imageId_x2'], $post['imageId_y'], $post['imageId_y2'],   $post['imageId_w'], $post['imageId_h'],Yii::getAlias('@backend').'/web/img/uploads/templates/'.utf8_decode($nombre2));

        $TemplateRegionGeneral->imagen = $nombre2;
        $TemplateRegionGeneral->x = $post['imageId_x'];
        $TemplateRegionGeneral->y = $post['imageId_y'];
        $TemplateRegionGeneral->width = $post['imageId_w'];
        $TemplateRegionGeneral->height = $post['imageId_h'];

        $TemplateRegionGeneral->save();

    }


    private function recortarImage($filename, $x, $x2 ,$y, $y2 , $newwidth, $newheight,$nuevoNombre){

        $src = imagecreatefromjpeg($filename);

        list($width, $height) = getimagesize($filename);

        $dst_img = imagecreatetruecolor($newwidth, $newheight);


        imagecopyresampled($dst_img, $src, 0, 0, $x, $y, $newwidth, $newheight, $newwidth,$newheight);

        if (file_exists($nuevoNombre)) {
            unlink($nuevoNombre);
        }
        imagejpeg($dst_img, $nuevoNombre, 95);

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

    // private function resizeImage($filename, $newwidth, $newheight){
    //     list($width, $height) = getimagesize($filename);
    //     if($width > $height && $newheight < $height){
    //         $newheight = $height / ($width / $newwidth);
    //     } else if ($width < $height && $newwidth < $width) {
    //         $newwidth = $width / ($height / $newheight);   
    //     } else {
    //         $newwidth = $width;
    //         $newheight = $height;
    //     }
    //     $thumb = imagecreatetruecolor($newwidth, $newheight);
    //     $source = imagecreatefromjpeg($filename);
    //     imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
    //     return imagejpeg($thumb);
    // }

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente TemplateRegionGeneral.
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
            return $this->render('@common/views/template-region-general/update', [
                'model' => $model,
            ]);
        }
    }

    public function actionDelete($id)
    {
        /**
        * Elimina un modelo existente  TemplateRegionGeneral.
        * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" . 
        * @param integer $id
        * no tiene variable de retorno 
        */

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        /**
        * Busca el modelo TemplateRegionGeneral en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return TemplateRegionGeneral el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = TemplateRegionGeneral::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
