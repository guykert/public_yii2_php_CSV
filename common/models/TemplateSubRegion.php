<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "template_sub_region".
 *
 * @property integer $id
 * @property integer $template_region_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $valor
 * @property integer $x
 * @property integer $y
 * @property integer $width
 * @property integer $height
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class TemplateSubRegion extends \yii\db\ActiveRecord
{

    public $template_id;
    public $template_region_general_id;
    public $x2 = 0;
    public $y2 = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_sub_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_region_id', 'x', 'y', 'width', 'height', 'creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion','imagen'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['descripcion'], 'string', 'max' => 300],
            [['valor'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'template_region_id' => 'Template Region ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'valor' => 'Valor',
            'x' => 'X',
            'y' => 'Y',
            'width' => 'Width',
            'height' => 'Height',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }
}
