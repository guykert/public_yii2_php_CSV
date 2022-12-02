<?php
namespace profesor\controllers;


/* llama a los controladores */ 
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\Usuario;
use common\models\MallaHorariaProfesor;
use common\models\Alumno;
use common\models\Asistencia;
use common\models\Prueba;
use common\components\select\SubRamoComponent;
use yii\helpers\ArrayHelper;
use common\models\FormMes;
use yii\helpers\Json;
use common\models\PruebaPauta;
use common\models\PruebaEjeTematico;
use common\models\PruebaSubEjeTematico;
use common\models\PruebaHabilidad;
use common\models\ZoomMeetings;
use common\components\select\PaginaAlumnoAreaComponent;
use common\components\zoom\zoomComponent;

/**
 * LetraController Implementa las acciones del CRUD para el modeloLetra .
 * */ 
class AsignaturaController extends Controller
{

    public $layout = "alumno";

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
                        'actions' => ['index','asistencia','emails-alumnos','actualizar-todos','actualizar-asistencia','nueva-prueba','sub-ramo','historial-asistencia','historial-asistencia-tabla','habilitar-hoja-respuesta','pauta-de-correccion','guardar-respuesta-pauta','configuraciones','pagina-alumno-area','editar-prueba','borrar-respuesta-pauta','habilitar-solucionario','config-preguntas','asignar-eliminar-ejes-tematicos','config-preguntas-sub-ejes','config-preguntas-sub-ejes-ver','sub-eje-tematico-preguntas','asignar-eliminar-sub-ejes-tematicos','asignar-eliminar-habilidad','config-preguntas-habilidad','zoom','eliminar-prueba'],
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
                        'actions' => ['index','asistencia','emails-alumnos','actualizar-todos','actualizar-asistencia','nueva-prueba','sub-ramo','historial-asistencia','historial-asistencia-tabla','habilitar-hoja-respuesta','pauta-de-correccion','guardar-respuesta-pauta','configuraciones','pagina-alumno-area','editar-prueba','borrar-respuesta-pauta','habilitar-solucionario','config-preguntas','asignar-eliminar-ejes-tematicos','config-preguntas-sub-ejes','config-preguntas-sub-ejes-ver','sub-eje-tematico-preguntas','asignar-eliminar-sub-ejes-tematicos','asignar-eliminar-habilidad','config-preguntas-habilidad','zoom','eliminar-prueba'],
                        'allow' => true,
                        'roles' => ['acceso_profesores'],
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

    public function actionZoom($id,$fecha)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $zoomComponent = new zoomComponent("C_xHBEKwQ5SHQTWtecSeVw","3WsT4WFsFyQWKcoyvjZGN6AlA7IeN1h7Lher");

        // echo "email : " . Yii::$app->user->identity->email . "<br>"; 
        // echo "nombre : " . Yii::$app->user->identity->nombre . "<br>";
        // echo "apellido_paterno : " . Yii::$app->user->identity->apellido_paterno . "<br>";
        // echo "apellido_materno : " . Yii::$app->user->identity->apellido_materno . "<br>";

        

        $respuesta = $zoomComponent->createUser(Yii::$app->user->identity->email,Yii::$app->user->identity->nombre,Yii::$app->user->identity->apellido_paterno . " " .Yii::$app->user->identity->apellido_materno,2);



        if(Yii::$app->user->identity->id_zoom == ""){

            $respuesta = $zoomComponent->buscarUsuarioEmail(Yii::$app->user->identity->email);



            // $respuesta = $zoomComponent->createUser(Yii::$app->user->identity->email,Yii::$app->user->identity->nombre,Yii::$app->user->identity->apellido_paterno . " " .Yii::$app->user->identity->apellido_materno,2);



            if($respuesta["code"] == 1001){

                // El usuario no existe tengo que crearlo

                //echo "El usuario no existe tengo que crearlo : " .Yii::$app->user->identity->email . "<br><br>";

                // var_dump(Yii::$app->user->identity->nombre);
                // exit;



                if($respuesta["code"] == "201"){
                    //El usuario se creó Exitosamente.

                    //echo "El usuario se creó Exitosamente. : " .$respuesta["id"] . "<br><br>";

                    $this->guardarUsuario($respuesta["id"]);

                }else{
                    // error al crear el usuario

                    var_dump($respuesta);

                    exit;
                }



                // Guardar el id del usuario en la tabla usuario

                
            }else{

                //echo "Guardar el id del usuario en la tabla usuario : " .Yii::$app->user->identity->email;

                return $this->render("/mensajes/error",array(
                    "mensaje"=>'     <b>Clase Online</b> Activación de cuenta : 
                                    <hr>
                                            <span><p class="parrafomensaje">
                                                <br>&nbsp;  En algún momento ingresaste tus datos en la cuenta Zoom del Preuniversitario. Revisa tu correo y activa esta cuenta para que puedas ingresar a nuestras Clases.
    
                                            </span>',
                    "titulo"=>'     Activación de cuenta.',
                ));


                // if($respuesta["code"] == 1120){
                //     return $this->render("/mensajes/colegio",array(
                //         "mensaje"=>'     <b>Clase Online</b> Activación de cuenta : 
                //                         <hr>
                //                                 <span><p class="parrafomensaje">
                //                                     <br><i class="fa fa-folder-open-o  iconomensaje"></i>&nbsp;  En algún momento ingresaste tus datos en la cuenta Zoom del Preuniversitario. Revisa tu correo y activa esta cuenta para que puedas ingresar a nuestras Clases.
        
                //                                 </span>',
                //         "titulo"=>'     Activación de cuenta.',
                //     ));
                // }else{
                //     $this->guardarUsuario($respuesta["id"]);
                // }

                // Guardar el id del usuario en la tabla usuario
            }


        }

        $hoy = $fecha;

        

        $horas = date("H:i:s", strtotime($MallaHorariaProfesor["hora_desde"]));

        $fecha_final = gmdate( "Y-m-d\TH:i:s", strtotime($hoy . ' ' . $horas) );

        $nombre_conferencia = $MallaHorariaProfesor["nombre_sub_ramo"] . " -  " . $MallaHorariaProfesor["nombre_curso"];

        $ZoomMeetings = ZoomMeetings::find()

        //->where(['curso.id'=>$curso_id,'curso.activo' => 1])
        ->where(['usuario_id'=>Yii::$app->user->identity->id,'curso_id' => $id,'activo'=>1,'fecha'=>$hoy])

        ->one();



        if(!$ZoomMeetings){

            //echo "Creamos El meeting <br>";



            $respuesta = $zoomComponent->crearMeetings(Yii::$app->user->identity->id_zoom,$nombre_conferencia,$fecha_final.'Z');







            if($respuesta["code"] == 201){

                $fecha_final_db = date("Y-m-d H:i:s",strtotime($hoy . ' ' . $horas) );
                

                $ZoomMeetings = new ZoomMeetings();
                $ZoomMeetings->usuario_id = Yii::$app->user->identity->id;
                $ZoomMeetings->curso_id = $id;
                $ZoomMeetings->activo = 1;
                $ZoomMeetings->creado_por = Yii::$app->user->identity->id;
                $ZoomMeetings->fecha_creacion = date("Y-m-d H:i:s");
                $ZoomMeetings->fecha = $hoy;
                $ZoomMeetings->fecha_inicio_meeting = $fecha_final_db;
                $ZoomMeetings->id_zoom_meeting = $respuesta["id"]."";
                $ZoomMeetings->enlace_meeting = $respuesta["join_url"];
                $ZoomMeetings->enlace_iniciar_meeting = $respuesta["start_url"];

                $ZoomMeetings->save();
                


                // var_dump($ZoomMeetings->save());
                // exit;


                // var_dump($ZoomMeetings->getErrors());

                //  busco los correos de cada alumno

                // $AlumnoCurso = AlumnoCurso::find()->where(['usuario_curso.curso_id'=>$id,'usuario_curso.activo'=>1,'rol_usuario.item_name'=>'alumno'])
                // ->join('INNER JOIN','rol_usuario','rol_usuario.user_id =usuario_curso.usuario_id')
                // ->join('INNER JOIN','usuario','usuario.id =usuario_curso.usuario_id')
                // ->select(['usuario.id','usuario.morosos','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno',
                // 'usuario.rut','usuario.email'])
                // ->asArray()
                // ->all();
        
                // foreach ($AlumnoCurso as $key => $alumno) {
        
                //     // var_dump($alumno);
                //     // echo "<br><br>";
        
                //     $nombre_alumno = $alumno["nombre"] . " " . $alumno["apellido_paterno"] . " " . $alumno["apellido_materno"];
                //     // var_dump($nombre_alumno);
                //     // echo "<br><br>";
        
                //     $nombre_profesor = Yii::$app->user->identity->nombre . " " . Yii::$app->user->identity->apellido_paterno . " " . Yii::$app->user->identity->apellido_materno;
                //     // var_dump($nombre_profesor);
                //     // echo "<br><br>";

                //     $fecha_final_email = date("Y-m-d H:i:s",strtotime($hoy . ' ' . $horas) );

                //     $fecha_final_email = strftime("%d de %B a las %H:%M", strtotime($fecha_final_email));

                //     if($alumno['morosos'] != 1){

                //         $mg = Mailgun::create('678acbf895e1d2ee96ed9752741fa70a-46ac6b00-29849db7'); 
        
                //         $result= $mg->sendMessage('preupdv.cl', [
                //                 'from'    => 'claseonline@preupdv.cl',
                //                 'to'      => $alumno["email"],
                //                 'subject' => 'Clase Preu PDV_' . $curso_codigo . ' (' . $fecha_final_email . ')',
                //                 'template'=> 'alumno_zoom_meeting',
                //                 'h:X-Mailgun-Variables'    => '{
                //                     "alumno": "' . $nombre_alumno . '",
                //                     "profesor": "' . $nombre_profesor . '",
                //                     "curso": "' . $curso_nombre . '",
                //                     "horario": "' . $fecha_final_email . '",
                //                     "link_meeting": "' . $respuesta["join_url"] . '",
                //                     "id_meeting": "' . $respuesta["id"] . '"
                //                 }'
                //                 ]);

                //         $ZoomMeetingsEmail = new ZoomMeetingsEmail();
                //         $ZoomMeetingsEmail->usuario_id = $alumno["id"];
                //         $ZoomMeetingsEmail->taller_id = $curso_id;
                //         $ZoomMeetingsEmail->activo = 1;
                //         $ZoomMeetingsEmail->creado_por = Yii::$app->user->identity->id;
                //         $ZoomMeetingsEmail->fecha_creacion = date("Y-m-d H:i:s");
                //         $ZoomMeetingsEmail->zoom_meetings_id = $ZoomMeetings->id;
                //         $ZoomMeetingsEmail->respuesta_email = "message : " . $result->http_response_body->message . "  http_response_code :  " . $result->http_response_code;
                //         $ZoomMeetingsEmail->email = $alumno["email"];
    
                //         $ZoomMeetingsEmail->save();

                //     }
        



                // }

                // $mg = Mailgun::create('678acbf895e1d2ee96ed9752741fa70a-46ac6b00-29849db7'); 
        
                // $result= $mg->sendMessage('preupdv.cl', [
                //         'from'    => 'claseonline@preupdv.cl',
                //         'to'      => Yii::$app->user->identity->email,
                //         'subject' => 'Clase Preu PDV_' . $curso_codigo . ' (' . $fecha_final_email . ')',
                //         'template'=> 'alumno_zoom_meeting',
                //         'h:X-Mailgun-Variables'    => '{
                //             "alumno": "' . $nombre_profesor . '",
                //             "profesor": "' . $nombre_profesor . '",
                //             "curso": "' . $curso_nombre . '",
                //             "horario": "' . $fecha_final_email . '",
                //             "link_meeting": "' . $respuesta["join_url"] . '",
                //             "id_meeting": "' . $respuesta["id"] . '"
                //         }'
                //         ]);
        

                // $ZoomMeetingsEmail = new ZoomMeetingsEmail();
                // $ZoomMeetingsEmail->usuario_id = Yii::$app->user->identity->id;
                // $ZoomMeetingsEmail->taller_id = $curso_id;
                // $ZoomMeetingsEmail->activo = 1;
                // $ZoomMeetingsEmail->creado_por = Yii::$app->user->identity->id;
                // $ZoomMeetingsEmail->fecha_creacion = date("Y-m-d H:i:s");
                // $ZoomMeetingsEmail->zoom_meetings_id = $ZoomMeetings->id;
                // $ZoomMeetingsEmail->respuesta_email = "message : " . $result->http_response_body->message . "  http_response_code :  " . $result->http_response_code;
                // $ZoomMeetingsEmail->email = Yii::$app->user->identity->email;

                // $ZoomMeetingsEmail->save();


            }
            
        }

        $this->redirect($ZoomMeetings->enlace_iniciar_meeting);

        var_dump($ZoomMeetings);

        echo "<br>";

        var_dump($MallaHorariaProfesor);



    }

    public function actionEliminarPrueba($id,$fecha,$prueba_id)
    {

        $model = Prueba::findOne($prueba_id); 

        if($model->activo == true )
        {

            $model->activo = false ;
                   
        }else{

            $model->activo = true ;

        }



        $model->save();

        return $this->redirect(['index','id'=>$id,'fecha'=>$fecha]); 



    }

    public function actionSubRamo()
    {

        $SubRamo = new SubRamoComponent();

        echo $SubRamo->RecibirInformacion();

    }

    public function actionIndex($id,$curso_id,$fecha)
    {

        $model = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_curso.id'=>$id,'malla_horaria_curso.curso_id'=>$curso_id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $Asistencia = Asistencia::find()

        ->where(['asistencia.activo'=>true,'asistencia.asignatura_curso_id'=>$model['id'],'asistencia.fecha'=>$fecha])
        ->asArray()
        ->all();



        $Asistencia = ArrayHelper::index($Asistencia,null, 'estado_asistencia_id');

        $Pruebas = Prueba::find()

        ->where(['prueba.activo'=>true,'prueba.tipo_prueba_id'=>2,'prueba.curso_id'=>$model['curso_id'],'prueba.sub_ramo_id'=>$model['asignatura_id']])
        ->asArray()
        ->all();





        return $this->render('index', [
            'model' => $model,
            'fecha' => $fecha,
            'Asistencia' => $Asistencia,
            'Pruebas' => $Pruebas,
        ]);
    }

    public function actionAsignarEliminarEjesTematicos()
    {

        $pauta_id = Yii::$app->request->post('pauta_id', '');
        $id_eje = Yii::$app->request->post('id_eje', '');
        $numero_pregunta = Yii::$app->request->post('numero_pregunta', '');
        $estado = 0;
        $list=[];

        if($pauta_id > 0 && $id_eje > 0 && $numero_pregunta > 0)
        {

            $PruebaPauta = PruebaPauta::findOne($pauta_id);

            if($PruebaPauta){
                if($PruebaPauta->eje_tematico == $id_eje){
                    $PruebaPauta->eje_tematico = null;
                }else{
                    $PruebaPauta->eje_tematico = $id_eje;
                }
                if ($PruebaPauta->save()) {
                    $estado =1;
                }

            }else{
                $estado = 99;
            }
        }else{
            $estado = 98;
        }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionConfigPreguntasHabilidad($id,$fecha,$prueba_id)
    {


        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $model = Prueba::findOne($prueba_id); 

        $model->scenario = 'formProfesor';

        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");

        $PruebaHabilidades = PruebaHabilidad::find()->where(['activo'=>true,'ramo_id'=>$model->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$model->id])->orderBy('numero_pregunta')->all();

        return $this->render('config_preguntas_habilidad', [
            'model' => $model,
            'id' => $id,
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
            'fecha' => $fecha,
            'PruebaHabilidades' => $PruebaHabilidades,
            'PruebaPauta' => $PruebaPauta,
        ]);


    }

    public function actionConfigPreguntasSubEjes($id,$fecha,$prueba_id)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $model = Prueba::findOne($prueba_id); 

        $model->scenario = 'formProfesor';

        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");

        $PruebaEjeTematico = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>$model->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$model->id])->orderBy('numero_pregunta')->all();

        return $this->render('config_preguntas_sub_ejes', [
            'model' => $model,
            'id' => $id,
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
            'fecha' => $fecha,
            'PruebaEjeTematico' => $PruebaEjeTematico,
            'PruebaPauta' => $PruebaPauta,
        ]);


    }

    public function actionSubEjeTematicoPreguntas($id,$id_eje)
    {


 
        $Prueba = Prueba::findOne($id); 

        $PruebaEjeTematico = PruebaEjeTematico::findOne($id_eje);

        //busco los ejes tematicos para asignarlos

        $PruebaSubEjeTematico = PruebaSubEjeTematico::find()->where(['activo'=>true,'eje_tematico_id'=>$id_eje])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$Prueba->id,'eje_tematico'=>$id_eje])->orderBy('numero_pregunta')->all();


        return $this->renderAjax('@common/views/prueba/_sub_eje_tematico_pregunta', [
            'model' => $Prueba,
            'PruebaSubEjeTematico' => $PruebaSubEjeTematico,
            'PruebaPauta' => $PruebaPauta,
            'PruebaEjeTematico' => $PruebaEjeTematico,
        ]);

    }

    public function actionAsignarEliminarHabilidad()
    {

        $pauta_id = Yii::$app->request->post('pauta_id', '');
        $id_habilidad = Yii::$app->request->post('id_habilidad', '');
        $numero_pregunta = Yii::$app->request->post('numero_pregunta', '');
        $estado = 0;
        $list=[];

        if($pauta_id > 0 && $id_habilidad > 0 && $numero_pregunta > 0)
        {

            $PruebaPauta = PruebaPauta::findOne($pauta_id);

            if($PruebaPauta){
                if($PruebaPauta->habilidad_id == $id_habilidad){
                    $PruebaPauta->habilidad_id = null;
                }else{
                    $PruebaPauta->habilidad_id = $id_habilidad;
                }
                if ($PruebaPauta->save()) {
                    $estado =1;
                }

            }else{
                $estado = 99;
            }
        }else{
            $estado = 98;
        }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionAsignarEliminarSubEjesTematicos()
    {

        $pauta_id = Yii::$app->request->post('pauta_id', '');
        $id_eje = Yii::$app->request->post('id_eje', '');
        $numero_pregunta = Yii::$app->request->post('numero_pregunta', '');
        $estado = 0;
        $list=[];

        if($pauta_id > 0 && $id_eje > 0 && $numero_pregunta > 0)
        {

            $PruebaPauta = PruebaPauta::findOne($pauta_id);

            if($PruebaPauta){
                if($PruebaPauta->sub_eje_tematico == $id_eje){
                    $PruebaPauta->sub_eje_tematico = null;
                }else{
                    $PruebaPauta->sub_eje_tematico = $id_eje;
                }
                if ($PruebaPauta->save()) {
                    $estado =1;
                }

            }else{
                $estado = 99;
            }
        }else{
            $estado = 98;
        }

        echo Json::encode(['list'=>$list, 'estado'=>$estado]);

    }

    public function actionConfigPreguntasSubEjesVer($id,$fecha,$prueba_id)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $model = Prueba::findOne($prueba_id); 

        $model->scenario = 'formProfesor';

        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");


        $PruebaSubEjeTematico = PruebaSubEjeTematico::find()->where(['activo'=>true,'ramo_id'=>$model->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$model->id])->orderBy('numero_pregunta')->all();

        return $this->render('config_preguntas_sub_ejes_ver', [
            'model' => $model,
            'id' => $id,
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
            'fecha' => $fecha,
            'PruebaSubEjeTematico' => $PruebaSubEjeTematico,
            'PruebaPauta' => $PruebaPauta,
        ]);


    }

    public function actionConfigPreguntas($id,$fecha,$prueba_id)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $model = Prueba::findOne($prueba_id); 

        $model->scenario = 'formProfesor';

        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");

        $PruebaEjeTematico = PruebaEjeTematico::find()->where(['activo'=>true,'ramo_id'=>$model->ramo_id])->orderBy('nombre')->all();

        $PruebaPauta = PruebaPauta::find()->where(['activo'=>true,'prueba_id'=>$model->id])->orderBy('numero_pregunta')->all();


        return $this->render('config_preguntas', [
            'model' => $model,
            'id' => $id,
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
            'fecha' => $fecha,
            'PruebaEjeTematico' => $PruebaEjeTematico,
            'PruebaPauta' => $PruebaPauta,
        ]);


    }

    public function actionEditarPrueba($id,$fecha,$prueba_id)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','curso.nivel_id as nivel_id','sub_ramo.id as sub_ramo_id','sub_ramo.ramo_id as ramo_id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();


        $model = Prueba::findOne($prueba_id); 

        $model->scenario = 'formProfesor';

        /* toma el id del usuario que está logeado*/
        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        $model->ramo_id = $MallaHorariaProfesor["ramo_id"];
        $model->sub_ramo_id = $MallaHorariaProfesor["sub_ramo_id"];
        $model->nivel_id = $MallaHorariaProfesor["nivel_id"];

        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/uploads/';
        Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/uploads/';

        if ($model->load(Yii::$app->request->post())) {

            $prueba = $model->uploadPrueba();


            // upload only if valid uploaded file instance found
            if ($prueba !== false) {

                $path = $model->getPruebaFile();




                $model->prueba_ruta_archivo = $path;
                $model->prueba_nombre_archivo = "/uploads/" .Yii::$app->user->identity->id."/profile/" . $prueba->name;



                $directorios = $model->creoDirectorios();

                



                $prueba->saveAs($path);



                
            }




            $model->save();







            return $this->redirect(['pauta-de-correccion','id'=>$id,'fecha'=>$fecha,'prueba_id'=>$model->id]);
        } else {
            return $this->render('prueba_nueva', [
                'model' => $model,
                'MallaHorariaProfesor' => $MallaHorariaProfesor,
                'fecha' => $fecha,
                // 'dias' => $dias,
            ]);
        }



    }



    private function guardarUsuario($id_zoom)
    {

        $Usuario = Usuario::findOne([
            'status' => Usuario::STATUS_ACTIVE,
            'id' => Yii::$app->user->identity->id,
        ]);

        $Usuario->id_zoom = $id_zoom;

        $Usuario->save();

    } 

    public function actionNuevaPrueba($id,$fecha)
    {

        // $MallaHorariaProfesor = MallaHorariaProfesor::find()
        // ->select(['malla_horaria_curso.id','curso.nivel_id as nivel_id','sub_ramo.id as sub_ramo_id','sub_ramo.ramo_id as ramo_id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        // ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        // ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        // ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        // ->asArray()
        // ->one();

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['curso.nivel_id as nivel_id','malla_horaria_curso.id','malla_horaria_curso.dia_id','sub_ramo.ramo_id as ramo_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_curso.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();


        $model = new Prueba(['scenario' => 'formProfesor']);
        /* toma el id del usuario que está logeado*/
        $model->creado_por = Yii::$app->user->identity->id;
        $model->fecha_creacion = date("Y-m-d H:i:s");
        $model->empresa_id = Yii::$app->user->identity->colegio_predeterminada;
        $model->anio_id = Yii::$app->user->identity->anio_predeterminado;
        $model->activo = 1;
        $model->tipo_prueba_id = 2;
        $model->curso_id = $MallaHorariaProfesor["curso_id"];
        $model->ramo_id = $MallaHorariaProfesor["ramo_id"];
        $model->sub_ramo_id = $MallaHorariaProfesor["asignatura_id"];
        $model->nivel_id = $MallaHorariaProfesor["nivel_id"];

        Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/uploads/';
        Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/uploads/';

        if ($model->load(Yii::$app->request->post())) {

            $prueba = $model->uploadPrueba();


            // upload only if valid uploaded file instance found
            if ($prueba !== false) {

                $path = $model->getPruebaFile();

                // var_dump($MallaHorariaProfesor["ramo_id"]);
                // echo "<br><br><br>";


                // var_dump($model);
                // exit;


                $model->prueba_ruta_archivo = $path;
                $model->prueba_nombre_archivo = "/uploads/" .Yii::$app->user->identity->id."/profile/" . $prueba->name;



                $directorios = $model->creoDirectorios();

                



                $prueba->saveAs($path);



                
            }




            $model->save();







            return $this->redirect(['pauta-de-correccion','id'=>$id,'fecha'=>$fecha,'prueba_id'=>$model->id]);
        } else {
            return $this->render('prueba_nueva', [
                'model' => $model,
                'MallaHorariaProfesor' => $MallaHorariaProfesor,
                'fecha' => $fecha,
                // 'dias' => $dias,
            ]);
        }



    }

    public function actionConfiguraciones($id,$fecha,$prueba_id)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $model = Prueba::findOne($prueba_id);

        $model->scenario = 'configuraciones';


        $model->modificado_por = Yii::$app->user->identity->id ;     
        $model->fecha_modificacion = date("Y-m-d H:i:s");
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index','id'=>$id,'fecha'=>$fecha]);
        } else {
            return $this->render('prueba_configuraciones', [
                'model' => $model,
                'MallaHorariaProfesor' => $MallaHorariaProfesor,
                'fecha' => $fecha,
                'id' => $id,
            ]);
        }







    }

    public function actionPautaDeCorreccion($id,$fecha,$prueba_id)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $Prueba = Prueba::findOne($prueba_id);

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$prueba_id,'activo'=>1])->asArray()->all();

        $PruebaPauta = ArrayHelper::index($PruebaPauta, 'numero_pregunta');


        return $this->render('prueba_pauta', [
            'Prueba' => $Prueba,
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
            'fecha' => $fecha,
            'id' => $id,
            'PruebaPauta' => $PruebaPauta,
        ]);




    }

    public function actionHistorialAsistencia($id,$fecha)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();




        $Alumnos = Alumno::find()
                    ->where(['usuario.activo'=>true,'curso.id'=>$MallaHorariaProfesor['curso_id'],'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
                    ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
                    ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
                    ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
                    ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
                    ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
                    ->groupBy(['usuario.id'])
                    ->orderBy(['usuario.id'=>SORT_ASC])
                    ->asArray()
                    ->all();



        $fecha_inicio = date("Y-m",strtotime($fecha))."-01";

        $fecha_termino = date("Y-m-t",strtotime($fecha));



        foreach ($Alumnos as $key => &$Alumno) {

            $Alumno['asistencia'] = [];

            


            $Asistencia = Asistencia::find()
            ->select(['asistencia.estado_asistencia_id','asistencia.fecha'])
            ->where(['asistencia.activo'=>true,'asistencia.usuario_id'=>$Alumno['usuario_id'],'asistencia.asignatura_curso_id'=>$id])
            ->andWhere(['>=', 'asistencia.fecha', $fecha_inicio])
            ->andWhere(['<=', 'asistencia.fecha', $fecha_termino])
            ->asArray()
            ->all();

            if($Asistencia){
                $Alumno['asistencia'] = $Asistencia;
            }


        }

        $model = new FormMes();

        return $this->render('asistencia_historial', [
            'model' => $model,
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
            'Alumnos' => $Alumnos,
            'fecha' => $fecha,

        ]);



    }

    public function actionHistorialAsistenciaTabla($id,$mes)
    {

        $MallaHorariaProfesor = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();




        $Alumnos = Alumno::find()
                    ->where(['usuario.activo'=>true,'curso.id'=>$MallaHorariaProfesor['curso_id'],'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
                    ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
                    ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
                    ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id =usuario_curso.curso_id and curso_asignatura.activo = 1')
                    ->join('INNER JOIN', 'curso','curso.id =curso_asignatura.curso_id and curso.activo = 1')
                    ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
                    ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
                    ->groupBy(['usuario.id'])
                    ->orderBy(['usuario.id'=>SORT_ASC])
                    ->asArray()
                    ->all();

        $getTitoloDetalleMes = Asistencia::getTitoloDetalleMes($mes);

        if($mes < 10){
            $mes = "0".$mes;
        }


        $fecha_inicio = date("Y"). "-" .$mes. "-01";

        $fecha_termino = date("Y-m-t",strtotime("01-" .$mes. "-" .date("Y")));



        foreach ($Alumnos as $key => &$Alumno) {

            $Alumno['asistencia'] = [];

            


            $Asistencia = Asistencia::find()
            ->select(['asistencia.estado_asistencia_id','asistencia.fecha'])
            ->where(['asistencia.activo'=>true,'asistencia.usuario_id'=>$Alumno['usuario_id'],'asistencia.asignatura_curso_id'=>$id])
            ->andWhere(['>=', 'asistencia.fecha', $fecha_inicio])
            ->andWhere(['<=', 'asistencia.fecha', $fecha_termino])
            ->asArray()
            ->all();

            if($Asistencia){
                $Alumno['asistencia'] = $Asistencia;
            }


        }

        $model = new FormMes();

        

        return $this->renderAjax('_asistencia_historial_tabla', [
            'model' => $model,
            'Alumnos' => $Alumnos,
            'nombre_mes' => $getTitoloDetalleMes['nombre'],
            'MallaHorariaProfesor' => $MallaHorariaProfesor,
        ]);



    }

    public function actionAsistencia($id,$curso_id,$fecha)
    {


        // $model = MallaHorariaProfesor::find()
        // ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        // ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        // ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        // ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        // ->asArray()
        // ->one();

        $model = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_curso.id'=>$id,'malla_horaria_curso.curso_id'=>$curso_id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();




        $Alumnos = Alumno::find()
                    ->where(['usuario.activo'=>true,'curso.id'=>$model['curso_id'],'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
                    ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
                    ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
                    ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
                    ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
                    ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
                    ->groupBy(['usuario.id'])
                    ->orderBy(['usuario.id'=>SORT_ASC])
                    ->asArray()
                    ->all();

        // var_dump(Yii::$app->user->identity->colegio_predeterminada);
        // exit;


        foreach ($Alumnos as $key => &$Alumno) {

            $Alumno['asistencia'] = 0;


            $Asistencia = Asistencia::find()

            ->where(['asistencia.activo'=>true,'asistencia.usuario_id'=>$Alumno['usuario_id'],'asistencia.asignatura_curso_id'=>$id,'asistencia.fecha'=>$fecha])
            ->one();

            // echo "usuario_id : " . $Alumno['usuario_id'] . " <br>";
            // echo "asignatura_curso_id : " . $id . " <br>";
            // echo "fecha : " . $fecha . " <br>";
            // var_dump($Asistencia);
            // exit;

            if($Asistencia){
                $Alumno['asistencia'] = $Asistencia->estado_asistencia_id;
            }


        }

        $Asistencia = Asistencia::find()

        ->where(['asistencia.activo'=>true,'asistencia.asignatura_curso_id'=>$model['id'],'asistencia.fecha'=>$fecha])
        ->asArray()
        ->all();



        $Asistencia = ArrayHelper::index($Asistencia,null, 'estado_asistencia_id');

        $asistencia_botton = 0;

        if(count($Asistencia) > 0){

            if (!ArrayHelper::keyExists('0', $Asistencia, false)) {
                $asistencia_botton = 1;
            }

            if (!ArrayHelper::keyExists('1', $Asistencia, false)) {
                $asistencia_botton = 0;
                
            }
            
        }

        return $this->render('asistencia', [
            'model' => $model,
            'Alumnos' => $Alumnos,
            'fecha' => $fecha,
            'Asistencia' => $Asistencia,
            'asistencia_botton' => $asistencia_botton,
            // 'dias' => $dias,
        ]);
    }

    public function actionEmailsAlumnos($id)
    {


        $model = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();



        $Alumnos = Alumno::find()
                    ->where(['usuario.activo'=>true,'curso.id'=>$model['curso_id'],'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
                    ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
                    ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
                    ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
                    ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
                    ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
                    ->groupBy(['usuario.id'])
                    ->orderBy(['usuario.id'=>SORT_ASC])
                    ->asArray()
                    ->all();


        return $this->render('email_alumnos', [
            'model' => $model,
            'Alumnos' => $Alumnos,
            // 'dias' => $dias,
        ]);
    }


    public function actionActualizarTodos($id,$fecha,$asistencia)
    {
     
        if($asistencia == 0){
            $asistencia_botton = 1;
        }else{
            $asistencia_botton = 0;
        }

        $model = MallaHorariaProfesor::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo','curso.nombre as nombre_curso'])
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id =malla_horaria_profesor.curso_id and malla_horaria_curso.asignatura_id =malla_horaria_profesor.asignatura_id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id  = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_profesor.profesor_id'=>Yii::$app->user->identity->id,'malla_horaria_profesor.id'=>$id])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->asArray()
        ->one();

        $Alumnos = Alumno::find()
                    ->where(['usuario.activo'=>true,'curso.id'=>$model['curso_id'],'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> Yii::$app->user->identity->colegio_predeterminada])
                    ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
                    ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
                    ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
                    ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
                    ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
                    ->groupBy(['usuario.id'])
                    ->orderBy(['usuario.id'=>SORT_ASC])
                    ->asArray()
                    ->all();

        foreach ($Alumnos as $key => &$Alumno) {

            $Alumno['asistencia'] = $asistencia_botton;

            $Asistencia = Asistencia::find()

            ->where(['asistencia.activo'=>true,'asistencia.usuario_id'=>$Alumno['usuario_id'],'asistencia.asignatura_curso_id'=>$id,'asistencia.fecha'=>$fecha])
            ->one();

            if(!$Asistencia){
                $Asistencia = new Asistencia();
                $Asistencia->activo = 1;
                $Asistencia->usuario_id = $Alumno['usuario_id'];
                $Asistencia->asignatura_curso_id = $id;
                $Asistencia->fecha = $fecha;
                $Asistencia->creado_por = Yii::$app->user->identity->id;
                $Asistencia->fecha_creacion = date("Y-m-d H:i:s");
            }else{
                $Asistencia->modificado_por = Yii::$app->user->identity->id;
                $Asistencia->fecha_modificacion = date("Y-m-d H:i:s");
            }

            

            $Asistencia->estado_asistencia_id = $asistencia_botton;

            $Asistencia->save();


        }



        return $this->renderAjax('_asistencia_todos', [
            'model' => $model,
            'Alumnos' => $Alumnos,
            'fecha' => $fecha,
            'asistencia_botton' => $asistencia_botton,
            // 'dias' => $dias,
        ]);
    }

    public function actionActualizarAsistencia($id,$fecha,$asistencia,$usuario_id)
    {
     


        if($asistencia == 0){
            $asistencia = 1;
        }else{
            if($asistencia == 1){
                $asistencia = 2;
            }else{
                $asistencia = 0;
            }
        }
        


        $Asistencia = Asistencia::find()

        ->where(['asistencia.activo'=>true,'asistencia.usuario_id'=>$usuario_id,'asistencia.asignatura_curso_id'=>$id,'asistencia.fecha'=>$fecha])
        ->one();

        if(!$Asistencia){
            $Asistencia = new Asistencia();
            $Asistencia->activo = 1;
            $Asistencia->usuario_id = $usuario_id;
            $Asistencia->asignatura_curso_id = $id;
            $Asistencia->fecha = $fecha;
            $Asistencia->creado_por = Yii::$app->user->identity->id;
            $Asistencia->fecha_creacion = date("Y-m-d H:i:s");
        }else{
            $Asistencia->modificado_por = Yii::$app->user->identity->id;
            $Asistencia->fecha_modificacion = date("Y-m-d H:i:s");
        }

        

        $Asistencia->estado_asistencia_id = $asistencia;

        $Asistencia->save();





        return $this->renderAjax('_asistencia_botton', [
            'asistencia' => $asistencia,
            'usuario_id' => $usuario_id,
            'fecha' => $fecha,
            'asignatura_curso_id' => $id,
            // 'dias' => $dias,
        ]);
    }

    public function actionHabilitarHojaRespuesta($prueba_id)
    {
     


        $Prueba = Prueba::findOne($prueba_id);

        $Prueba->scenario='formProfesor';

        

        if($Prueba->publicar_hoja_respuesta == 0){
            $Prueba->publicar_hoja_respuesta = 1;
        }else{
            $Prueba->publicar_hoja_respuesta = 0;
        }

        $Prueba->save();

        echo Json::encode(['respuesta' => $Prueba->publicar_hoja_respuesta]);

        return;
    }

    public function actionHabilitarSolucionario($prueba_id)
    {
     


        $Prueba = Prueba::findOne($prueba_id);

        $Prueba->scenario='formProfesor';

        

        if($Prueba->publicar_solucionario == 0){
            $Prueba->publicar_solucionario = 1;
        }else{
            $Prueba->publicar_solucionario = 0;
        }

        $Prueba->save();

        echo Json::encode(['respuesta' => $Prueba->publicar_solucionario]);

        return;
    }

    public function actionGuardarRespuestaPauta($prueba_id,$respuesta,$numero_pregunta)
    {

        $estado = 0;

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$prueba_id,'numero_pregunta'=>$numero_pregunta])->one();


        if(!$PruebaPauta){


            $PruebaPauta = new PruebaPauta();

            $PruebaPauta->correcta = strtoupper($respuesta);
            $PruebaPauta->creado_por = Yii::$app->user->identity->id;
            $PruebaPauta->fecha_creacion = date("Y-m-d H:i:s");
            $PruebaPauta->numero_pregunta = (int)$numero_pregunta;
            $PruebaPauta->prueba_id = (int)$prueba_id;

        }else{
            $PruebaPauta->modificado_por = Yii::$app->user->identity->id;
            $PruebaPauta->fecha_modificacion = date("Y-m-d H:i:s");

        }


        // var_dump($PruebaPaut->save());
        // exit;

        if ($PruebaPauta->save()) {
            $estado = 1;
        }



        echo Json::encode(['estado' => $estado]);

        return;
    }

    public function actionBorrarRespuestaPauta($prueba_id,$numero_pregunta)
    {

        $estado = 0;

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$prueba_id,'numero_pregunta'=>$numero_pregunta])->one();


        $PruebaPauta->modificado_por = Yii::$app->user->identity->id;
        $PruebaPauta->fecha_modificacion = date("Y-m-d H:i:s");


        $PruebaPauta->correcta = "";

        if ($PruebaPauta->save()) {
            $estado = 1;
        }

        echo Json::encode(['estado' => $estado]);

        return;
    }

    public function actionPaginaAlumnoArea()
    {

        $PaginaAlumnoArea = new PaginaAlumnoAreaComponent();

        echo $PaginaAlumnoArea->RecibirInformacion();

    }

}
