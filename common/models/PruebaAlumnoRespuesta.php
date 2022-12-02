<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_alumno_respuesta".
 *
 * @property integer $id
 * @property integer $prueba_alumno_id
 * @property string $respuesta
 * @property integer $pregunta_id
 * @property integer $numero_pregunta
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property boolean $activo
 */

class PruebaAlumnoRespuesta extends \yii\db\ActiveRecord
{

    public $correcta = "";
    public $pregunta = 0 ;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_alumno_respuesta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prueba_alumno_id', 'pregunta_id', 'numero_pregunta', 'creado_por', 'modificado_por'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['respuesta'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prueba_alumno_id' => 'Prueba Alumno ID',
            'respuesta' => 'Respuesta',
            'pregunta_id' => 'Pregunta ID',
            'numero_pregunta' => 'Numero Pregunta',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public function guardarRespuestas($respuestas,$pruebaAlmuno_id,$usuario_id)
    {




        $numero_pregunta = 1;

        foreach ($respuestas as $key => $respuesta) {

            $PruebaAlumnoRespuesta = new PruebaAlumnoRespuesta();
            $PruebaAlumnoRespuesta->fecha_creacion = date("Y-m-d H:i:s");
            $PruebaAlumnoRespuesta->creado_por = $usuario_id;
            $PruebaAlumnoRespuesta->numero_pregunta = $numero_pregunta;
            $PruebaAlumnoRespuesta->respuesta = $respuesta["rm"];
            $PruebaAlumnoRespuesta->prueba_alumno_id = $pruebaAlmuno_id;
            $PruebaAlumnoRespuesta->save();


            
            $numero_pregunta++;

        }

    }


}
