<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "template_formula".
 *
 * @property integer $id
 * @property integer $template_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $formula
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class TemplateFormula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_formula';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['descripcion'], 'string', 'max' => 300],
            [['formula'], 'string', 'max' => 120]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_id' => 'Template ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'formula' => 'Formula',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }
}
