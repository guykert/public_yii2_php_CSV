<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Prueba;
use common\models\PruebaPauta;
use common\models\MallaHorariaClonar;
use common\models\MallaHorariaColegio;
use common\models\MallaHorariaColegioBloque;
use common\components\select\MallaHorariaComponent;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * DiaController Implementa las acciones del CRUD para el modeloDia .
 * */ 
class MallaHorariaClonarController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';

    public $moodle_session='97637d878978fcdfaf17735c677b58e5';

    public $tituloAyuda='AYUDA INDEX';

    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],

                //esto permite definir una determinada acción en caso de que no se cumplan las reglas
                // lo dejare comentado para ver si posteriormente sirve en algún caso particular
                // 'denyCallback' => function ($rule, $action) {
                //     //Esta es la acción a ejecutar en caso de que no se cumplan las reglas

                //     throw new \Exception('error');
                // },
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
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
                        'actions' => ['index'],
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

    public function actionIndex($colegio_id="",$malla_horaria_id="",$colegio_origen_id="")
    {

        $model = new MallaHorariaClonar();

        if ($model->load(Yii::$app->request->post())) {

            if($model->validate()){



                // Busco la tabla de malla para clonarla

                $MallaHorariaColegio = MallaHorariaColegio::findOne($model->malla_horaria_id);


                
                // Busco la malla para ver si ya existe para actualizarla

                $MallaHorariaColegioNueva = MallaHorariaColegio::findOne(['colegio_id'=>$model->colegio_id,'nombre'=>$MallaHorariaColegio->nombre]);

                var_dump($MallaHorariaColegioNueva);
                exit;

                if(!$MallaHorariaColegioNueva){
                    $MallaHorariaColegioNueva=new Prueba;

                    $MallaHorariaColegioNueva->fecha_creacion = new Expression('NOW()');
                    $MallaHorariaColegioNueva->creado_por = Yii::$app->user->identity->id;




                }else{
                    $MallaHorariaColegioNueva->fecha_modificacion = new Expression('NOW()');
                    $MallaHorariaColegioNueva->modificado_por = Yii::$app->user->identity->id;
                }
                $MallaHorariaColegioNueva->nombre = $MallaHorariaColegio->nombre;
                $MallaHorariaColegioNueva->descripcion = $MallaHorariaColegio->descripcion;
                $MallaHorariaColegioNueva->anio_id = $MallaHorariaColegio->anio_id;
                $MallaHorariaColegioNueva->colegio_id = $MallaHorariaColegio->colegio_id;
                $MallaHorariaColegioNueva->activo = 1;

                $MallaHorariaColegioNueva->save();

                // migro la pauta

                $MallaHorariaColegioBloque = MallaHorariaColegioBloque::find()->where(['prueba_id'=>$Prueba->id,'activo'=>1])->All(); 

                foreach ($PruebaPautas as $key => $PruebaPauta) {


                    $PruebaPautaNueva = PruebaPauta::findOne(['prueba_id'=>$PruebaNueva->id,'activo'=>1,'numero_pregunta'=>$PruebaPauta->numero_pregunta]);



                    if(!$PruebaPautaNueva){
                        $PruebaPautaNueva=new PruebaPauta;
    
                        $PruebaPautaNueva->fecha_creacion = new Expression('NOW()');
                        $PruebaPautaNueva->creado_por = Yii::$app->user->identity->id;

                    }else{

                        $PruebaPautaNueva->fecha_modificacion = new Expression('NOW()');
                        $PruebaPautaNueva->modificado_por = Yii::$app->user->identity->id;

                    }

                    $PruebaPautaNueva->prueba_id = $PruebaNueva->id;
                    $PruebaPautaNueva->activo = 1;
                    $PruebaPautaNueva->numero_pregunta = $PruebaPauta->numero_pregunta;
                    $PruebaPautaNueva->correcta = $PruebaPauta->correcta;
                    $PruebaPautaNueva->eje_tematico = $PruebaPauta->eje_tematico;
                    $PruebaPautaNueva->habilidad_id = $PruebaPauta->habilidad_id;
                    $PruebaPautaNueva->sub_tema_id = $PruebaPauta->sub_tema_id;
                    $PruebaPautaNueva->sub_eje_tematico = $PruebaPauta->sub_eje_tematico;

                    $PruebaPautaNueva->save();

                    


                }

                return $this->redirect(['index', 'colegio_id' => $model->colegio_id, 'prueba_id' => $model->prueba_id, 'colegio_origen_id' => $model->colegio_origen_id]);


            }else{
                return $this->render('@common/views/malla-horaria-clonar/index', [
                    'model' => $model,
                ]);
            }
        } else {

            if($colegio_id != ""){
                $model->colegio_id = $colegio_id;
            }

            if($prueba_id != ""){
                $model->prueba_id = $prueba_id;
            }

            if($colegio_origen_id != ""){
                $model->colegio_origen_id = $colegio_origen_id;
            }

            return $this->render('@common/views/malla-horaria-clonar/index', [
                'model' => $model,
            ]);
        }

    }

    public function actionMallas()
    {

        $Data = new MallaHorariaComponent();

        echo $Data->MallaColegio();

    }



}
