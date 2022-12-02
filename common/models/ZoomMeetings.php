<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "zoom_meetings".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $curso_id
 * @property integer $activo
 * @property integer $creado_por
 * @property string $fecha_creacion
 * @property integer $modificado_por
 * @property string $fecha_modificacion
 * @property string $fecha
 * @property string $fecha_inicio_meeting
 * @property integer $bloque_id
 * @property string $id_zoom_meeting
 * @property string $enlace_meeting
 * @property string $enlace_iniciar_meeting
 */

class ZoomMeetings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'zoom_meetings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'creado_por'], 'required'],
            [['usuario_id', 'curso_id', 'activo', 'creado_por', 'modificado_por', 'bloque_id'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion', 'fecha', 'fecha_inicio_meeting'], 'safe'],
            [['enlace_iniciar_meeting'], 'string'],
            [['id_zoom_meeting'], 'string', 'max' => 120],
            [['enlace_meeting'], 'string', 'max' => 300],
            [['usuario_id', 'curso_id', 'fecha', 'bloque_id'], 'unique', 'targetAttribute' => ['usuario_id', 'curso_id', 'fecha', 'bloque_id']]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'curso_id' => 'Curso ID',
            'activo' => 'Activo',
            'creado_por' => 'Creado Por',
            'fecha_creacion' => 'Fecha Creacion',
            'modificado_por' => 'Modificado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha' => 'Fecha',
            'fecha_inicio_meeting' => 'Fecha Inicio Meeting',
            'bloque_id' => 'Bloque ID',
            'id_zoom_meeting' => 'Id Zoom Meeting',
            'enlace_meeting' => 'Enlace Meeting',
            'enlace_iniciar_meeting' => 'Enlace Iniciar Meeting',
        ];
    }

    public static function getConferencias($curso_id,$bloque_id,$fecha,$dia) {

        $fecha2 = date("Y-m-d");
  
        $ZoomMeetings = ZoomMeetings::find()

        //->where(['curso.id'=>$curso_id,'curso.activo' => 1])
        ->where(['curso_id' => $curso_id,'activo'=>1,'bloque_id'=>$bloque_id])
        ->andWhere(['>=', 'fecha', $fecha2 ])

        ->all();

        foreach ($ZoomMeetings as $key => $ZoomMeeting) {

            if($dia != date("w",strtotime($ZoomMeeting->fecha))){
                ArrayHelper::remove($ZoomMeetings, $key);
            }


        }

        return $ZoomMeetings;


    }

    public static function getConferenciasTalleres($curso_id,$bloque_id,$fecha,$dia) {

        $fecha2 = date("Y-m-d");
  
        $ZoomMeetings = ZoomMeetings::find()

        //->where(['curso.id'=>$curso_id,'curso.activo' => 1])
        ->where(['taller_id' => $curso_id,'activo'=>1,'bloque_id'=>$bloque_id])
        ->andWhere(['>=', 'fecha', $fecha2 ])

        ->all();

        foreach ($ZoomMeetings as $key => $ZoomMeeting) {

            if($dia != date("w",strtotime($ZoomMeeting->fecha))){
                ArrayHelper::remove($ZoomMeetings, $key);
            }


        }

        return $ZoomMeetings;


    }

    public static function ConfirmarMeeting($usuario_id,$curso_id,$bloque,$fecha) {


        $ZoomMeetings = ZoomMeetings::find()

        //->where(['curso.id'=>$curso_id,'curso.activo' => 1])
        ->where(['usuario_id'=>$usuario_id,'curso_id' => $curso_id,'activo'=>1,'fecha'=>$fecha,'bloque_id'=>$bloque])

        ->one();

        return $ZoomMeetings;


    }


}
