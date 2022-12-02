<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "rol_tipo".
 *
 * @property string $id
 * @property string $nombre
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property string $creado_por
 * @property string $fecha_modificacion
 * @property string $modificado_por
 */

class RolTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol_tipo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['creado_por', 'modificado_por'], 'integer'],
            [['nombre'], 'string', 'max' => 100]
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
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }
}
