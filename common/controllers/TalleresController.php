<?php

namespace common\controllers;

/* llama a los controladores */
use Yii;
use common\models\Talleres;
use common\models\search\TalleresSearch;

use common\components\select\TipoTallerComponent;
use common\components\select\SubRamoMultipleComponent;
use common\components\select\SubTiposTalleresComponent;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\Curso;
use common\models\TipoTalleres;
use common\models\SubRamo;
use common\models\HorarioCurso;
use common\models\Dia;
use common\models\HorarioSede;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use common\models\TalleresPasos;
use common\components\select\TallerComponent;
use common\models\UsuarioTaller;
use yii\data\SqlDataProvider;
use common\models\AsistenciaTaller;
use common\components\Fechas;
use common\models\AsistenciaAlumnosTaller;
use common\models\Alumno;
use common\components\CalendarioTalleresComponent;
use common\models\informes\LibroDigitalForm;
use common\models\TallerSubTipo;

/**
 * TalleresController Implementa las acciones del CRUD para el modeloTalleres .
 * */
class TalleresController extends Controller
{

    public $layout = "general";
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
                        'actions' => ['index','create','update','delete','codigo',
                        'codigo-taller','horariocurso','tipos-talleres','sub-ramo',
                        'sub-tipos-talleres','seleccionar-taller','talleres','asignar-alumnos',
                        'crear-fecha-taller','nueva-fecha-taller','borrar-asistencia','ver-asistencia',
                        'asistencia-taller','index-nuevo','index-pasados','asistencia','desactiva-usuario',
                        'asignar-alumno','informe-global','excel-informe-talleres','informe-sede','informe-talleres-alumnos','asistenciainfor','email'],
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
                        'actions' => ['index','create','update','delete','codigo','codigo-taller','horariocurso',
                        'tipos-talleres','sub-ramo','sub-tipos-talleres','seleccionar-taller','talleres','asignar-alumnos',
                        'crear-fecha-taller','nueva-fecha-taller','borrar-asistencia','ver-asistencia','asistencia-taller',
                        'index-nuevo','index-pasados','asistencia','desactiva-usuario','asignar-alumno','informe-global',
                        'excel-informe-talleres','informe-sede','recoleccion-taller','informe-talleres-alumnos','asistenciainfor','email'],
                        'allow' => true,
                        'roles' => ['CreaTalleres'],
                        'matchCallback' => function ($rule, $action) {
                            return Usuario::isActive();
                        },
                        //esto es para realizar un bloqueo por fechas
                        // 'matchCallback' => function ($rule, $action) {
                        //     return date('d-m') === '28-07';
                        // }
                    ],

                    [
                        'actions' => ['index','create','update','delete','codigo','codigo-taller','horariocurso',
                        'tipos-talleres','sub-ramo','sub-tipos-talleres','seleccionar-taller','talleres','asignar-alumnos',
                        'crear-fecha-taller','nueva-fecha-taller','borrar-asistencia','ver-asistencia','asistencia-taller',
                        'index-nuevo','index-pasados','asistencia','desactiva-usuario','asignar-alumno','informe-global',
                        'excel-informe-talleres','informe-sede','recoleccion-taller','informe-talleres-alumnos','index-normal','asistenciainfor','email'],
                        'allow' => true,
                        'roles' => ['administrador'],
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

    public function actionInformeSede()
    {

        $model = new LibroDigitalForm(['scenario' => 'asistencia']);

        $Fechas = new Fechas();
    

        if ($model->load(Yii::$app->request->post())) {

            $Fechas->fecha_inicio = $model->param_fecha1;

            $Fechas->fecha_final = $model->param_fecha2;

            return $this->redirect(['excel-informe-talleres', 'fecha_inicio' => $Fechas->fecha_inicio, 'fecha_final' => $Fechas->fecha_final,'sede_id' => Yii::$app->user->identity->sede_predeterminada]);

        }else{

            // en caso de no venir una fecha indicada se tomará por defecto los ultimos 30 días

            $Fechas->obtenerFechaUnaSemana();

            $model->param_fecha1 = $Fechas->fecha_inicio;

            $model->param_fecha2 = $Fechas->fecha_final;

            $Fechas->arregloDiasAbilesEntreFechas();

        }

        return $this->render('@common/views/talleres/informe_general',[
                'model'=>$model,
                'Fechas'=>$Fechas,
                ]);

    }

    public function actionAsistenciainfor(){
        $fecha_inicio="2019-11-01";
        $fecha_final="2019-12-31";


        //lectura de alumnos inscritos a talleres de recuperacion 68
        $sql=UsuarioTaller::find()
        ->distinct()
        ->select(['usuario_taller.usuario_id','u.rut'])
        ->join('INNER JOIN','usuario as u','u.id=usuario_taller.usuario_id')
        ->join('INNER JOIN','taller as t','t.id=usuario_taller.taller_id')
        ->where(['t.anio_id'=>4,'usuario_taller.activo'=>1, 't.activo'=>1,'t.tipo_talleres_id'=>68])
        ->orderBy('usuario_taller.usuario_id')
        ->asArray()
        ->all();
        //var_dump($sql);exit;
        
        $datos=[];
        foreach ($sql as $dat) {
            
                $arreglo=[];    
                $cantidad=AsistenciaAlumnosTaller::find()
                
                //->select(['tt.nombre','t.sede_id'])
                ->join('INNER JOIN','taller as t','t.id=asistencia_alumnos_taller.taller_id')
                ->join('INNER JOIN','asistencia_taller as at','at.id=asistencia_alumnos_taller.taller_id')
                ->where(['asistencia_alumnos_taller.usuario_id'=>$dat['usuario_id'],'asistencia_alumnos_taller.tipo_asistencia_id'=>1, 'asistencia_alumnos_taller.activo'=>1])
                ->andWhere(['>=', 'asistencia_alumnos_taller.fecha', $fecha_inicio ])

                ->andWhere(['<=', 'asistencia_alumnos_taller.fecha', $fecha_final ])

                ->orderBy('t.id')
                ->count();
                // ->asArray()
                // ->all();
               $arreglo=['rut'=>$dat['rut'],'cantidad'=>$cantidad];
               array_push($datos, $arreglo);
               // if ($cont==30) {
               //     var_dump($datos);
               //     exit;
               // }
        }


        return $this->render('@common/views/talleres/excel',[
               'datos'=>$datos,
               ]);




    }

    public function actionInformeGlobal()
    {
        ini_set('max_execution_time', 1000000);
        ini_set('memory_limit','4048M');
        
        $model = new LibroDigitalForm(['scenario' => 'asistencia']);

        $Fechas = new Fechas();
    

        if ($model->load(Yii::$app->request->post())) {

            $Fechas->fecha_inicio = $model->param_fecha1;

            $Fechas->fecha_final = $model->param_fecha2;

            return $this->redirect(['excel-informe-talleres', 'fecha_inicio' => $Fechas->fecha_inicio, 'fecha_final' => $Fechas->fecha_final]);

        }else{

            // en caso de no venir una fecha indicada se tomará por defecto los ultimos 30 días

            $Fechas->obtenerFechaUnaSemana();

            $model->param_fecha1 = $Fechas->fecha_inicio;

            $model->param_fecha2 = $Fechas->fecha_final;

            $Fechas->arregloDiasAbilesEntreFechas();

        }

        return $this->render('@common/views/talleres/informe_general',[
                'model'=>$model,
                'Fechas'=>$Fechas,
                ]);

    }

    public function actionExcelInformeTalleres($fecha_inicio,$fecha_final,$sede_id="")
    {



        // Primero busco el cronograma oficial

        $sql  = Talleres::find()
                    ->select(['taller.profesor_id','taller.nombre','taller.id taller_id','taller.cupo','taller.capacidad','asistencia_taller.fecha_asistencia','asistencia_taller.presentes','asistencia_taller.ausentes','asistencia_taller.atrasos','sede.nombre as nombre_sede','tipo_taller.nombre as tipo_taller_nombre','taller.taller_sub_tipo_id as taller_sub_tipo_array'])
                    ->where(['taller.activo'=> true])
                    ->join('INNER JOIN', 'sede','sede.id =taller.sede_id and sede.activo=1')
                    ->join('INNER JOIN', 'tipo_taller','tipo_taller.id =taller.tipo_talleres_id and tipo_taller.activo=1')
                    ->join('INNER JOIN', 'asistencia_taller','asistencia_taller.taller_id =taller.id and asistencia_taller.activo=1')
                    ;

        if ($sede_id > 0) {
             $sql->andWhere(['taller.sede_id'=>$sede_id]);
        }

        $sql->andWhere(['>=', 'asistencia_taller.fecha_asistencia', $fecha_inicio ]);

        $sql->andWhere(['<=', 'asistencia_taller.fecha_asistencia', $fecha_final ]);

        $Talleres = $sql->asArray()->all();



        // Esto es para recalcular los cupos

        // $CalendarioTalleres = new CalendarioTalleresComponent();

        foreach ($Talleres as $key => &$Taller) {

            $sql=Usuario::find()
            ->select(['concat(usuario.apellido_paterno," ",usuario.apellido_materno," ",usuario.nombre) as nombre'])
            ->where(['id'=>$Taller["profesor_id"],'activo'=>1])
            ->one();
            $Taller["profesor"] = "";
            if($sql){
                $Taller["profesor"]=$sql->nombre;
            }
            

            $Taller["taller_sub_tipo_array"] = unserialize($Taller["taller_sub_tipo_array"]);

            $Taller["taller_sub_tipo_array"] = TallerSubTipo::find()->select('nombre')->where(['id'=>$Taller["taller_sub_tipo_array"],'activo'=>1])->all();

            $taller_sub_tipo_array = "";

            foreach ($Taller["taller_sub_tipo_array"] as $key => $taller_sub_tipo) {
                if ($taller_sub_tipo_array == "") {
                    $taller_sub_tipo_array .= $taller_sub_tipo->nombre;
                }else{
                    $taller_sub_tipo_array .= " - " .  $taller_sub_tipo->nombre;
                }
                
            }

            // Esto es para recalcular los cupos

            // if ((!$Taller["capacidad"])) {

            //     $Talleres_resp = $CalendarioTalleres->recalcularCuposProblemas($Taller["taller_id"]);

            // }

            $Taller["taller_sub_tipo_array"] = $taller_sub_tipo_array;
        }


        $Talleres = ArrayHelper::index($Talleres, null , 'taller_id');


        return $this->render('@common/views/talleres/excel_informe_talleres',[
                'Talleres'=>$Talleres,
                ]);

    }

    public function actionAsignarAlumno()
    {

        $mensage_adicional = "";
        $taller_adicional = "";

        $rut = Yii::$app->request->post('rut');
        $taller_id = Yii::$app->request->post('taller_id');
        $usuario = Alumno::find()->where(['usuario.rut'=>$rut,'usuario.activo'=>1,'rol_usuario.item_name'=>'alumno'])
                                    ->join('INNER JOIN','ficha_matricula','ficha_matricula.usuario_id = usuario.id and ficha_matricula.activo = 1')
                                    ->join('INNER JOIN','rol_usuario','rol_usuario.user_id = usuario.id')
                                    ->one();

        $estado = 0 ;

        if ($estado == 0) {

            if(!$usuario){
                $estado = 6 ;
            }
            
        }

        $CalendarioTalleres = new CalendarioTalleresComponent();

        $Talleres = $CalendarioTalleres->recalcularCupos($taller_id);

        $Talleres = Talleres::findOne($taller_id);

        // confirmo si el usuario tiene los sub-ramos necesarios para este taller



        if ($estado == 0) {

            


            $taller_comparar = Talleres::find()
                ->select(['taller.id','taller.nombre','taller.sede_id','taller.anio_id','taller_sub_tipo_id','tipo_talleres_id','sub_ramo_id_array','orientacion','(select usuario_id from usuario_taller as ut where ut.taller_id = taller.id and ut.activo = 1 and usuario_id = ' . $usuario->id . ') as inscrito'])
            ->where(['taller.activo'=>1,'taller.anio_id'=>$Talleres->anio_id,'taller.sede_id'=>$Talleres->sede_id,'tipo_talleres_id'=>$Talleres->tipo_talleres_id,'taller_sub_tipo_id'=>$Talleres->taller_sub_tipo_id]);

            $taller_comparar->andWhere(['not', ['id'=>$taller_id]]);

            $taller_comparar = $taller_comparar->asArray()->one();


            if (count($taller_comparar) > 0) {

                if ($taller_comparar['inscrito'] > 0) {

                    $mensage_adicional = "Taller : " . $taller_comparar['nombre'];
                    $taller_adicional = $taller_comparar['id'];
                    $estado = 4 ;
                }

            }
        }




        if ($estado == 0) {
            if ($Talleres->cupo < $Talleres->capacidad) {

                
                if($usuario){
                    $taller = UsuarioTaller::find()->where(['usuario_id'=>$usuario->id,'taller_id'=>$taller_id,'activo'=>1])->one();
                    if($taller){
                    $estado = 2 ;
                    }else{
                    $usuarioTaller = new UsuarioTaller();
                    $usuarioTaller->usuario_id = $usuario->id;
                    $usuarioTaller->taller_id = $taller_id;
                    $usuarioTaller->activo = 1 ;
                    $usuarioTaller->creado_por = Yii::$app->user->identity->id;
                    if($usuarioTaller->save()){

                    $estado = 1 ;

                    }
                    }



                    $CalendarioTalleres->recalcularCupos($taller_id);

                }

            }else{
                $estado = 3 ;
            }
        }


      echo Json::encode(['estado'=>$estado,'mensage_adicional'=>$mensage_adicional,'taller_adicional'=>$taller_adicional]);
      return ;

    }

    public function actionIndexPasados()
    {

        $localizacion = "index-pasados";

        $CalendarioTalleres = new CalendarioTalleresComponent();

        $CalendarioTalleres->ConstruirCalendarioAcademico(Yii::$app->user->identity->id,true);

        return $this->render('@common/views/talleres/index_nuevo',[
            'CalendarioTalleres'=>$CalendarioTalleres,
            'localizacion'=>$localizacion,
            ]);

    }

    public function actionDesactivaUsuario($id,$taller_id,$orientacion="",$ramo_id="",$localizacion="")
    {

        $model = UsuarioTaller::find()->where(['usuario_id'=>$id,'taller_id'=>$taller_id,'activo'=>1])->all();


        foreach ($model as $key => $value) {
            $value->activo = 0 ;
            $value->save();
        }

        $CalendarioTalleres = new CalendarioTalleresComponent();

        $Talleres = $CalendarioTalleres->recalcularCupos($taller_id);

        return $this->redirect(['asignar-alumnos','talleres_id'=>$taller_id,'orientacion'=>$orientacion,'ramo_id'=>$ramo_id,'localizacion'=>$localizacion]);

    }

    public function actionIndexNuevo()
    {

        $localizacion = "index-nuevo";

        $CalendarioTalleres = new CalendarioTalleresComponent();

        $CalendarioTalleres->ConstruirCalendarioAcademico(Yii::$app->user->identity->id);

        return $this->render('@common/views/talleres/index_nuevo',[
            'CalendarioTalleres'=>$CalendarioTalleres,
            'localizacion'=>$localizacion,
            ]);

    }

    public function actionSeleccionarTaller($talleres_id="",$orientacion="",$ramo_id="")
    {

        $TalleresPasos = new TalleresPasos();

        if ($TalleresPasos->load(Yii::$app->request->post())) {

            if($TalleresPasos->validate()){
                return $this->redirect(['crear-fecha-taller','talleres_id'=>$TalleresPasos->talleres_id,'orientacion'=>$TalleresPasos->orientacion,'ramo_id'=>$TalleresPasos->ramo_id]);
            }


        }

        if ($talleres_id > 0) {
            $TalleresPasos->talleres_id = $talleres_id;
        }

        if ($orientacion > 0) {
            $TalleresPasos->orientacion = $orientacion;
        }

        if ($ramo_id > 0) {
            $TalleresPasos->ramo_id = $ramo_id;
        }

        return $this->render('@common/views/talleres/seleccionar-taller', [
            'model' => $TalleresPasos,
        ]);

    }

    public function actionAsignarAlumnos($talleres_id,$orientacion="",$ramo_id="",$localizacion="")
    {



        $taller = Talleres::find()->where(['id'=>$talleres_id])->one();
        $model = new UsuarioTaller();
        $data = new SqlDataProvider(['sql' => 'select u.nombre, u.apellido_paterno,u.apellido_materno,u.rut,u.id,ut.taller_id
                                      from usuario_taller ut
                                      inner join usuario u on u.id = ut.usuario_id
                                      where ut.activo=1  and ut.taller_id=:taller_id
                                      order by u.apellido_paterno',
                                      'params' => [':taller_id' => $taller->id],
                                        'pagination' => [
                                            'pageSize' => 200,
                                        ],
                                      ]);



        return $this->render('@common/views/talleres/asignar-alumnos', [
            'model' => $model,
            'taller'=>$taller,
            'data'=>$data,
            'talleres_id'=>$talleres_id,
            'orientacion'=>$orientacion,
            'ramo_id'=>$ramo_id,
            'localizacion'=>$localizacion,
        ]);

    }

    public function actionCrearFechaTaller($talleres_id,$orientacion="",$ramo_id="",$localizacion="")
    {

        $alumnos = UsuarioTaller::find()->where(['usuario_taller.taller_id'=>$talleres_id,'usuario_taller.activo'=>1,'usuario.activo'=>1])
            ->join('INNER JOIN','usuario','usuario.id = usuario_taller.usuario_id')
            ->all();
        $fecha='';

        $nombre_taller = Talleres::find()->where(['id'=>$talleres_id])->one();

        $taller = AsistenciaTaller::find()->where(['taller_id'=>$talleres_id,'activo'=>1])->orderBy('asistencia_taller.fecha_asistencia','asc')->all();



        return $this->render('@common/views/talleres/crear-fecha-taller',[
            'taller'=>$taller,
            'taller_id'=>$talleres_id,
            'nombre_taller'=>$nombre_taller,
            'talleres_id'=>$talleres_id,
            'orientacion'=>$orientacion,
            'ramo_id'=>$ramo_id,
            'localizacion'=>$localizacion,
        ]);


        // $taller = Talleres::find()->where(['id'=>$talleres_id])->one();
        // $model = new UsuarioTaller();
        // $data = new SqlDataProvider(['sql' => 'select u.nombre, u.apellido_paterno,u.apellido_materno,u.rut,u.id,ut.taller_id
        //                               from usuario_taller ut
        //                               inner join usuario u on u.id = ut.usuario_id
        //                               where ut.activo=1  and ut.taller_id=:taller_id
        //                               order by u.apellido_paterno',
        //                               'params' => [':taller_id' => $taller->id],
                                      
        //                               ]);


        // return $this->render('@common/views/talleres/asignar-alumnos', [
        //     'model' => $model,
        //     'taller'=>$taller,
        //     'data'=>$data,
        //     'talleres_id'=>$talleres_id,
        //     'orientacion'=>$orientacion,
        //     'ramo_id'=>$ramo_id,
        // ]);

    }

    public function actionSubTiposTalleres()
    {

        $SubTiposTalleres = new SubTiposTalleresComponent();

        echo $SubTiposTalleres->RecibirInformacion();

    }

    public function actionIndexNormal()
    {

        /**
        * Lista todo el modelo Talleres.
        * no hay variable de retorno
        */
        $searchModel = new TalleresSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('@common/views/talleres/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);



    }

    public function actionIndex()
    {

        /**
        * Lista todo el modelo Talleres.
        * no hay variable de retorno
        */
        // $searchModel = new TalleresSearch();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        // return $this->render('@common/views/talleres/index', [
        //     'searchModel' => $searchModel,
        //     'dataProvider' => $dataProvider,
        // ]);

        return $this->redirect(['index-nuevo']);

    }

    public function actionView($id)
    {

        /**
        * Muestra un modelo único Talleres.
        * @param integer $id
        * no tiene variable de retorno
        */
        return $this->render('@common/views/talleres/view', [
            'model' => $this->findModel($id),
        ]);

    }

    public function actionAsistencia($id,$taller_id,$estado,$fecha)
    {

        $fechaDia=date('Y-m-d',strtotime($fecha));
   
        if($estado == '1')
        {
            $asistencia =AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'usuario_id'=>$id,'fecha'=>$fechaDia])->one();


            if(!$asistencia)
            { 
              $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'usuario_id'=>$id,])->andWhere(['is', 'fecha', null])->one();

              if(!$alumnos){
                $model = new AsistenciaAlumnosTaller();
                $model->usuario_id = $id;
                $model->taller_id = $taller_id;
                $model->tipo_asistencia_id = 1  ;
                $model->creado_por = Yii::$app->user->identity->id;
                $model->fecha = $fechaDia;
                $model->save();
              }else{
                $estados = 1 ;
                $alumnos->tipo_asistencia_id = 2 ;
                $alumnos->fecha = $fechaDia;
                $alumnos->modificado_por = Yii::$app->user->identity->id;
                $alumnos->save();
              }
              


            }else{
                $estados = 1 ;
                $asistencia->fecha = $fechaDia;
                $asistencia->tipo_asistencia_id = 2 ;
                $asistencia->modificado_por = Yii::$app->user->identity->id;
                $asistencia->save();
            }

            return Json::encode(['estados'=>$estados]);


        }elseif($estado =='2'){

            $asistencia =AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'usuario_id'=>$id,'fecha'=>$fechaDia])->one();

            if(!$asistencia)
            {
              $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'usuario_id'=>$id,])->andWhere(['is', 'fecha', null])->one();
              
              if(!$alumnos){
                $estados = 2 ;
                $model = new AsistenciaAlumnosTaller();
                $model->usuario_id = $id;
                $model->taller_id = $taller_id;
                $model->tipo_asistencia_id = 3  ;
                $model->creado_por = Yii::$app->user->identity->id;
                $model->fecha = $fechaDia;
                $model->save();
              }else{
                $estados = 2 ;
                $alumnos->tipo_asistencia_id = 3 ;
                $alumnos->fecha = $fechaDia;
                $alumnos->modificado_por = Yii::$app->user->identity->id;
                $alumnos->save();
              }
              
            }else{
                $estados = 2 ;
                $asistencia->fecha = $fechaDia;
                $asistencia->tipo_asistencia_id = 3 ;
                $asistencia->modificado_por = Yii::$app->user->identity->id;
                $asistencia->save();
            }


            return Json::encode(['estados'=>$estados]);


        }elseif($estado == '3'){

            $asistencia =AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'usuario_id'=>$id,'fecha'=>$fechaDia])->one();

            if(!$asistencia)
            {
              $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'usuario_id'=>$id,])->andWhere(['is', 'fecha', null])->one();
              if(!$alumnos){
                  $estados = 3 ;
                $model = new AsistenciaAlumnosTaller();
                $model->usuario_id = $id;
                $model->taller_id = $taller_id;
                $model->tipo_asistencia_id = 1  ;
                $model->creado_por = Yii::$app->user->identity->id;
                $model->fecha = $fechaDia;
                $model->save();
              }else{
                $estados = 3 ;
                $alumnos->tipo_asistencia_id = 1 ;
                $alumnos->fecha = $fechaDia;
                $alumnos->modificado_por = Yii::$app->user->identity->id;
                $alumnos->save();
              }
            
            }else{
                $estados = 3 ;
                $asistencia->fecha = $fechaDia;
                $asistencia->tipo_asistencia_id = 1 ;
                $asistencia->modificado_por = Yii::$app->user->identity->id;
                $asistencia->save();
            }
            return Json::encode(['estados'=>$estados]);
        }

    }

    public function actionAsistenciaTaller($talleres_id="",$orientacion="",$ramo_id="",$localizacion="")
    {

          $taller_id = Yii::$app->request->post('taller_id');


          $fecha_anterior=date('Y-m-d',strtotime(Yii::$app->request->post('fechaDia')));
          $fechaDia=date('Y-m-d',strtotime(Yii::$app->request->post('fechaDia')));



          if($fecha_anterior)
          {



            if($fecha_anterior == $fechaDia){
                $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia])->all();


                if(!$alumnos){
                  $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id])->andWhere(['is', 'fecha', null])->all();
                }

                $estado = 1 ;

                foreach($alumnos as $alumno){
                  $alumno->activo = 1 ;
                  $alumno->fecha = $fechaDia;
                  $alumno->save();
                }

                $taller = AsistenciaTaller::find()->where(['taller_id'=>$taller_id,'activo'=>1,'fecha_asistencia'=>$fechaDia])->one();
                $presentes = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia,'tipo_asistencia_id'=>1])->count();
                $ausentes = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia,'tipo_asistencia_id'=>2])->count();
                $atrasados = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia,'tipo_asistencia_id'=>3])->count();

                if(!$taller){
                  $taller = new  AsistenciaTaller();
                  $taller->activo = 1 ;
                  $taller->taller_id = $taller_id ;
                  $taller->presentes = $presentes ;
                  $taller->ausentes = $ausentes ;
                  $taller->atrasos = $atrasados ;
                  $taller->creado_por = Yii::$app->user->identity->id;
                  $taller->fecha_asistencia = $fechaDia ;
                  if($taller->save()){
                    foreach($alumnos as $alumno){
                      $alumno->asistencia_taller_id = $taller->id;
                      $alumno->save();
                    }
                  }
                }else{
                  $taller->presentes = $presentes ;
                  $taller->ausentes = $ausentes ;
                  $taller->atrasos = $atrasados ;
                  $taller->modificado_por = Yii::$app->user->identity->id;
                  $taller->fecha_asistencia = $fechaDia ;
                  $taller->save();
                }
            }else{

                $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fecha_anterior])->all();
                if(!$alumnos){
                    $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id])->andWhere(['is', 'fecha', null])->all();
                }

                $estado = 1 ;

                foreach($alumnos as $alumno){
                    $alumno->activo = 1 ;
                    $alumno->fecha = $fechaDia;
                    $alumno->save();
                }

                $taller = AsistenciaTaller::find()->where(['taller_id'=>$taller_id,'activo'=>1,'fecha_asistencia'=>$fecha_anterior])->one();
                $presentes = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fecha_anterior,'tipo_asistencia_id'=>1])->count();
                $ausentes = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fecha_anterior,'tipo_asistencia_id'=>2])->count();
                $atrasados = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fecha_anterior,'tipo_asistencia_id'=>3])->count();

                if(!$taller){
                    $taller = new  AsistenciaTaller();
                    $taller->activo = 1 ;
                    $taller->taller_id = $taller_id ;
                    $taller->presentes = $presentes ;
                    $taller->ausentes = $ausentes ;
                    $taller->atrasos = $atrasados ;
                    $taller->creado_por = Yii::$app->user->identity->id;
                    $taller->fecha_asistencia = $fechaDia ;
                    if($taller->save()){
                      foreach($alumnos as $alumno){
                        $alumno->asistencia_taller_id = $taller->id;
                        $alumno->save();
                      }
                    }
                }else{
                    $taller->presentes = $presentes ;
                    $taller->ausentes = $ausentes ;
                    $taller->atrasos = $atrasados ;
                    $taller->modificado_por = Yii::$app->user->identity->id;
                    $taller->fecha_asistencia = $fechaDia ;
                    $taller->save();
                }
            }

          }else{
            $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia])->all();
            if(!$alumnos){
              $alumnos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id])->andWhere(['is', 'fecha', null])->all();
            }

            $estado = 1 ;

            foreach($alumnos as $alumno){
              $alumno->activo = 1 ;
              $alumno->fecha = $fechaDia;
              $alumno->save();
            }

            $taller = AsistenciaTaller::find()->where(['taller_id'=>$taller_id,'activo'=>1,'fecha_asistencia'=>$fechaDia])->one();
            $presentes = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia,'tipo_asistencia_id'=>1])->count();
            $ausentes = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia,'tipo_asistencia_id'=>2])->count();
            $atrasados = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$taller_id,'fecha'=>$fechaDia,'tipo_asistencia_id'=>3])->count();

            if(!$taller){
              $taller = new  AsistenciaTaller();
              $taller->activo = 1 ;
              $taller->taller_id = $taller_id ;
              $taller->presentes = $presentes ;
              $taller->ausentes = $ausentes ;
              $taller->atrasos = $atrasados ;
              $taller->creado_por = Yii::$app->user->identity->id;
              $taller->fecha_asistencia = $fechaDia ;
              if($taller->save()){
                foreach($alumnos as $alumno){
                  $alumno->asistencia_taller_id = $taller->id;
                  $alumno->save();
                }
              }
            }else{
              $taller->presentes = $presentes ;
              $taller->ausentes = $ausentes ;
              $taller->atrasos = $atrasados ;
              $taller->modificado_por = Yii::$app->user->identity->id;
              $taller->fecha_asistencia = $fechaDia ;
              $taller->save();
            }
          }





          echo Json::encode(['estado'=>$estado]);
          return ;

    }

    public function actionVerAsistencia($taller_id,$talleres_id,$fecha,$orientacion="",$ramo_id="",$localizacion=""){

        $nombre_taller = Talleres::find()->where(['id'=>$talleres_id])->one();



        $model = UsuarioTaller::find()->where(['usuario_taller.taller_id'=>$talleres_id,'usuario_taller.activo'=>1,'fecha'=>$fecha])
                ->select(['usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.rut','usuario.id','asistencia_alumnos_taller.tipo_asistencia_id',
                        'asistencia_alumnos_taller.activo as activo_asistencia'])
                ->join('INNER JOIN','asistencia_alumnos_taller','asistencia_alumnos_taller.usuario_id = usuario_taller.usuario_id and asistencia_alumnos_taller.activo = 1 and asistencia_alumnos_taller.taller_id = usuario_taller.taller_id')
                ->join('INNER JOIN','usuario','usuario.id = asistencia_alumnos_taller.usuario_id')
                ->orderBy(['usuario.apellido_paterno'=>SORT_ASC])
                ->asArray()
                ->all();


        $asistencia_taller = Talleres::find()->where(['id'=>$talleres_id])->one();


        $alumnos = UsuarioTaller::find()->where(['usuario_taller.taller_id'=>$talleres_id,'usuario_taller.activo'=>1])
                ->join('INNER JOIN','usuario','usuario.id = usuario_taller.usuario_id')
                ->all();




        if (count($model) == 0 || (count($model) < count($alumnos))) {





            foreach ($alumnos as  $alumno) {

                $datos = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$talleres_id,'usuario_id'=>$alumno->usuario_id,'fecha'=>$fecha])->all();



                if(!$datos){



                    $AsistenciaAlumnosTaller = new AsistenciaAlumnosTaller();
                    $AsistenciaAlumnosTaller->usuario_id = $alumno->usuario_id;
                    $AsistenciaAlumnosTaller->taller_id = $talleres_id;
                    $AsistenciaAlumnosTaller->tipo_asistencia_id = 1  ;
                    $AsistenciaAlumnosTaller->activo = 0 ;
                    $AsistenciaAlumnosTaller->creado_por = Yii::$app->user->identity->id;
                    $AsistenciaAlumnosTaller->fecha = $fecha;

                    $AsistenciaAlumnosTaller->save();
                }

            }


            $model = UsuarioTaller::find()->where(['usuario_taller.taller_id'=>$talleres_id,'usuario_taller.activo'=>1,'fecha'=>$fecha])
            ->select(['usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.rut','usuario.id','asistencia_alumnos_taller.tipo_asistencia_id',
                    'asistencia_alumnos_taller.activo as activo_asistencia'])
            ->join('INNER JOIN','asistencia_alumnos_taller','asistencia_alumnos_taller.usuario_id = usuario_taller.usuario_id and asistencia_alumnos_taller.taller_id = usuario_taller.taller_id')
            ->join('INNER JOIN','usuario','usuario.id = asistencia_alumnos_taller.usuario_id')
            ->orderBy(['usuario.apellido_paterno'=>SORT_ASC])
            ->asArray()
            ->all();

        }


        return $this->render('@common/views/talleres/asistencia',[
            'model'=>$model,
            'taller_id'=>$taller_id,
            'fecha'=>$fecha,
            'nombre_taller'=>$nombre_taller,
            'talleres_id'=>$talleres_id,
            'orientacion'=>$orientacion,
            'ramo_id'=>$ramo_id,
            'localizacion'=>$localizacion,
        ]);

    }

    public function actionBorrarAsistencia($taller_id,$talleres_id,$fecha,$orientacion="",$ramo_id="")
    {

            $asistencia_taller = AsistenciaTaller::find()->where(['id'=>$taller_id,'fecha_asistencia'=>$fecha])->one();

            $asistencia_taller->activo = 0;

            if($asistencia_taller->save()){
                $alumnos_taller = AsistenciaAlumnosTaller::find()->where(['taller_id'=>$talleres_id,'fecha'=>$fecha,'activo'=>1])
                        ->all();

                foreach($alumnos_taller as $alumnos){
                    $alumnos->activo = 0 ;
                    $alumnos->save();
                }
            }


            return $this->redirect(['crear-fecha-taller','talleres_id'=>$talleres_id,'orientacion'=>$orientacion,'ramo_id'=>$ramo_id]);

    }

    public function actionNuevaFechaTaller($taller_id,$orientacion="",$ramo_id="",$localizacion=""){


        $nombre_taller = Talleres::find()->where(['id'=>$taller_id])->one();
        $fecha='';


        $model = new AsistenciaTaller();
        /* toma el id del usuario que está logeado y lo deja en creado_por*/
        $model->creado_por = Yii::$app->user->identity->id ;
        if ($model->load(Yii::$app->request->post())) {


            if ($model->fecha_asistencia == "") {
                $model->addError('fecha_asistencia', 'La fecha es obligatoria');
            }


            $model->activo = 1 ;
            $model->taller_id = $taller_id ;
            $model->presentes = 0 ;
            $model->ausentes = 0 ;
            $model->atrasos = 0 ;
            $model->creado_por = Yii::$app->user->identity->id;

            $Fechas = new Fechas();

            $Fechas->fechaInicioFinSemana($model->fecha_asistencia);

            if ($Fechas->fecha_dia != $nombre_taller->dia_id) {

                $Dia = Dia::find()->where(['id'=>$nombre_taller->dia_id])->one();


                $model->addError('fecha_asistencia', 'Este taller se realiza solo los días : ' . $Dia->nombre);
            }

            $AsistenciaTaller = AsistenciaTaller::find()->where(['taller_id'=>$taller_id,'fecha_asistencia'=>$model->fecha_asistencia,'activo'=>1])->one();

            if (count($AsistenciaTaller) > 0) {
                $model->addError('fecha_asistencia', 'Este taller ya tiene creada esta fecha');
            }


            if (count($model->errors) == 0) {
                $model->save();
                return $this->redirect(['crear-fecha-taller','talleres_id'=>$taller_id,'orientacion'=>$orientacion,'ramo_id'=>$ramo_id,'localizacion'=>$localizacion]);
            }else{
                return $this->render('@common/views/asistencia-taller/nueva_fecha', [
                    'model' => $model,
                    'nombre_taller'=>$nombre_taller,
                    'talleres_id'=>$taller_id,
                    'orientacion'=>$orientacion,
                    'ramo_id'=>$ramo_id,
                ]);
            }



            
        } else {
            return $this->render('@common/views/asistencia-taller/nueva_fecha', [
                'model' => $model,
                'nombre_taller'=>$nombre_taller,
                'talleres_id'=>$taller_id,
                'orientacion'=>$orientacion,
                'ramo_id'=>$ramo_id,
            ]);
        }

    }

    public function actionCreate($sub_ramo_id="",$tipo_talleres_id="",$codigo="",$ramo_id="",$bloque_id="",$dia_id="",$sala_id="",$localizacion="")
    {

        /**
        * Crea un nuevo modelo Talleres.
        * Si la creación se realiza correctamente, el navegador será redirigido a la página 'view'
        */

        $model = new Talleres();
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->sub_ramo_id =$sub_ramo_id;
        $model->tipo_talleres_id = $tipo_talleres_id;
        $model->codigo = $codigo;
        $model->ramo_id = $ramo_id;
        $model->bloque_id = $bloque_id;
        $model->dia_id = $dia_id;
        $model->sala_id = $sala_id;
        if ($model->load(Yii::$app->request->post())) {

            if(Yii::$app->user->identity->sede_predeterminada == 127){
               $model->taller_tipo_localidad_id = Yii::$app->request->post()['Talleres']['taller_tipo_localidad_id'];
            }   



            if ($model->orientacion || $model->orientacion > 0) {


                if ($model->tipo_talleres_orientacion_id == "" || $model->tipo_talleres_orientacion_id == 0) {
                    $model->addError('tipo_talleres_orientacion_id', 'Tipo Taller no puede estar vacío.');
                }


                if(Yii::$app->user->identity->sede_predeterminada == 127){

                    if ($model->taller_tipo_localidad_id == "" || $model->taller_tipo_localidad_id == 0) {
                        $model->addError('taller_tipo_localidad_id', 'Tipo Localidad no puede estar vacío.');
                    }

                }

                $model->tipo_talleres_id = $model->tipo_talleres_orientacion_id;

                // confirmo si existe otro taller con similares caracteristicas

                $taller = Talleres::find()

                        ->where(['taller.activo'=>1,'taller.anio_id'=>Yii::$app->user->identity->anio_predeterminado,'taller.sede_id'=>Yii::$app->user->identity->sede_predeterminada,'tipo_talleres_id'=>$model->tipo_talleres_id,'listacodigos'=>$model->listacodigos,'orientacion'=>$model->orientacion])->one();

                if (count($taller) > 0) {
                    $model->addError('validar_duplicados', 'Ya existe un taller con estos datos');


                    $model->validar_duplicados = $taller;

                }

            }else{


                if ($model->taller_sub_tipo_id == "") {
                    $model->addError('taller_sub_tipo_id', 'Tipo Taller no puede estar vacío.');
                }else{
                    $model->taller_sub_tipo_id = serialize($model->taller_sub_tipo_id);
                }

                if(Yii::$app->user->identity->sede_predeterminada == 127){

                    if ($model->taller_tipo_localidad_id == "" || $model->taller_tipo_localidad_id == 0) {
                        $model->addError('taller_tipo_localidad_id', 'Tipo Localidad no puede estar vacío.');
                    }

                }

                if ($model->sub_ramo_id_array == "") {
                    $model->addError('sub_ramo_id_array', 'Sub Ramo no puede estar vacío.');
                }else{
                    $model->sub_ramo_id_array = serialize($model->sub_ramo_id_array);
                }

                // confirmo si existe otro taller con similares caracteristicas

                $taller = Talleres::find()

                        ->where(['taller.activo'=>1,'taller.anio_id'=>Yii::$app->user->identity->anio_predeterminado,'taller.sede_id'=>Yii::$app->user->identity->sede_predeterminada,'tipo_talleres_id'=>$model->tipo_talleres_id,'taller_sub_tipo_id'=>$model->taller_sub_tipo_id,'listacodigos'=>$model->listacodigos])->one();


                if (count($taller) > 0) {
                    $model->addError('validar_duplicados', 'Ya existe un taller con estos datos');


                    $model->validar_duplicados = $taller;

                }
                

            }




            $model->creado_por = Yii::$app->user->identity->id;

            $model->sede_id = Yii::$app->user->identity->sede_predeterminada;

            $model->anio_id = Yii::$app->user->identity->anio_predeterminado;

            if(count($model->getErrors()) == 0 && $model->validate()){



                $id_sub_ramo = Curso::getIdSubRamo($model->sub_ramo_id);
                $taller = TipoTalleres::find()->where(['id'=>$model->tipo_talleres_id])->one(); 
                $arreglo_lista_codigos = Curso::getNumero();  

                $model->nombre =$taller->descripcion.' '. $model->listacodigos;

                $model->codigo =$taller->codigo . $arreglo_lista_codigos[$model->listacodigos];

                if($model->save()){

                    // return $this->redirect(['index']);
                    return $this->redirect(['crear-fecha-taller','talleres_id'=>$model->id,'orientacion'=>$model->orientacion,'ramo_id'=>$model->ramo_id,'localizacion'=>$localizacion]);
                }


            } else {


                if ($model->orientacion || $model->orientacion > 0) {

                    if ($model->tipo_talleres_orientacion_id == "" || $model->tipo_talleres_orientacion_id == 0) {
                        $model->addError('tipo_talleres_orientacion_id', 'Tipo Taller no puede estar vacío.');
                    }

                }else{

                    if ($model->ramo_id == "" || $model->ramo_id == 0) {
                        $model->addError('ramo_id', 'Ramo no puede estar vacío.');
                    }

                    if ($model->taller_sub_tipo_id == "") {
                        $model->addError('taller_sub_tipo_id', 'Tipo Taller no puede estar vacío.');
                    }

                    if ($model->sub_ramo_id_array == "") {
                        $model->addError('sub_ramo_id_array', 'Sub Ramo no puede estar vacío.');
                    }

                }




                return $this->render('@common/views/talleres/create', [
                    'model' => $model,
                    'localizacion'=> $localizacion,
                ]);
            }

        } else {
            return $this->render('@common/views/talleres/create', [
                'model' => $model,
                'localizacion'=> $localizacion,
            ]);
        }

    }

    public function actionUpdate($id,$talleres_id="",$orientacion="",$ramo_id="",$localizacion="")
    {

        /**
            * Actualiza un modelo existente Curso.
            * Si la actualización se realiza correctamente, el navegador será redirigido a la página de "view"
            * @param string $id
            *  no tiene variable de retorno
        */
        $model = $this->findModel($id);

        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;

        $taller = TipoTalleres::find()->where(['id'=>$model->tipo_talleres_id])->one(); 

        $tipo_talleres_id_arrray_temp = $model->tipo_talleres_id;

        $tipo_talleres_id_temp = $model->tipo_talleres_id;

        if ($model->load(Yii::$app->request->post())){

            if ($model->orientacion || $model->orientacion > 0) {

                if ($model->tipo_talleres_orientacion_id == "" || $model->tipo_talleres_orientacion_id == 0) {
                    $model->addError('tipo_talleres_orientacion_id', 'Tipo Taller no puede estar vacío.');
                }

                $model->tipo_talleres_id = $model->tipo_talleres_orientacion_id;

            }else{

                if ($model->taller_sub_tipo_id == "") {
                    $model->addError('taller_sub_tipo_id', 'Tipo Taller no puede estar vacío.');
                }else{
                    $model->taller_sub_tipo_id = serialize($model->taller_sub_tipo_id);
                }

                if ($model->sub_ramo_id_array == "") {
                    $model->addError('sub_ramo_id_array', 'Sub Ramo no puede estar vacío.');
                }else{
                    $model->sub_ramo_id_array = serialize($model->sub_ramo_id_array);
                }

            }

            // $model->tipo_talleres_id = $tipo_talleres_id_temp;

            $model->creado_por = Yii::$app->user->identity->id;

            $model->sede_id = Yii::$app->user->identity->sede_predeterminada;

            $model->anio_id = Yii::$app->user->identity->anio_predeterminado;

            if($model->validate()){

                $id_sub_ramo = Curso::getIdSubRamo($model->sub_ramo_id);
                $taller = TipoTalleres::find()->where(['id'=>$model->tipo_talleres_id])->one(); 
                $arreglo_lista_codigos = Curso::getNumero();  

                $model->nombre =$taller->descripcion.' '. $model->listacodigos;

                $model->codigo =$taller->codigo . $arreglo_lista_codigos[$model->listacodigos];

                $model->cupo = UsuarioTaller::find()
                        ->where(['activo'=>1,'taller_id'=>$model->id])->count();

                if($model->save()){

                    $CalendarioTalleres = new CalendarioTalleresComponent();



                    if ($localizacion == "") {
                        return $this->redirect(['usuario-taller/create','id'=>$model->id]);
                    }else{
                        return $this->redirect([$localizacion,'talleres_id'=>$talleres_id,'orientacion'=>$orientacion,'ramo_id'=>$ramo_id]);
                    }

                }

            }else{

                if (!$model->sub_ramo_id_array) {
                    return $this->render('@common/views/talleres/create', [
                        'model' => $model,
                        'localizacion'=> $localizacion,
                    ]);
                }else{
                    return $this->render('@common/views/talleres/update', [
                        'model' => $model,
                    ]);
                }

            }


        }else{

            if ($model->orientacion || $model->orientacion > 0) {

                $model->tipo_talleres_orientacion_id = $model->tipo_talleres_id;

            }else{

                $SubRamo = SubRamo::find()->where(['id'=>unserialize($model->sub_ramo_id_array)])->one(); 

                if (count($SubRamo)) {
                    $model->ramo_id = $SubRamo->ramo_id;

                    $model->sub_ramo_id_array = unserialize($model->sub_ramo_id_array);

                    $model->tipo_talleres_id = $model->tipo_talleres_id;

                    $model->taller_sub_tipo_id = unserialize($model->taller_sub_tipo_id);

                }

            }

            if (!$model->sub_ramo_id_array) {
                return $this->render('@common/views/talleres/create', [
                    'model' => $model,
                    'localizacion'=> $localizacion,
                ]);
            }else{
                return $this->render('@common/views/talleres/update', [
                    'model' => $model,
                ]);
            }



        }

    }

    public function actionCodigo()
    {

        $id_subramo = $_POST["id_subramo"];
        $estado = 0;
            if($id_subramo >= 1)
            {
                $estado =1;
                $list=Curso::getCodigo($id_subramo);
            }else{
                $estado = 0;
            }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionTiposTalleres()
    {

        $Libros = new TipoTallerComponent();

        echo $Libros->RecibirInformacion();

    }

    public function actionSubRamo()
    {

        $SubRamo = new SubRamoMultipleComponent();

        echo $SubRamo->RecibirInformacion();

    }

    public function actionTalleres()
    {

        $Taller = new TallerComponent();

        echo $Taller->RecibirInformacion();

    }

    public function actionCodigoTaller()
    {

        $tipo_taller_id = $_POST["tipo_taller_id"];
        $estado = 0;
            if($tipo_taller_id >= 1)
            {
                $estado =1;
                $list=Talleres::getCodigoTaller($tipo_taller_id);
            }else{
                $estado = 0;
            }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionDelete($id)
    {

        /**
        * Elimina un modelo existente  Talleres.
        * Si la eliminación se realiza correctamente, el navegador será redirigido a la página "index" .
        * @param integer $id
        * no tiene variable de retorno
        */

        $model = Talleres::findOne($id);

        if ((!$model->capacidad)) {

            $CalendarioTalleres = new CalendarioTalleresComponent();

            $Talleres_resp = $CalendarioTalleres->recalcularCuposProblemas($model->id);

            $model = Talleres::findOne($id);

        }

        $model->activo = 0 ;

        if($model->cupo < 1){

            if($model->save()){
                return $this->redirect(['index']);
            }

        }else{
            return $this->redirect(['index']);
        }



    }

    protected function findModel($id)
    {

        /**
        * Busca el modelo Talleres en función de su llave primaria.
        * Si no se encuentra el modelo, se emite una excepción HTTP 404.
        * @param integer $id
        * @return Talleres el modelo cargado.
        * Devuelve NotFoundHttpException si el modelo no se puede encontrar
        */

        if (($model = Talleres::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    public function actionRecoleccionTaller()
    {
        ini_set('max_execution_time', 1000000);
        ini_set('memory_limit','4048M');

        $talleres  = Talleres::find()->where(['activo'=>true,'orientacion'=>NULL,'procesado'=>0])->all();

        $sub_ramo = [];
        foreach($talleres as $key=> &$taller){
            if($taller->sub_ramo_id_array && !$taller->sub_ramo_id ){
                $sub_ramo = unserialize($taller->sub_ramo_id_array);
            }elseif(!$taller->sub_ramo_id_array && $taller->sub_ramo_id ){
                $sub_ramo = [$taller->sub_ramo_id];
            }elseif($taller->sub_ramo_id_array && $taller->sub_ramo_id ){
                $sub_ramo = unserialize($taller->sub_ramo_id_array);
            }
               
            $ramo  = SubRamo::find()->where(['id'=>$sub_ramo[0]])->one();
            $taller->ramo_id  = $ramo->ramo_id;
            if($taller->capacidad == null){
                $taller->capacidad = 0 ;
            }
            
            $taller->procesado = 1 ;
            if($taller->save()){
                var_dump('Taller guardado :'.$taller->nombre.' ID : '.$taller->id.' Ramo '.$taller->ramo_id);
            }else{
                var_dump($taller->getErrors());
            }
          
                
        }
        // var_dump($talleres);
        Yii::$app->end();      
    }

    public function actionInformeTalleresAlumnos()
    {
        $sql  = AsistenciaAlumnosTaller::find()
                    ->select(['sede.nombre as sede','t.codigo','r.nombre as ramo','u.rut',
                        'if(asistencia_alumnos_taller.tipo_asistencia_id=2,"AUSENTE","PRESENTE") as asistencia',
                        'concat(u.apellido_paterno," ",u.apellido_materno," ",u.nombre) as alumno',
                        't.tipo_talleres_id',
                        'asistencia_alumnos_taller.tipo_asistencia_id','t.nombre as taller','r.id as ramo_id',
                        't.id taller_id','asistencia_taller.fecha_asistencia',
                        'sede.nombre as nombre_sede','tipo_taller.nombre as tipo_taller',
                        't.taller_sub_tipo_id as taller_sub_tipo_array'])
                    ->join('INNER JOIN', 'usuario as u','asistencia_alumnos_taller.usuario_id =u.id')
                    ->join('INNER JOIN', 'taller as t','asistencia_alumnos_taller.taller_id =t.id')

                    //->join('LEFT JOIN', 'sub_ramo as sub','t.sub_ramo_id =sub.id')
                    ->join('LEFT JOIN', 'ramo as r','t.ramo_id =r.id')
                    ->join('INNER JOIN', 'sede','sede.id =t.sede_id and sede.activo=1')

                    ->join('INNER JOIN', 'tipo_taller','tipo_taller.id =t.tipo_talleres_id and tipo_taller.activo=1')
                    ->join('INNER JOIN', 'asistencia_taller','asistencia_taller.taller_id =t.id and asistencia_taller.activo=1')
                    ->where(['t.activo'=> true,'u.activo'=>true,
                        't.anio_id'=>Yii::$app->user->identity->anio_predeterminado])
                    ->asArray()
                    ->all();
                   // var_dump($sql);
         $arreglo=[];           
         $asistencia=[];           
         foreach ($sql as $dat) {
            $sub=""; 
            if ($dat['taller_sub_tipo_array']!="") {
                $sub_tipo=unserialize($dat["taller_sub_tipo_array"]);
                $TallerSubTipo  =TallerSubTipo::find()->where(['id'=>$sub_tipo])
                    //->where(['activo'=> true,'tipo_taller_id'=>$dat['tipo_talleres_id'],
                    //    'ramo_id'=>$dat['ramo_id']])
                    ->one();
                if (count($TallerSubTipo)>0) {
                    $sub=$TallerSubTipo['nombre'];        
                }    
                
            }
            $arreglo=['codigo'=>$dat['codigo'],'rut'=>$dat['rut'],'sede'=>$dat['sede'],'alumno'=>$dat['alumno'],
                    'taller'=>$dat['taller'],'ramo'=>$dat['ramo'],'tipo_taller'=>$dat['tipo_taller'],
                    'sub'=>$sub,'fecha_asistencia'=>$dat['fecha_asistencia'],
                    'asistencia'=>$dat['asistencia'],
                    'tipo_asistencia'=>$dat['tipo_asistencia_id']];

            array_push($asistencia, $arreglo);        
         
         } 
          
         return $this->render('@common/views/talleres/excel_asistencia_alumnos_taller_general',[
                'asistencia'=>$asistencia,

                ]);

        //             ;

        // if ($sede_id > 0) {
        //      $sql->andWhere(['taller.sede_id'=>$sede_id]);
        // }

        // $sql->andWhere(['>=', 'asistencia_taller.fecha_asistencia', $fecha_inicio ]);

        // $sql->andWhere(['<=', 'asistencia_taller.fecha_asistencia', $fecha_final ]);

        // $Talleres = $sql

    }

    public function actionEmail($talleres_id,$localizacion=""){

        $taller=Talleres::findOne($talleres_id);
        
        $alumnos = UsuarioTaller::find()
        ->select(['usuario.id','concat(COALESCE(usuario.apellido_paterno,"")," ",COALESCE(usuario.apellido_materno,"")," ",COALESCE(usuario.nombre,"")) as nombre',
        'usuario.rut','usuario.email'])
        
        ->join('INNER JOIN','usuario','usuario.id = usuario_taller.usuario_id')
        ->where(['usuario_taller.taller_id'=>$talleres_id,'usuario_taller.activo'=>1,'usuario.activo'=>1])
         ->asArray()
        ->all();


         return $this->render('@common/views/talleres/email_alumnos', [
            'alumnos' => $alumnos,
            'codigo_taller' => $taller->codigo,
        ]);
    }

}
