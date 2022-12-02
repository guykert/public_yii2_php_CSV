<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rol_hijo".
 *
 * @property string $parent
 * @property string $child
 * @property integer $rol_id
 * @property integer $creado_por
 * @property string $fecha_creacion
 * @property integer $modificado_por
 * @property string $fecha_modificacion
 * @property boolean $activo
 */
class RolHijo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol_hijo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['rol_id', 'creado_por', 'modificado_por'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['activo'], 'boolean'],
            [['parent', 'child'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
            'rol_id' => 'Rol ID',
            'creado_por' => 'Creado Por',
            'fecha_creacion' => 'Fecha Creacion',
            'modificado_por' => 'Modificado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'activo' => 'Activo',
        ];
    }
}
