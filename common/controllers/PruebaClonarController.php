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
use common\models\PruebaClonar;
use common\components\select\PruebasComponent;
use yii\db\Expression;
use yii\helpers\Json;

/**
 * DiaController Implementa las acciones del CRUD para el modeloDia .
 * */ 
class PruebaClonarController extends Controller
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
                        'roles' => ['mantenedores_sistema','sub_administrador'],
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

    public function actionIndex($colegio_id="",$prueba_id="",$colegio_origen_id="")
    {

        $model = new PruebaClonar();

        if ($model->load(Yii::$app->request->post())) {

            if($model->validate()){




                // Busco la tabla de prueba para clonarla

                $Prueba = Prueba::findOne($model->prueba_id);

                // Busco la prueba para ver si ya existe para actualizarla

                

                if($model->anio_predeterminado > 0){

                    $PruebaNueva = Prueba::findOne(['empresa_id'=>$model->colegio_id,'nivel_id'=>$Prueba->nivel_id,'nombre'=>$Prueba->nombre,'anio_id'=>$model->anio_predeterminado]);

                }else{

                    $PruebaNueva = Prueba::findOne(['empresa_id'=>$model->colegio_id,'nivel_id'=>$Prueba->nivel_id,'nombre'=>$Prueba->nombre]);

                }



                if(!$PruebaNueva){
                    $PruebaNueva=new Prueba;

                    $PruebaNueva->fecha_creacion = new Expression('NOW()');
                    $PruebaNueva->creado_por = Yii::$app->user->identity->id;




                }else{
                    $PruebaNueva->fecha_modificacion = new Expression('NOW()');
                    $PruebaNueva->modificado_por = Yii::$app->user->identity->id;
                }
                $PruebaNueva->nombre = $Prueba->nombre;
                $PruebaNueva->codigo = $Prueba->codigo;
                $PruebaNueva->prueba_categoria_id = $Prueba->prueba_categoria_id;
                $PruebaNueva->ramo_id = $Prueba->ramo_id;
                $PruebaNueva->activo = 1;
                $PruebaNueva->sub_ramo_id = $Prueba->sub_ramo_id;
                $PruebaNueva->muestra_resultados_web = $Prueba->muestra_resultados_web;
                $PruebaNueva->formula_id = $Prueba->formula_id;
                $PruebaNueva->tabla_conversion_id = $Prueba->tabla_conversion_id;
                $PruebaNueva->tiempo = $Prueba->tiempo;
                $PruebaNueva->externo_id = $Prueba->externo_id;
                $PruebaNueva->migrar = $Prueba->migrar;
                $PruebaNueva->solucionario_teorico_id = $Prueba->solucionario_teorico_id;
                $PruebaNueva->solucionario_id = $Prueba->solucionario_id;
                $PruebaNueva->numero_preguntas = $Prueba->numero_preguntas;
                $PruebaNueva->mostrar_escaner = $Prueba->mostrar_escaner;
                $PruebaNueva->migrar_pauta = $Prueba->migrar_pauta;
                $PruebaNueva->mension_comun = $Prueba->mension_comun;
                $PruebaNueva->anio_id = $Prueba->anio_id;


                if($model->anio_predeterminado > 0){
                    $PruebaNueva->anio_id = $model->anio_predeterminado;
                }

                
                $PruebaNueva->empresa_id = $model->colegio_id;
                $PruebaNueva->nivel_id = $Prueba->nivel_id;
                $PruebaNueva->combinar_ejes_ciencias = $Prueba->combinar_ejes_ciencias;
                $PruebaNueva->pagina_alumno_id = $Prueba->pagina_alumno_id;
                $PruebaNueva->pagina_alumno_area_id = $Prueba->pagina_alumno_area_id;
                $PruebaNueva->cantidad_minutos = $Prueba->cantidad_minutos;
                $PruebaNueva->cantidad_intentos = $Prueba->cantidad_intentos;

                $PruebaNueva->save();




                // migro la pauta

                $PruebaPautas = PruebaPauta::find()->where(['prueba_id'=>$Prueba->id,'activo'=>1])->All(); 

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
                return $this->render('@common/views/prueba-clonar/index', [
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

            return $this->render('@common/views/prueba-clonar/index', [
                'model' => $model,
            ]);
        }

    }

    public function actionPruebas()
    {

        $Data = new PruebasComponent();

        echo $Data->PruebasColegio();

    }

    public function actionNivel()
    {

        $Data = new NivelComponent();

        echo $Data->RecibirInformacion();

    }

}
