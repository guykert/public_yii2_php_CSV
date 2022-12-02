<?php

namespace app\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_categoria".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $contiene_subramos
 * @property string $codigo
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class PruebaCategoria extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_categoria';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['contiene_subramos', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['nombre'], 'string', 'max' => 150],
            [['descripcion'], 'string', 'max' => 300],
            [['codigo'], 'string', 'max' => 5]
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
            'contiene_subramos' => 'Contiene Subramos',
            'codigo' => 'Codigo',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }
}
