<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "template".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $imagen
 * @property integer $limiteMinimoCirculo
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $asignable
 */

class Template extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'creado_por'], 'required'],
            [['limiteMinimoCirculo', 'creado_por', 'modificado_por', 'asignable'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion','cuadrados','imagen_original'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['descripcion', 'imagen','imagen_original'], 'string', 'max' => 300]
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
            'descripcion' => 'Descripcion',
            'imagen' => 'Imagen',
            'imagen_original'=> 'Imagen Original', 
            'limiteMinimoCirculo' => 'Limite Minimo Circulo',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'asignable' => 'Asignable',
            'cuadrados' => 'Cuadrados',
            
        ];
    }

    /* Realizamos la busqueda en la base de datos de los Ramos  */
    public static function getTemplatesAsignables()
    {

        return Template::findAll(['asignable' => 1,]);
        
    }

    public static function getTemplateCombo(){
        // obtengo los valores de Region(id y nombre) 
       $data =  ArrayHelper::map(Template::find()->where(['activo'=>true])->all(), 'id', 'nombre') ;

       return $data;
   
   }

}
