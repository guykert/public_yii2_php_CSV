<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "template_hijo".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $template_id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class TemplateHijo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'template_hijo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'template_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'usuario_id' => 'Usuario ID',
            'template_id' => 'Template ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* consulto si el usuario tiene asignado el rol  */
    public static function getConfirnarAsignados($idUsuario,$templateID)
    {

        // consulto si este usuario tiene asignado el rol

        $data = TemplateHijo::find()->where(['usuario_id' => $idUsuario,'template_id' => $templateID,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    public static function getTemplatesAsignadosUsuario($id_usuario)
    {

        $arreglo_template_buscar = [];

        // busco los asignados

        $TemplateHijo = TemplateHijo::find()
        
        ->where(['activo' => 1,'usuario_id' => $id_usuario])
        
        ->all();
        

        foreach ($TemplateHijo as $key => $value) {
            $arreglo_template_buscar[] = $value->template_id;
        }





        $data =  ArrayHelper::map(Template::find()
        
        ->where(['activo' => 1,'id' => $arreglo_template_buscar])
        
        ->all(), 'id', 'nombre') ;

        return $data;



    }


}
