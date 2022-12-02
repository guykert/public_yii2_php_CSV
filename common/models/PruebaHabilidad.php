<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_habilidad".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $orden
 */

class PruebaHabilidad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_habilidad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion','nivel_id','ramo_id'], 'safe'],
            [['creado_por','nivel_id','ramo_id'], 'required'],
            [['creado_por', 'modificado_por','ramo_id', 'orden'], 'integer'],
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
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'orden' => 'Orden',
            'nivel_id' => 'Nivel',
            'ramo_id' => 'Ramo',
        ];
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getNivel()
    {
        return $this->hasOne(Nivel::className(),['id'=>'nivel_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getRamo()
    {
        return $this->hasOne(Ramo::className(),['id'=>'ramo_id']);
    }

}
