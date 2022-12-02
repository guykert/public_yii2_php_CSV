<?php

namespace common\models;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "malla_horaria_colegio_bloque".
 *
 * @property integer $id
 * @property integer $dia_id
 * @property integer $bloque
 * @property string $hora_desde
 * @property string $hora_hasta
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $estado
 * @property integer $maya_horaria_id
 */

class MallaHorariaColegioBloque extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'malla_horaria_colegio_bloque';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia_id', 'bloque', 'hora_desde', 'hora_hasta', 'creado_por'], 'required'],
            [['dia_id', 'bloque', 'creado_por', 'modificado_por', 'estado', 'maya_horaria_id'], 'integer'],
            [['hora_desde', 'hora_hasta', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['activo'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia_id' => 'Dia ID',
            'bloque' => 'Bloque',
            'hora_desde' => 'Hora Desde',
            'hora_hasta' => 'Hora Hasta',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'estado' => 'Estado',
            'maya_horaria_id' => 'Maya Horaria ID',
        ];
    }

    public static function getMatrizDatos($maya_horaria_id)
    {
        
        $data =  MallaHorariaColegioBloque::find()
                        ->where(['activo'=>true,'maya_horaria_id'=>$maya_horaria_id])
                        ->select(['id','dia_id','bloque','estado','hora_desde' => new Expression("date_format(hora_desde,'%H:%i')"),'hora_hasta' => new Expression("date_format(hora_hasta,'%H:%i')")])
                        ->asArray()
                        ->all();

        $data = ArrayHelper::index($data, 'id');

        return $data;

    }

    public static function getConfirmacionActiva($maya_horaria_id)
    {

        $data =  MallaHorariaColegioBloque::find()
                        ->where(['activo'=>true,'estado'=>1,'maya_horaria_id'=>$maya_horaria_id])
                        ->asArray()
                        ->count();

         return $data ;
    }

    public static function getBloqueColegio($malla_id)
    {

        $sql  = MallaHorariaColegioBloque::find()
        ->where(['malla_horaria_colegio_bloque.maya_horaria_id'=>$malla_id, 'malla_horaria_colegio_bloque.activo'=> true])
        ->join('INNER JOIN','bloque','bloque.id =malla_horaria_colegio_bloque.bloque')
        ->select(['bloque.id','bloque.nombre as name','hora_desde' => new Expression("date_format(malla_horaria_colegio_bloque.hora_desde,'%H:%i')"),'hora_hasta' => new Expression("date_format(malla_horaria_colegio_bloque.hora_hasta,'%H:%i')")])
        
        ->asArray()
        ->all() ;

        foreach ($sql as $key => &$value) {


            $value["name"] = $value["name"] . " . " . $value["hora_desde"] . " - " . $value["hora_hasta"];
        }



        return $sql ;

    }

}
