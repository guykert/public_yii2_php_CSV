<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "asistencia".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $asignatura_curso_id
 * @property integer $estado_asistencia_id
 * @property integer $activo
 * @property integer $creado_por
 * @property string $fecha_creacion
 * @property integer $modificado_por
 * @property string $fecha_modificacion
 * @property string $fecha
 */

class Asistencia extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'asistencia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'asignatura_curso_id', 'estado_asistencia_id', 'creado_por'], 'required'],
            [['usuario_id', 'asignatura_curso_id', 'estado_asistencia_id', 'activo', 'creado_por', 'modificado_por'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion', 'fecha'], 'safe'],
            [['usuario_id', 'asignatura_curso_id', 'estado_asistencia_id', 'fecha'], 'unique', 'targetAttribute' => ['usuario_id', 'asignatura_curso_id', 'estado_asistencia_id', 'fecha']]
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
            'asignatura_curso_id' => 'Asignatura Curso ID',
            'estado_asistencia_id' => 'Estado Asistencia ID',
            'activo' => 'Activo',
            'creado_por' => 'Creado Por',
            'fecha_creacion' => 'Fecha Creacion',
            'modificado_por' => 'Modificado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'fecha' => 'Fecha',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getConfirmarAsistenciaCursoAsignatura($asignatura_curso_id,$fecha)
    {
        $Asistencia = Asistencia::find()

        ->where(['asistencia.activo'=>true,'asistencia.asignatura_curso_id'=>$asignatura_curso_id,'asistencia.fecha'=>$fecha])
        ->count();

        if($Asistencia > 0){
            return true; 
        }else{
            return false; 
        }
         
           
    }

    public static function getMeses()
    {

        $data = ['3'=>'Marzo','4'=>'Abril','5'=>'Mayo','6'=>'Junio','7'=>'Julio','8'=>'Agosto','9'=>'Septiembre','10'=>'Octubre','11'=>'Noviembre','12'=>'Diciembre'];
        return $data;
    }

    public static function getTitoloDetalleMes($id)
    {

        $nombre_mes ='Detalle asistencia mes de Enero';    
        $nombre_solo_mes = 'Enero';



        $titulo = [   '1'=>'Detalle asistencia mes de Enero',
                    '2'=>'Detalle asistencia mes de Febrero',
                    '3'=>'Detalle asistencia mes de Marzo',
                    '4'=>'Detalle asistencia mes de Abril',
                    '5'=>'Detalle asistencia mes de Mayo',
                    '6'=>'Detalle asistencia mes de Junio',
                    '7'=>'Detalle asistencia mes de Julio',
                    '8'=>'Detalle asistencia mes de Agosto',
                    '9'=>'Detalle asistencia mes de Septiembre',
                    '10'=>'Detalle asistencia mes de Octubre',
                    '11'=>'Detalle asistencia mes de Noviembre',
                    '12'=>'Detalle asistencia mes de Diciembre',];

        $nombre = [   '1'=>'Enero',
                    '2'=>'Febrero',
                    '3'=>'Marzo',
                    '4'=>'Abril',
                    '5'=>'Mayo',
                    '6'=>'Junio',
                    '7'=>'Julio',
                    '8'=>'Agosto',
                    '9'=>'Septiembre',
                    '10'=>'Octubre',
                    '11'=>'Noviembre',
                    '12'=>'Diciembre',];

        $data = [
            'titulo'=>$titulo[$id],
            'nombre'=>$nombre[$id],  
        ];

        return $data;
    }

}
