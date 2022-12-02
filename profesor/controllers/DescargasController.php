<?php
namespace profesor\controllers;


/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


class DescargasController extends Controller
{


    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex($ruta="",$ruta_archivo)
    {
        if (!Yii::$app->user->isGuest){

            // var_dump($ruta);
            // echo "<br>";
            // var_dump($ruta_archivo);
            // echo "<br>";
            // exit;



            //$path = utf8_decode($ruta_archivo);

            $path = $ruta_archivo;
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