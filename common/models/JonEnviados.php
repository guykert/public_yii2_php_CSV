<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "jon_enviados".
 *
 * @property integer $id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property string $json
 */

class JonEnviados extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'jon_enviados';
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
            [['json'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'json' => 'Json',
        ];
    }
}
