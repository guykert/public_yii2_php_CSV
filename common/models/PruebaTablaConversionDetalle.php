<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_tabla_conversion_detalle".
 *
 * @property integer $id
 * @property integer $tabla_conversion_id
 * @property integer $preguntas_correctas
 * @property integer $puntaje
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class PruebaTablaConversionDetalle extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_tabla_conversion_detalle';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tabla_conversion_id', 'preguntas_correctas', 'puntaje', 'creado_por'], 'required'],
            [['tabla_conversion_id', 'preguntas_correctas', 'puntaje', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
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
            'tabla_conversion_id' => 'Tabla Conversion ID',
            'preguntas_correctas' => 'Preguntas Correctas',
            'puntaje' => 'Puntaje',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }
}
