<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "rol".
 *
 * @property string $id
 * @property string $name
 * @property string $regla_name
 * @property string $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property string $created_at
 * @property string $updated_at
 * @property string $fecha_creacion
 * @property string $fecha_modificacion
 * @property boolean $activo
 */

class Rol extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'rol';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'created_at'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['activo'], 'boolean'],
            [['name', 'regla_name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'regla_name' => 'Regla Name',
            'type' => 'Type',
            'description' => 'Description',
            'rule_name' => 'Rule Name',
            'data' => 'Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'fecha_creacion' => 'Fecha Creacion',
            'fecha_modificacion' => 'Fecha Modificacion',
            'activo' => 'Activo',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
     public static function getRolTipos()
    {
        return ArrayHelper::map(RolTipo::find()->where(['activo'=>true])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
          
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getRolTipo()
    {
        return $this->hasOne(RolTipo::className(),['id'=>'type']);
    }

    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getSubroles()
    {

        return Rol::findAll(['type' => 2,]);
        
    }

    /* consulto si este subRon ya está asignado al rol principal  */
    public static function getConfirnarCargados($rolPrinicipal,$rolHijo)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = RolHijo::find()->where(['parent' => $rolPrinicipal,'child' => $rolHijo])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* asignamos este subRol al rol principal  */
    public static function asignarSubRol($rolHijo,$rolPrinicipal)
    {

        $auth = Yii::$app->authManager;
        $authRolPrinicipal = $auth->getRole($rolPrinicipal);

        $authRolHijo = $auth->getPermission($rolHijo);

        $auth->addChild($authRolPrinicipal, $authRolHijo);

    }

    /* Eliminamos este subRol al rol principal  */
    public static function eliminarSubRol($rolHijo,$rolPrinicipal)
    {

        $auth = Yii::$app->authManager;
        $authRolPrinicipal = $auth->getRole($rolPrinicipal);

        $authRolHijo = $auth->getPermission($rolHijo);


        $auth->removeChild($authRolPrinicipal, $authRolHijo);
        
    }

    /* Realizamos la busqueda en la base de datos de los Ramos  */
    public static function getRoles()
    {

        $query = Rol::find()->where(['type' => 1])

        ->orderby(['name'=>SORT_ASC]);

        if(!(Yii::$app->authManager->checkAccess(Yii::$app->user->identity->id, 'administrador'))){
        
            $query->andWhere(['not',['or',['name' => 'administrador'],['name' => 'sub_administrador']]]);

        }

        $query = $query->All();


        return $query;
        
    }

    /* consulto si el usuario tiene asignado el rol  */
    public static function getConfirnarAsignados($idUsuario,$rol)
    {

        // consulto si este usuario tiene asignado el rol

        $data = RolUsuario::find()->where(['user_id' => $idUsuario,'item_name' => $rol])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* asignamos este Rol al usuario  */
    public static function asignarRolUsuario($userid,$rol)
    {
        
        $auth = Yii::$app->authManager;
        $rol = $auth->getRole($rol);
        $auth->assign($rol, $userid);

        // Busco el id del rol

        $data = RolUsuario::find()
                ->select(['rol.id as id'])
                ->join('INNER JOIN', 'rol','rol.name =rol_usuario.item_name') 
                ->where(['user_id' => $userid,'item_name' => $rol->name])->one();

        // cargo el modelo del usuario.

        $Usuario = User::findOne([
                        'status' => User::STATUS_ACTIVE,
                        'id' => $userid,
                    ]);



        // le asigno el nuevo rol como predeterminado

        $Usuario->rol_predeterminado = $data->id;

        // guardo el modelo

        $Usuario->save();


    }

    /* asignamos este SubRol al usuario  */
    public static function asignarRolUsuarioPermiso($userid,$rol)
    {

        $auth = Yii::$app->authManager;
        $rol = $auth->getPermission($rol);
        $auth->assign($rol, $userid);

    }

    /* Eliminamos este SubRol al usuario  */
    public static function eliminarRolUsuarioPermiso($userid,$rol)
    {

        $auth = Yii::$app->authManager;
        $rol = $auth->getPermission($rol);
        $auth->revoke($rol, $userid);
        
    }
    

    /* Eliminamos este Rol al usuario  */
    public static function eliminarRolUsuario($userid,$rol)
    {

        $auth = Yii::$app->authManager;
        $rol = $auth->getRole($rol);
        $auth->revoke($rol, $userid);
        
        // primero veo si el usuario tiene otros roles para dejarle como predeterminado ya que le sacaremos el que tiene en caso de que coincida con el eliminado

        // Busco el id del rol

        $data = RolUsuario::find()
                ->select(['rol.id as id'])
                ->join('INNER JOIN', 'rol','rol.name =rol_usuario.item_name') 
                ->where(['user_id' => $userid])->one();

        // cargo el modelo del usuario.

        $Usuario = User::findOne([
                        'status' => User::STATUS_ACTIVE,
                        'id' => $userid,
                    ]);

        if($data){

            // si tiene otros roles se lo dejo como predeterminado

            // le asigno el nuevo rol como predeterminado

            $Usuario->rol_predeterminado = $data->id;

        }else{

            // en caso de no tener otros se deja el campo nulo

            $Usuario->rol_predeterminado = "";

        }

        // guardo el modelo

        $Usuario->save();


    }


}
