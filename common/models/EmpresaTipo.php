<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "empresa_tipo".
 *
 * @property integer $id
 * @property string $nombre
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class EmpresaTipo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'empresa_tipo';
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

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getActivoTipoEmpresa()
    {
        return ArrayHelper::map(EmpresaTipo::find()->where(['activo'=>true])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
          
    }


}
