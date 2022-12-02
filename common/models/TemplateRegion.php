<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "template_region".
 *
 * @property integer $id
 * @property integer $template_id
 * @property integer $tipo_elemento_id
 * @property string $nombre
 * @property string $descripcion
 * @property string $respuesta
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

class TemplateRegion extends \yii\db\ActiveRecord
{

    public $x2 = 0;
    public $y2 = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_region';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['template_id', 'tipo_elemento_id', 'x', 'y', 'width', 'height', 'creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion', 'template_region_general_id','imagen'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['descripcion'], 'string', 'max' => 300],
            [['respuesta'], 'string', 'max' => 20]
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
            'tipo_elemento_id' => 'Tipo Elemento ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'respuesta' => 'Respuesta',
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

    public static function getRegionComboDep($template_region_general_id)
    {

        $sql  = TemplateRegion::find()
        ->where(['template_region_general_id'=>$template_region_general_id, 'activo'=> true])
        ->select(['id','nombre as name'])->asArray()->all() ;

        return $sql ;

    }
}
