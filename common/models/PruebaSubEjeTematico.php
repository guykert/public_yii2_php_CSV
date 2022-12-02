<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_sub_eje_tematico".
 *
 * @property integer $id
 * @property integer $ramo_id
 * @property integer $eje_tematico_id
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class PruebaSubEjeTematico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_sub_eje_tematico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ramo_id', 'eje_tematico_id', 'nombre', 'creado_por'], 'required'],
            [['ramo_id', 'eje_tematico_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['nombre'], 'string', 'max' => 100],
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
            'ramo_id' => 'Ramo',
            'eje_tematico_id' => 'Eje Tematico',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getRamo()
    {
        return $this->hasOne(Ramo::className(),['id'=>'ramo_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getEje()
    {
        return $this->hasOne(PruebaEjeTematico::className(),['id'=>'eje_tematico_id']);
    }

}
