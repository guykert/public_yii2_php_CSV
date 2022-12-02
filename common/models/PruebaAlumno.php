<?php

namespace common\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_alumno".
 *
 * @property integer $id
 * @property integer $sede_id
 * @property integer $prueba_id
 * @property integer $curso_id
 * @property string $rut
 * @property integer $nota
 * @property integer $buenas
 * @property integer $malas
 * @property integer $omitidas
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property boolean $activo
 * @property string $fecha_termino
 * @property string $fecha_inicio
 * @property integer $tiempo_pausa
 * @property string $fecha_pausa
 * @property string $detalle_malas
 * @property string $descripcion
 * @property integer $id_ensayo_desafio
 * @property integer $id_tipo_desafio
 * @property string $observacion
 * @property integer $mdl_quiz_id
 * @property integer $mdl_attempt
 * @property integer $empresa_id
 * @property integer $neto
 * @property integer $porcentaje_logro
 * @property integer $nivel_logro
 * @property integer $pond_buenas
 * @property integer $pond_malas
 * @property integer $pond_omitidas
 * @property integer $preguntas_abiertas
 */

class PruebaAlumno extends \yii\db\ActiveRecord
{


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_alumno';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sede_id', 'prueba_id', 'curso_id', 'nota', 'buenas', 'malas', 'omitidas', 'creado_por', 'modificado_por', 'tiempo_pausa', 'id_ensayo_desafio', 'id_tipo_desafio', 'mdl_quiz_id', 'mdl_attempt', 'empresa_id', 'neto', 'porcentaje_logro', 'nivel_logro', 'pond_buenas', 'pond_malas', 'pond_omitidas', 'preguntas_abiertas'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion', 'fecha_termino', 'fecha_inicio', 'fecha_pausa'], 'safe'],
            [['creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['rut'], 'string', 'max' => 20],
            [['detalle_malas'], 'string', 'max' => 500],
            [['descripcion'], 'string', 'max' => 300],
            [['observacion'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'sede_id' => 'Sede ID',
            'prueba_id' => 'Prueba ID',
            'curso_id' => 'Curso ID',
            'rut' => 'Rut',
            'nota' => 'Nota',
            'buenas' => 'Buenas',
            'malas' => 'Malas',
            'omitidas' => 'Omitidas',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
            'fecha_termino' => 'Fecha Termino',
            'fecha_inicio' => 'Fecha Inicio',
            'tiempo_pausa' => 'Tiempo Pausa',
            'fecha_pausa' => 'Fecha Pausa',
            'detalle_malas' => 'Detalle Malas',
            'descripcion' => 'Descripcion',
            'id_ensayo_desafio' => 'Id Ensayo Desafio',
            'id_tipo_desafio' => 'Id Tipo Desafio',
            'observacion' => 'Observacion',
            'mdl_quiz_id' => 'Mdl Quiz ID',
            'mdl_attempt' => 'Mdl Attempt',
            'empresa_id' => 'Empresa ID',
            'neto' => 'Neto',
            'porcentaje_logro' => 'Porcentaje Logro',
            'nivel_logro' => 'Nivel Logro',
            'pond_buenas' => 'Pond Buenas',
            'pond_malas' => 'Pond Malas',
            'pond_omitidas' => 'Pond Omitidas',
            'preguntas_abiertas' => 'Preguntas Abiertas',
        ];
    }

    /*genera la relación entre la prueba del alumno y laprueba  por medio del id*/
    public function getPrueba()
    {

        return $this->hasOne(Prueba::className(),['id'=>'prueba_id']);

    }

    /* rescara las preguntas de una prueba */
    public function getCorrectasVSRespuestas ()
    {

        //busco las respuestas del alumno en base a la ultima prueba que realizo

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$this->prueba_id,'activo'=>1])->orderBy(['numero_pregunta'=>SORT_ASC])->All();

        $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$this->id,'activo'=>1])->All();

        foreach ($PruebaPauta as $key => &$PruebaP) {

            $PruebaAlumnoRespuestaGuardado = ArrayHelper::index($PruebaAlumnoRespuestaGuardado, 'numero_pregunta');
            

            try
            {

                $PruebaP->respuesta_alumno = $PruebaAlumnoRespuestaGuardado[$PruebaP['numero_pregunta']]->respuesta;

                if ($PruebaP->correcta == "") {
                    $PruebaP->resultado_pregunta = "Piloto";
                }else{

                    if ($PruebaP->respuesta_alumno == "" || $PruebaP->respuesta_alumno == "-") {
                        $PruebaP->resultado_pregunta = "omitida";
                    }else{
                        if (strtoupper($PruebaP->respuesta_alumno) == strtoupper($PruebaP->correcta)) {

                            $PruebaP->resultado_pregunta = "correcta";

                        }else{
                            $PruebaP->resultado_pregunta = "incorrecta";


                        }
                    }


                }

            }
            catch (\Exception $exc)
            {
                $PruebaP->resultado_pregunta = "omitida";
            }









        }

        return $PruebaPauta;

    }

    /* rescara las preguntas de una prueba */
    public function getInformeEjes ()
    {

        //busco las respuestas del alumno en base a la ultima prueba que realizo

        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$this->prueba_id,'activo'=>1])->orderBy(['numero_pregunta'=>SORT_ASC])->All();

        $PruebaPautaAgrupada = PruebaPauta::find()->where(['prueba_id'=>$this->prueba_id,'activo'=>1])
                            ->groupBy(['eje_tematico'])
                            ->All();




 

        $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$this->id,'activo'=>1])->All();



        $nombre_mostrar_def = [];

        $notas = [];
        $ListadoPuntajes = [];

        $buenas = [];
        $malas = [];
        $omitidas = [];




        foreach ($PruebaPautaAgrupada as $key => $PruebaPautaAgrupad) {



            foreach ($PruebaPauta as $key => &$PruebaP) {



                if ($PruebaP->eje_tematico == $PruebaPautaAgrupad->eje_tematico) {

                    try
                    {



                        $PruebaAlumnoRespuestaGuardado = ArrayHelper::index($PruebaAlumnoRespuestaGuardado, 'numero_pregunta');

                        $PruebaP->respuesta_alumno = $PruebaAlumnoRespuestaGuardado[$PruebaP->numero_pregunta]->respuesta;




                        if ($PruebaP->correcta == "") {

                        }else{



                            if (!$PruebaP->respuesta_alumno || $PruebaP->respuesta_alumno == "" || $PruebaP->respuesta_alumno == "-" || $PruebaP->respuesta_alumno == "") {
                                $PruebaPautaAgrupad->omitidas++;
                            }else{
                                if (strtoupper($PruebaP->respuesta_alumno) == strtoupper($PruebaP->correcta)) {

                                    $PruebaPautaAgrupad->buenas++;

                                }else{
                                    $PruebaPautaAgrupad->malas++;


                                }
                            }

                        }

                    }
                    catch (\Exception $exc)
                    {




                        if ($PruebaP->correcta != "") {

                            $PruebaPautaAgrupad->omitidas++;

                        }
                        




                    }




                }


            }



            $buenas[] = $PruebaPautaAgrupad->buenas;
            $malas[] = $PruebaPautaAgrupad->malas;
            $omitidas[] = $PruebaPautaAgrupad->omitidas;


            $nombre_mostrar_def[] = $PruebaPautaAgrupad->ejes->nombre;

        }


        $notas[] = ['name' => 'buenas', 'data' => $buenas];
        $notas[] = ['name' => 'malas', 'data' => $malas];
        $notas[] = ['name' => 'omitidas', 'data' => $omitidas];

        $ListadoPuntajes[] = $nombre_mostrar_def;
        $ListadoPuntajes[] = $notas;
        $ListadoPuntajes[] = ['#019be4','#ff5f5f','#797979'];

        return $ListadoPuntajes;

    }

    /* rescara las preguntas de una prueba */
    public function getInformeEjesMenciones ()
    {

        //busco las respuestas del alumno en base a la ultima prueba que realizo

        $ramos_agrupar_ejes = [];


        $PruebaPauta = PruebaPauta::find()->where(['prueba_id'=>$this->prueba_id,'activo'=>1])->orderBy(['numero_pregunta'=>SORT_ASC])->All();

        $PruebaPautaAgrupada = PruebaPauta::find()->where(['prueba_id'=>$this->prueba_id,'activo'=>1])
                            ->groupBy(['eje_tematico'])
                            ->All();

        $PruebaAlumnoRespuestaGuardado = PruebaAlumnoRespuesta::find()->where(['prueba_alumno_id'=>$this->id,'activo'=>1])->All();

        foreach ($PruebaPautaAgrupada as $key => $eje) {

            $nombre_mostrar_def = [];

            $notas = [];
            $ListadoPuntajes = [];

            $buenas = [];
            $malas = [];
            $omitidas = [];

            foreach ($PruebaPautaAgrupada as $key => $PruebaPautaAgrupad) {
                $PruebaPautaAgrupad->omitidas = 0;
                $PruebaPautaAgrupad->buenas = 0;
                $PruebaPautaAgrupad->malas = 0;
                if ($eje->ejesRamos->ramo_id == $PruebaPautaAgrupad->ejesRamos->ramo_id) {

                    foreach ($PruebaPauta as $key => &$PruebaP) {

                        // var_dump($PruebaP['numero_pregunta'] - 1);
                        // echo "<br>";
                        // var_dump($key);
                        // echo "<br><br>";
                        

                        if ($PruebaP->eje_tematico == $PruebaPautaAgrupad->eje_tematico) {

                            try
                            {



                                $PruebaAlumnoRespuestaGuardado = ArrayHelper::index($PruebaAlumnoRespuestaGuardado, 'numero_pregunta');

                                $PruebaP->respuesta_alumno = $PruebaAlumnoRespuestaGuardado[$PruebaP->numero_pregunta]->respuesta;

                                // $PruebaP->respuesta_alumno = $PruebaAlumnoRespuestaGuardado[$PruebaP['numero_pregunta'] - 1]->respuesta;


                                if ($PruebaP->correcta == "") {

                                }else{
                                    if (!$PruebaP->respuesta_alumno || $PruebaP->respuesta_alumno == "" || $PruebaP->respuesta_alumno == "-") {
                                        $PruebaPautaAgrupad->omitidas++;
                                    }else{
                                        if (strtoupper($PruebaP->respuesta_alumno) == strtoupper($PruebaP->correcta)) {

                                            $PruebaPautaAgrupad->buenas++;

                                        }else{
                                            $PruebaPautaAgrupad->malas++;


                                        }
                                    }

                                }
                                
                            }
                            catch (\Exception $exc)
                            {

                                if ($PruebaP->correcta != "") {

                                    $PruebaPautaAgrupad->omitidas++;

                                }

                                
                            }




                        }

                    }
                    // exit;
                    $buenas[] = $PruebaPautaAgrupad->buenas;
                    $malas[] = $PruebaPautaAgrupad->malas;
                    $omitidas[] = $PruebaPautaAgrupad->omitidas;

                    $nombre_mostrar_def[] = $PruebaPautaAgrupad->ejesRamos->nombre;

                }

            }


            $notas[] = ['name' => 'buenas', 'data' => $buenas];
            $notas[] = ['name' => 'malas', 'data' => $malas];
            $notas[] = ['name' => 'omitidas', 'data' => $omitidas];

            $ListadoPuntajes[] = $nombre_mostrar_def;
            $ListadoPuntajes[] = $notas;
            $ListadoPuntajes[] = ['#019be4','#ff5f5f','#797979'];


            if ($eje->ejesRamos->ramo_id == $this->prueba->ramo_id) {
                $ramos_agrupar_ejes [] = ['ramo_id'=>$eje->ejesRamos->ramo_id,'ramo_nombre'=>$eje->ejesRamos->ramo->nombre, 'codigo'=>$eje->ejesRamos->ramo->codigo, 'princial'=>1, 'ejes'=>$ListadoPuntajes];
            }else{
                $ramos_agrupar_ejes [] = ['ramo_id'=>$eje->ejesRamos->ramo_id,'ramo_nombre'=>$eje->ejesRamos->ramo->nombre, 'codigo'=>$eje->ejesRamos->ramo->codigo, 'princial'=>0, 'princial'=>0, 'ejes'=>$ListadoPuntajes];
            }

            $ramos_agrupar_ejes = ArrayHelper::index($ramos_agrupar_ejes, 'ramo_id');
        }
        return $ramos_agrupar_ejes;

    }

}
