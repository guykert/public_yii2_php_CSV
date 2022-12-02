<?php

namespace common\controllers;

/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\InformeXPreguntasForm;
use common\components\select\CursosComponent;
use common\components\select\PruebasComponent;
use common\components\informesComponent;
use common\models\PruebaPauta;
use common\models\Empresa;
use common\models\Curso;
use common\models\PruebaAlumno;
use yii\helpers\ArrayHelper;


/**
 * DiaController Implementa las acciones del CRUD para el modeloDia .
 * */ 
class InformeEstadisticasXPreguntaController extends Controller
{

    public $layout = "@common/views/layouts/mantenedor";

    public $rutaAyuda='index';
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
                        'actions' => ['index','combo-curso','prueba'],
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
                        'actions' => ['index','combo-curso','prueba'],
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

    public function actionComboCurso()
    {

        $Cursos = new CursosComponent();

        echo $Cursos->RecibirInformacionInforme();

    }

    public function actionPrueba()
    {

        $Pruebas = new PruebasComponent();

        echo $Pruebas->RecibirInformacionInforme();

    }

    public function actionIndex()
    {


        $model = new InformeXPreguntasForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            // busco la pauta

            //Primero busco el nombre del colegio

            $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$model->prueba_id])->asArray()->all();

            $nombre_colegio = Empresa::findOne([
                'id' => \Yii::$app->user->identity->colegio_predeterminada
            ]);

            $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$model->prueba_id])->asArray()->all();

            if($model->curso_id > 0){

                $nombre_curso = Curso::findOne([
                    'id' => $model->curso_id
                ]);

                

                $titulo = $nombre_colegio->nombre . " " . $nombre_curso->nombre;

                //Busco las pruebas rendidas

                $PruebaAlumno = PruebaAlumno::find()
                ->select(['prueba_alumno.*','prueba_alumno_respuesta.*'])
                ->where(['prueba_id'=>$model->prueba_id,'curso_id'=>$model->curso_id,'prueba_alumno.activo'=>1])
                ->join('INNER JOIN', 'prueba_alumno_respuesta','prueba_alumno.id =prueba_alumno_respuesta.prueba_alumno_id') 
                ->orderBy(['prueba_alumno.nota'=>SORT_DESC])
                ->asArray()
                ->all();

                // foreach ($PruebaAlumno as $key => $PruebaAlu) {
                //     var_dump($PruebaAlu);
                //     echo "<br><br>";
                // }

                $PruebaAlumnoPreguntas = ArrayHelper::index($PruebaAlumno,null, 'numero_pregunta');

                $this->agregarEstructuraPauta($PruebaPauta,$PruebaAlumnoPreguntas);



                return $this->render('@common/views/informe-estadisticas-x-pregunta/estadisticas_por_pregunta_curso', [
                    'PruebaPauta' => $PruebaPauta,
                    'titulo_excel' => $nombre_colegio->nombre . " -  " . $nombre_curso->nombre
                ]);

            }else{


                $titulo = $nombre_colegio->nombre;

                //Busco las pruebas rendidas

                $PruebaAlumno = PruebaAlumno::find()
                ->select(['prueba_alumno.*','prueba_alumno_respuesta.*','curso.nombre as curso_nombre'])
                ->where(['prueba_id'=>$model->prueba_id,'prueba.empresa_id'=>\Yii::$app->user->identity->colegio_predeterminada,'prueba_alumno.activo'=>1])
                ->join('INNER JOIN', 'prueba_alumno_respuesta','prueba_alumno.id =prueba_alumno_respuesta.prueba_alumno_id') 
                ->join('INNER JOIN', 'prueba','prueba_alumno.prueba_id =prueba.id') 
                ->join('INNER JOIN', 'curso','prueba_alumno.curso_id =curso.id') 
                ->orderBy(['prueba_alumno.nota'=>SORT_DESC])
                ->asArray()
                ->all();

                // foreach ($PruebaAlumno as $key => $PruebaAlu) {
                //     var_dump($PruebaAlu);
                //     echo "<br><br>";
                // }



                $PruebaAlumnoPreguntas = ArrayHelper::index($PruebaAlumno,null, 'numero_pregunta');

                $this->agregarEstructuraPauta($PruebaPauta,$PruebaAlumnoPreguntas);




                // Genero la structura de cursos

                



                $PruebaAlumnoPreguntasCursos = ArrayHelper::index($PruebaAlumno,null, 'curso_id');

                $arrayCursos = [];

                foreach ($PruebaAlumnoPreguntasCursos as $key => $PruebaAlumnoPreguntasCurso) {



                    $arrayCurso = [];

                    $arrayCurso['nombre_curso'] = $PruebaAlumnoPreguntasCurso[0]['curso_nombre'];
                    $arrayCurso['PruebaPauta'] = PruebaPauta::find()->where(['prueba_id'=>$model->prueba_id])->asArray()->all();

                    $PruebaAlumnoPreguntas = ArrayHelper::index($PruebaAlumnoPreguntasCurso,null, 'numero_pregunta');



                    $this->agregarEstructuraPauta($arrayCurso['PruebaPauta'],$PruebaAlumnoPreguntas);



                    $arrayCursos[] = $arrayCurso;

                }



                return $this->render('@common/views/informe-estadisticas-x-pregunta/estadisticas_por_pregunta_colegio', [
                    'PruebaPauta' => $PruebaPauta,
                    'titulo_excel' => $nombre_colegio->nombre,
                    'arrayCursos' => $arrayCursos
                ]);

            }





        } else {

            return $this->render('@common/views/informe-estadisticas-x-pregunta/index', [
                'model' => $model,
            ]);

        }


    }

    public function agregarEstructuraPauta(&$PruebaPauta,$PruebaAlumnoPreguntas)
    {

        foreach ($PruebaPauta as $key => &$PruebaPa) {

			// Para calcular el nivel de discriminación se realizan dos sumatorias uno que calcule las buenas 
			// a la parte superior de los alumnos y uno que lo haga a la parte inferior

			// calculo la mitad

			// la mitad se redondea por lo que cuando es un numero impar hay un valor que no entra en el calculo



            $PruebaPa["alternativa_a"] = 0;
            $PruebaPa["alternativa_b"] = 0;
            $PruebaPa["alternativa_c"] = 0;
            $PruebaPa["alternativa_d"] = 0;
            $PruebaPa["alternativa_e"] = 0;

            $PruebaPa["alternativa_buenas"] = 0;
            $PruebaPa["alternativa_malas"] = 0;
            $PruebaPa["alternativa_omitidas"] = 0;
            $PruebaPa["alternativa_nivel_disc"] = 0;
            $PruebaPa["alternativa_nivel_dific"] = 0;

            $cantBuenasSup = 0;

            $cantBuenasInf = 0;

            $cantidad_total = 0;

            foreach ($PruebaAlumnoPreguntas[$PruebaPa["numero_pregunta"]] as $key => $alternativas) {

                $cantidadniv_disc = count($alternativas) / 2;

                $cantidadniv_disc = floor($cantidadniv_disc);

                $cantidad_total = count($alternativas);


                if($alternativas["respuesta"] == "a" || $alternativas["respuesta"] == "A"){
                    $PruebaPa["alternativa_a"]++;
                }
                if($alternativas["respuesta"] == "b" || $alternativas["respuesta"] == "B"){
                    $PruebaPa["alternativa_b"]++;
                }
                if($alternativas["respuesta"] == "c" || $alternativas["respuesta"] == "C"){
                    $PruebaPa["alternativa_c"]++;
                }
                if($alternativas["respuesta"] == "d" || $alternativas["respuesta"] == "D"){
                    $PruebaPa["alternativa_d"]++;
                }
                if($alternativas["respuesta"] == "e" || $alternativas["respuesta"] == "E"){
                    $PruebaPa["alternativa_e"]++;
                }

                if($PruebaPa["correcta"] == $alternativas["respuesta"]){

                    if(($key + 1) <= $cantidadniv_disc ){

                        $cantBuenasInf++;
    
                    }else{
    
                        $cantBuenasSup++;

                    }

                    $PruebaPa["alternativa_buenas"]++;
                }else{
                    if($alternativas["respuesta"] == "" || $alternativas["respuesta"] == "-"){
                        $PruebaPa["alternativa_omitidas"]++;
                    }else{
                        $PruebaPa["alternativa_malas"]++;
                    }
                }



            }



            $PruebaPa["alternativa_a"] = $this->porcentajes($PruebaPa["alternativa_a"],count($PruebaPauta));

            $PruebaPa["alternativa_b"] = $this->porcentajes($PruebaPa["alternativa_b"],count($PruebaPauta));
            
            $PruebaPa["alternativa_c"] = $this->porcentajes($PruebaPa["alternativa_c"],count($PruebaPauta));
            
            $PruebaPa["alternativa_d"] = $this->porcentajes($PruebaPa["alternativa_d"],count($PruebaPauta));
            
            $PruebaPa["alternativa_e"] = $this->porcentajes($PruebaPa["alternativa_e"],count($PruebaPauta));
            
            $PruebaPa["alternativa_buenas"] = $this->porcentajes($PruebaPa["alternativa_buenas"],count($PruebaPauta));
            
            $PruebaPa["alternativa_malas"] = $this->porcentajes($PruebaPa["alternativa_malas"],count($PruebaPauta));
            
            $PruebaPa["alternativa_omitidas"] = $this->porcentajes($PruebaPa["alternativa_omitidas"],count($PruebaPauta));
            

            //$PruebaPa["alternativa_nivel_disc"] = $this->alternativaNivelDisc($PruebaPa,count($PruebaPauta));

            // $PruebaPa["alternativa_nivel_dific"] = $this->porcentajes($PruebaPa["alternativa_nivel_dific"],count($PruebaPauta));
            

			$cantDiscRest = $cantBuenasSup - $cantBuenasInf;
			$cantDiscDiv = $cantidad_total / 2;

            $PruebaPa["alternativa_nivel_dific"] = $this->porcentajes($cantDiscRest,$cantDiscDiv);
            
            
            //$cantDisc = round((($cantDisc) / ($cantidadniv_disc)),3);
            $PruebaPa["alternativa_nivel_disc"] = $this->porcentajes($cantDiscRest,$cantidad_total);;


        }
        


    }



    public function porcentajes($valor_parcial=0,$valor_total=0)
    {

        if($valor_total == "0" || $valor_parcial == "0"){

            return 0;

        }else{

            return round((($valor_parcial * 100) / $valor_total),2);

        }


    }
    
    public function division($valor1=0,$valor2=0)
    {

        if($valor1 == "0" || $valor2 == "0"){

            return 0;

        }else{

            return round((((float)$valor1) / ((float)$valor2)),3);

        }


    }

}
