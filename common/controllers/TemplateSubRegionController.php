<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\TemplateSubRegion;
use common\models\TemplateRegion;
use common\models\search\TemplateSubRegion as TemplateSubRegionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\components\select\SubRegionGeneralComponent;

/**
 * TemplateSubRegionController Implementa las acciones del CRUD para el modeloTemplateSubRegion .
 * */ 
class TemplateSubRegionController extends Controller
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
                        'actions' => ['index','create','update','delete','view','region-general','region','create-dos','guardar-imagen'],
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
                        'actions' => ['index','create','update','delete','view','region-general','region','create-dos','guardar-imagen'],
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

    public function actionRegion()
    {

        $SubRegionGeneral = new SubRegionGeneralComponent();

        echo $SubRegionGeneral->RecibirInformacion();

    }
    

    public function actionIndex()
    {
        /**
        * Lista todo el modelo TemplateSubRegion. 
        * no hay variable de retorno
        */
        $searchModel = new TemplateSubRegionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/template-sub-region/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único TemplateSubRegion. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/template-sub-region/view', [
            'model' => $this->findModel($id),
        ]);
    }

    
    public function actionCreate($id_region="",$id_sub_region="",$x="",$y="",$x2="",$y2="",$w="",$h="")
    {

        /**
        * Crea un nuevo modelo TemplateSubRegion.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new TemplateSubRegion();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {




            return $this->redirect(['create-dos','id_region'=>$model->template_region_id,'id_sub_region'=>$model->id,'x'=>$x,'y'=>$y,'x2'=>$x2,'y2'=>$y2,'w'=>$w,'h'=>$h]);

        } else {

            if($id_sub_region != ""){

                $model->template_region_id = $id_region;

                $TemplateSubRegion = TemplateSubRegion::findOne($id_sub_region);

                $TemplateRegion = TemplateRegion::findOne($id_region);

                $model->template_id = $TemplateRegion->template_id;

                $model->template_region_general_id = $TemplateRegion->template_region_general_id;

                $model->nombre = $TemplateSubRegion->nombre;

                $model->descripcion = $TemplateSubRegion->descripcion;

                $model->valor = $TemplateSubRegion->valor;


            }

            return $this->render('@common/views/template-sub-region/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateDos($id_region,$id_sub_region,$x="",$y="",$x2="",$y2="",$w="",$h="")
    {

        /**
        * Crea un nuevo modelo Template.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $TemplateRegion = TemplateRegion::findOne($id_region);


        list($width, $height) = getimagesize(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$TemplateRegion->imagen);

        $model = TemplateSubRegion::findOne($id_sub_region);

        /* toma el id del usuario que está logeado*/
        return $this->render('@common/views/template-sub-region/create_dos', [
            'model' => $model,
            'TemplateRegion' => $TemplateRegion,
            'id_sub_region' => $id_sub_region,
            'width' => $width,
            'height' => $height,
            'x' => $x,
            'y' => $y,
            'x2' => $x2,
            'y2' => $y2,
            'w' => $w,
            'h' => $h,
        ]);
    }

    public function actionGuardarImagen($imageId_x="",$imageId_x2="",$imageId_y="",$imageId_y2="",$imageId_h="",$imageId_w="",$id_region="",$id_sub_region="")
    {
        $post = Yii::$app->request->post();




        



        

        $TemplateRegion = TemplateRegion::findOne($post['id_region']);

        $TemplateSubRegion = TemplateSubRegion::findOne($post['id_sub_region']);


        $nombre = rand(0,9999).'-'. $TemplateSubRegion->imagen;

        $TemplateSubRegion->imagen = $nombre;

        //Cambio el tamaño de la imagen


        $nombre2 = rand(0,9999).'-'. $TemplateRegion->imagen  ;

        
        $archivo = $this->recortarImage(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$TemplateRegion->imagen, $post['imageId_x'], $post['imageId_x2'], $post['imageId_y'], $post['imageId_y2'],   $post['imageId_w'], $post['imageId_h'],Yii::getAlias('@backend').'/web/img/uploads/templates/'.utf8_decode($nombre2));

        $TemplateSubRegion->imagen = $nombre2;
        $TemplateSubRegion->x = $post['imageId_x'];
        $TemplateSubRegion->y = $post['imageId_y'];
        $TemplateSubRegion->width = $post['imageId_w'];
        $TemplateSubRegion->height = $post['imageId_h'];

        $TemplateSubRegion->save();

        return $this->redirect(['create','id_region'=>$post['id_region'],'id_sub_region'=>$post['id_sub_region'],'x'=>$post['imageId_x'],'y'=>$post['imageId_y'],'x2'=>$post['imageId_x2'],'y2'=>$post['imageId_y2'],'w'=>$post['imageId_w'],'h'=>$post['imageId_h']]);

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

    
    public function actionUpdate($id)
    {
        /**
        * Actualiza un modelo existente TemplateSubRegion.
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
            return $this->render('@common/views/template-sub-region/update', [
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
        * Busca el modelo TemplateSubRegion en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return TemplateSubRegion el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = TemplateSubRegion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
