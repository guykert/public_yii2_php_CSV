<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "empresa_hijo".
 *
 * @property integer $id
 * @property string $nombre_padre
 * @property string $nombre_hijo
 * @property integer $padre_id
 * @property integer $hijo_id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class EmpresaHijo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_hijo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['padre_id', 'hijo_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['nombre_padre', 'nombre_hijo'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre_padre' => 'Nombre Padre',
            'nombre_hijo' => 'Nombre Hijo',
            'padre_id' => 'Padre ID',
            'hijo_id' => 'Hijo ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }
}
