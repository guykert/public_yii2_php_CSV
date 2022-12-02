<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "nivel".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $ciclo
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class Nivel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nivel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'ciclo', 'creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por', 'modificado_por'], 'integer'],
            [['nombre', 'ciclo'], 'string', 'max' => 60],
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
            'ciclo' => 'Ciclo',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getNivel()
    {
        $data =  ArrayHelper::map(Nivel::find()->where(['activo'=>true])->all(), 'id', 'nombre') ;
         
        return $data ;    
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getNivelCombo()
    {
        $data =  ArrayHelper::map(Nivel::find()->where(['activo'=>true])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
         
        return $data ;    
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getBuscarNivel($nombre)
    {
        $data =  Nivel::find()->where(['nombre'=>$nombre,'activo'=>true])
        ->orderBy('nombre')->one();
            
        return $data ;    
    }


}
