<?php

namespace app\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_pauta".
 *
 * @property integer $id
 * @property integer $prueba_id
 * @property integer $numero_pregunta
 * @property string $correcta
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property boolean $activo
 * @property integer $eje_tematico
 * @property integer $habilidad_id
 * @property integer $sub_tema_id
 */

class PruebaPauta extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_pauta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prueba_id', 'numero_pregunta', 'creado_por', 'modificado_por', 'eje_tematico', 'habilidad_id', 'sub_tema_id'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['correcta'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prueba_id' => 'Prueba ID',
            'numero_pregunta' => 'Numero Pregunta',
            'correcta' => 'Correcta',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
            'eje_tematico' => 'Eje Tematico',
            'habilidad_id' => 'Habilidad ID',
            'sub_tema_id' => 'Sub Tema ID',
        ];
    }
}
