<?php

namespace common\Controllers;

/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;



/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class ImagenesController extends Controller
{





    

    public function actionIndex($ruta,$tipo_imagen)
    {
        if (!Yii::$app->user->isGuest){

            if($tipo_imagen == 'personal'){

                $path = utf8_decode(Yii::getAlias('@frontend').$ruta);

                if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'sub_administrador')){
                    $path = utf8_decode(Yii::getAlias('@subadmin').$ruta);
                }

                if(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador')){
                    $path = utf8_decode(Yii::getAlias('@backend').$ruta);
                }

                
            }else{
                $path = utf8_decode(Yii::getAlias('@common').$ruta);
            }




            // $path = utf8_decode(Yii::getAlias('@mizonapreu')."\\files\\" . $ruta . "\\".$ruta_archivo);

            // var_dump($path);
            // exit;


            
            if(file_exists($path))
            {   

                 return \Yii::$app->response->sendFile($path);

            }else{
                
                 throw new \yii\web\HttpException(404, 'El archivo no existe.');
            }
        }else{
           return $this->redirect('/site/login');
        }
          
    }

    

}
