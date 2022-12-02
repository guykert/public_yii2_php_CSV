<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "ciudad".
 *
 * @property string $id
 * @property string $region_id
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property string $creado_por
 * @property string $fecha_modificacion
 * @property string $modificado_por
 */

class Ciudad extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ciudad';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['region_id', 'nombre', 'creado_por'], 'required'],
            [['region_id', 'creado_por', 'modificado_por'], 'integer'],
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
            'region_id' => 'Region ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    public function getRegion()
    {
        return $this->hasOne(Region::className(),['id'=>'region_id']);
    }

    public static function getActivoCiudad($id_region)
    {
        $sql = Ciudad::find()->where(['region_id'=>$id_region,'activo'=> true])->select(['id','nombre as name'])->asArray()->all();

        return $sql ; 
    }
   
   public static function getActivoComuna($id_provincia)
   {
         $sql = Comuna::find()->where(['provincia_id'=>$id_provincia,'activo'=> true])->select(['id','nombre as name'])->asArray()->all();
        
         return $sql ; 
   }
    
}
