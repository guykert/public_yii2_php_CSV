<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use common\models\TemplateRegion;
use common\models\search\TemplateRegion as TemplateRegionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\TemplateRegionGeneral;
use common\components\select\RegionGeneralComponent;
use common\models\TemplateSubRegion;
use yii\helpers\Json;
use yii\base\Model;

/**
 * TemplateRegionController Implementa las acciones del CRUD para el modeloTemplateRegion .
 * */ 
class TemplateRegionController extends Controller
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
                        'actions' => ['index','create','update','delete','view','region-general','create-dos','guardar-imagen','clonar','data-region','data-sub-regiones','update-dos'],
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
                        'actions' => ['index','create','update','delete','view','region-general','create-dos','guardar-imagen','clonar','data-region','data-sub-regiones','update-dos'],
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

    public function actionDataSubRegiones($id,$id_anterior)
    {

        $TemplateRegion = $this->findModel($id);

        $TemplateSubRegiones = TemplateSubRegion::find()->where(['template_region_id'=>$id_anterior,'activo'=>1])->all();

        echo Json::encode(['TemplateRegion' => $TemplateRegion,'TemplateSubRegiones' => $TemplateSubRegiones]);

        return;


    }

    public function actionRegionGeneral()
    {

        $RegionGeneral = new RegionGeneralComponent();

        echo $RegionGeneral->RecibirInformacion();

    }
    

    public function actionIndex()
    {
        /**
        * Lista todo el modelo TemplateRegion. 
        * no hay variable de retorno
        */
        $searchModel = new TemplateRegionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/template-region/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    

    public function actionView($id)
    {
        /**
        * Muestra un modelo único TemplateRegion. 
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/template-region/view', [
            'model' => $this->findModel($id),
        ]);
    }


    public function actionDataRegion($id)
    {

        return $this->renderAjax('@common/views/template-region/view_clonar', [
            'model' => $this->findModel($id),
        ]);

    }

    public function actionClonar($id)
    {
        
        $TemplateRegion = $this->findModel($id);

        $TemplateSubRegions = TemplateSubRegion::findAll(['template_region_id' => $id,'activo'=>1]);
        

        // busco las sub regiones para desplegar las creadas con esta región
        $model_principal = new TemplateSubRegion();

        $multiple['form_multiple'] = [];
        foreach ($TemplateSubRegions as $TemplateSubRegion) {
            $model = new TemplateSubRegion();
            /* toma el id del usuario que está logeado*/
            $model->creado_por = Yii::$app->user->identity->id;
            $model->fecha_creacion = date("Y-m-d H:i:s");
            $model->activo = 1;

            $model->template_region_id = $id;
            $model->nombre = $TemplateSubRegion->nombre;
            $model->descripcion = $TemplateSubRegion->descripcion;
            $model->valor = $TemplateSubRegion->valor;
            $model->x = $TemplateSubRegion->x;
            $model->y = $TemplateSubRegion->y;
            $model->width = $TemplateSubRegion->width;
            $model->height = $TemplateSubRegion->height;

            $multiple['form_multiple'][] = $model;

        }

        if ($model_principal->load(Yii::$app->request->post())) {


            $model_principal->template_id = Yii::$app->request->post()["TemplateSubRegion"]["template_id"];
            $model_principal->template_region_general_id = Yii::$app->request->post()["TemplateSubRegion"]["template_region_general_id"];

            if (Model::loadMultiple($multiple['form_multiple'], Yii::$app->request->post())) {

                foreach ($multiple['form_multiple'] as $multip) {

                    $multip->template_region_id = $model_principal->template_region_id;

                    $multip->save();

                    $this->actionGuardarImagenSubRamo($multip->x,($multip->x + $multip->width),$multip->y,($multip->y + $multip->height),$multip->height,$multip->width,$model_principal->template_region_id,$multip->id);

    
                }

            }

        }


        $model_principal->template_region_id = 0;





        return $this->render('@common/views/template-region/clonar', [
            'id' => $id,
            'model_principal' => $model_principal,
            'TemplateRegion' => $TemplateRegion,
            'TemplateSubRegions' => $TemplateSubRegions,
            'multiple' => $multiple,
        ]);
    }

    public function actionGuardarImagenSubRamo($imageId_x="",$imageId_x2="",$imageId_y="",$imageId_y2="",$imageId_h="",$imageId_w="",$id_region="",$id_sub_region="")
    {



        $TemplateRegion = TemplateRegion::findOne($id_region);



        $TemplateSubRegion = TemplateSubRegion::findOne($id_sub_region);



        $nombre = rand(0,9999).'-'. $TemplateSubRegion->imagen;

        $TemplateSubRegion->imagen = $nombre;

        //Cambio el tamaño de la imagen


        $nombre2 = rand(0,9999).'-'. $TemplateRegion->imagen  ;


        
        $archivo = $this->recortarImage(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$TemplateRegion->imagen, $imageId_x,$imageId_x2, $imageId_y, $imageId_y2,$imageId_w, $imageId_h,Yii::getAlias('@backend').'/web/img/uploads/templates/'.utf8_decode($nombre2));

        $TemplateSubRegion->imagen = $nombre2;


        $TemplateSubRegion->save();



    }
    
    public function actionCreate($id_region_general="",$id_template_region="",$x="",$y="",$x2="",$y2="",$w="",$h="")
    {


        /**
        * Crea un nuevo modelo TemplateRegion.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new TemplateRegion();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->activo = 1;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $model->x2 = Yii::$app->request->post()['TemplateRegion']['x2'];

            $model->y2 = Yii::$app->request->post()['TemplateRegion']['y2'];

 



            return $this->redirect(['create-dos','id_template'=>$model->template_id,'template_region_general_id'=>$model->template_region_general_id,'id_region'=>$model->id,'x'=>$x,'y'=>$y,'x2'=>$x2,'y2'=>$y2,'w'=>$w,'h'=>$h]);

        } else {

            if($id_region_general != ""){
                $model->template_region_general_id = $id_region_general;

                $TemplateRegionGeneral = TemplateRegionGeneral::findOne($id_region_general);

                $TemplateRegion = TemplateRegion::findOne($id_template_region);

                $model->template_id = $TemplateRegionGeneral->template_id;

                $model->nombre = $TemplateRegion->nombre;

                $model->x = $x;

                $model->y = $y;

                $model->x2 = $x2;

                $model->y2 = $y2;

                $model->width = $w;

                $model->height = $h;

                $model->descripcion = $TemplateRegion->descripcion;


            }

            return $this->render('@common/views/template-region/create', [
                'model' => $model,
            ]);
        }
    }

    public function actionCreateDos($id_template,$template_region_general_id,$id_region,$x="",$y="",$x2="",$y2="",$w="",$h="")
    {

        /**
        * Crea un nuevo modelo Template.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $TemplateRegionGeneral = TemplateRegionGeneral::findOne($template_region_general_id);


        list($width, $height) = getimagesize(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$TemplateRegionGeneral->imagen);


        $model = TemplateRegion::findOne($id_region);

        $model->x2 = $x2;

        $model->y2 = $y2;

        /* toma el id del usuario que está logeado*/
        return $this->render('@common/views/template-region/create_dos', [
            'model' => $model,
            'TemplateRegionGeneral' => $TemplateRegionGeneral,
            'id_template_region' => $id_region,
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



    public function actionGuardarImagen($imageId_x="",$imageId_x2="",$imageId_y="",$imageId_y2="",$imageId_h="",$imageId_w="",$id_template_region="",$id_region_general="")
    {
        $post = Yii::$app->request->post();

        



        $TemplateRegionGeneral = TemplateRegionGeneral::findOne($post['id_region_general']);

        $TemplateRegion = TemplateRegion::findOne($post['id_template_region']);




        $nombre = rand(0,9999).'-'. $TemplateRegion->imagen  ;

        $TemplateRegion->imagen = $nombre;

        //Cambio el tamaño de la imagen


        $nombre2 = rand(0,9999).'-'. $TemplateRegionGeneral->imagen  ;

        
        $archivo = $this->recortarImage(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$TemplateRegionGeneral->imagen, $post['imageId_x'], $post['imageId_x2'], $post['imageId_y'], $post['imageId_y2'],$post['imageId_w'], $post['imageId_h'],Yii::getAlias('@backend').'/web/img/uploads/templates/'.utf8_decode($nombre2));

        $TemplateRegion->imagen = $nombre2;
        $TemplateRegion->x = $post['imageId_x'];
        $TemplateRegion->y = $post['imageId_y'];
        $TemplateRegion->width = $post['imageId_w'];
        $TemplateRegion->height = $post['imageId_h'];

        $TemplateRegion->save();

        return $this->redirect(['create','id_region_general'=>$post['id_region_general'],'id_template_region'=>$post['id_template_region'],'x'=>$post['imageId_x'],'y'=>$post['imageId_y'],'x2'=>$post['imageId_x2'],'y2'=>$post['imageId_y2'],'w'=>$post['imageId_w'],'h'=>$post['imageId_h']]);

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
        * Actualiza un modelo existente TemplateRegion.
        * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
        * @param integer $id
        *  no tiene variable de retorno
        */

        $model = $this->findModel($id);
        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update-dos','id_template'=>$model->template_id,'template_region_general_id'=>$model->template_region_general_id,'id_region'=>$model->id,'x'=>$model->x,'y'=>$model->y,'x2'=>0,'y2'=>0,'w'=>$model->width,'h'=>$model->height]);
        } else {
            return $this->render('@common/views/template-region/update', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdateDos($id_template,$template_region_general_id,$id_region,$x="",$y="",$x2="",$y2="",$w="",$h="")
    {

        /**
        * Crea un nuevo modelo Template.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $TemplateRegionGeneral = TemplateRegionGeneral::findOne($template_region_general_id);


        list($width, $height) = getimagesize(Yii::getAlias('@backend').'/web/img/uploads/templates/'.$TemplateRegionGeneral->imagen);


        $model = TemplateRegion::findOne($id_region);

        if($x2 == 0){
            $x2 = ($w + $x);
        }else{
            $x2 = $x2;
        }
        
        if($y2 == 0){
            $y2 = ($h + $y);
        }else{
            $y2 = $y2;
        }

        $model->y2 = $y2;
        $model->x2 = $x2;




        /* toma el id del usuario que está logeado*/
        return $this->render('@common/views/template-region/create_dos', [
            'model' => $model,
            'TemplateRegionGeneral' => $TemplateRegionGeneral,
            'id_template_region' => $id_region,
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
        * Busca el modelo TemplateRegion en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return TemplateRegion el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = TemplateRegion::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
