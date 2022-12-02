<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "configuracion".
 *
 * @property string $id
 * @property string $anio_academico
 * @property integer $anio_forzado
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property string $creado_por
 * @property string $fecha_modificacion
 * @property string $modificado_por
 */

class Configuracion extends \yii\db\ActiveRecord
{

    public $nombre = "";

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'configuracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['anio_academico', 'anio_forzado', 'creado_por'], 'required'],
            [['anio_forzado', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['anio_academico'], 'string', 'max' => 4],
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
            'anio_academico' => 'Anio Academico',
            'anio_forzado' => 'Anio Forzado',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    public static function getAnio()
    {
        $curso =  ArrayHelper::map(Configuracion::find()->select('id,anio_academico as nombre')->where(['activo'=>true])->all(), 'id', 'nombre') ;
        
         return $curso;
    }

}
