<?php

namespace common\models;
use common\models\Ramo;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_eje_tematico".
 *
 * @property integer $id
 * @property integer $ramo_id
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $orden
 */

class PruebaEjeTematico extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_eje_tematico';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ramo_id', 'creado_por','nivel_id'], 'required'],
            [['ramo_id', 'creado_por', 'modificado_por', 'orden'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion','nivel_id'], 'safe'],
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
            'ramo_id' => 'Ramo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'orden' => 'Orden',
            'nivel_id' => 'Nivel',
        ];
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getRamo()
    {
        return $this->hasOne(Ramo::className(),['id'=>'ramo_id']);
    }

    public static function getActivoEjeTematico($ramo_id)
    {

        $sql  = PruebaEjeTematico::find()->where(['ramo_id'=>$ramo_id, 'activo'=> true])->select(['id','nombre as name'])->asArray()->all() ;

        return $sql ;

    }

    public static function getActivoEjeTematicoCombo($ramo_id)
    {

        $data =  ArrayHelper::map(PruebaEjeTematico::find()
        ->where(['ramo_id'=>$ramo_id, 'activo'=> true])
        ->select(['id','nombre as nombre'])
        ->asArray()
        ->all(), 'id', 'nombre') ;
         
        return $data ; 

    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getNivel()
    {
        return $this->hasOne(Nivel::className(),['id'=>'nivel_id']);
    }

}
