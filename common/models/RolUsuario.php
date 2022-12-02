<?php

namespace common\models;
use yii\helpers\ArrayHelper;    
use Yii;

/**
 * This is the model class for table "rol_usuario".
 *
 * @property string $item_name
 * @property string $user_id
 * @property string $rol_id
 * @property string $usuario_id
 * @property string $created_at
 * @property string $fecha_creacion
 * @property string $fecha_modificacion
 * @property string $modificado_por
 * @property boolean $activo
 */
class RolUsuario extends \yii\db\ActiveRecord
{

    public $nombre;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol_usuario';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id', 'created_at'], 'required'],
            [['rol_id', 'usuario_id', 'created_at', 'modificado_por'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['activo'], 'boolean'],
            [['item_name', 'user_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'rol_id' => 'Rol ID',
            'usuario_id' => 'Usuario ID',
            'created_at' => 'Created At',
            'fecha_creacion' => 'Fecha Creacion',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
        ];
    }

    public static function getCantidadRolesUsuario($id_usuario)
    {

        $sedes =    RolUsuario::find()
                    ->where(['rol_usuario.activo'=>true,'rol_usuario.user_id'=>$id_usuario])->count();
        
        return $sedes;
    }

    public static function getRolesUsuario($id_usuario)
    {

        return ArrayHelper::map(RolUsuario::find()
                    ->select(['rol.id as id','rol.name as  nombre'])
                    ->join('INNER JOIN', 'rol','rol.name =rol_usuario.item_name')  
                    ->where(['rol_usuario.activo'=>true,'rol_usuario.user_id'=>$id_usuario])->all(), 'id', 'nombre') ;
        
    }

    public static function getIdRolUsuario($id_usuario,$rol)
    {

        return ArrayHelper::map(RolUsuario::find()
                    ->select(['rol.id as id','rol.name as  nombre'])
                    ->join('INNER JOIN', 'rol','rol.name =rol_usuario.item_name')  
                    ->where(['rol_usuario.activo'=>true,'rol_usuario.user_id'=>$id_usuario])->all(), 'id', 'nombre') ;
        
    }

}
