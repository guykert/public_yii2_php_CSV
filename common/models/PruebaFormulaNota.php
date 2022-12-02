<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_formula_nota".
 *
 * @property integer $id
 * @property string $nombre
 * @property double $multiplicados
 * @property integer $sumar
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class PruebaFormulaNota extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_formula_nota';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['multiplicados'], 'number'],
            [['sumar', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['nombre'], 'string', 'max' => 100],
            [['descripcion'], 'string', 'max' => 300]
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
            'multiplicados' => 'Multiplicados',
            'sumar' => 'Sumar',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getformula()
    {

        $data =  ArrayHelper::map(PruebaFormulaNota::find()
        
        ->where(['activo'=>true])
        ->select(['id', 'nombre'])
        ->all(), 'id', 'nombre') ;
            
        return $data ;     
    }

}
