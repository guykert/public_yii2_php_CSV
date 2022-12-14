<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "malla_horaria_colegio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $anio_id
 * @property integer $colegio_id
 */

class MallaHorariaColegio extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'malla_horaria_colegio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por', 'modificado_por', 'anio_id', 'colegio_id'], 'integer'],
            [['nombre'], 'string', 'max' => 60],
            [['descripcion'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'anio_id' => 'Anio ID',
            'colegio_id' => 'Colegio ID',
        ];
    }

    public static function getActivoMayasColegio($id_empresa_origen)
    {

        $MallaHorariaColegio  = MallaHorariaColegio::find()
                    ->where(['colegio_id'=>$id_empresa_origen, 'activo'=> true])
                    ->select(['id as id','nombre as name']);


        $MallaHorariaColegio  = $MallaHorariaColegio->asArray()
                    ->all() ;

        return $MallaHorariaColegio ;

    }

    /* funci??n que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getMallaCombo()
    {
        $data =  ArrayHelper::map(MallaHorariaColegio::find()->where(['activo'=>true,'colegio_id'=>Yii::$app->user->identity->colegio_predeterminada])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
         
        return $data ;    
    }

}
