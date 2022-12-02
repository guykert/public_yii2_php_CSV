<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "usuario".
 *
 * @property string $id
 * @property string $rut
 * @property string $nombre
 * @property string $apellido_paterno
 * @property string $apellido_materno
 * @property string $sexo 1 - Masculino 2 - Femenino
 * @property string $edad
 * @property string $email
 * @property string $email2
 * @property string $telefono1
 * @property string $telefono2
 * @property string $username
 * @property string $clave_actualizada
 * @property string $auth_key
 * @property string $password_reset_token
 * @property string $password_hash
 * @property string $status
 * @property bool $activo
 * @property string $updated_at
 * @property string $fecha_creacion
 * @property string $fecha_modificacion
 * @property string $creado_por
 * @property int $created_at
 * @property int $modificado_por
 * @property string $passwordResetTokenExpire
 * @property int $rol_predeterminado
 * @property int $anio_predeterminado
 */
class Profesor extends Alumno
{

    public $fecha;

    public function rules()
    {
        return [

            ['username', 'required'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este usuario ya existe.','on'=>['validacionCompletaCrear']],
            ['username', 'string', 'min' => 2, 'max' => 50],
            ['rut','validateRut','on'=>['validacionCompletaCrear','validacionParcial']],

            [['edad', 'clave_actualizada', 'status', 'updated_at', 'creado_por', 'created_at', 'modificado_por', 'rol_predeterminado', 'anio_predeterminado'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion','tipo_alumno_id'], 'safe'],
            [['rut'], 'string', 'max' => 11],
            [['nombre'], 'string', 'max' => 120],
            [['apellido_paterno', 'apellido_materno'], 'string', 'max' => 80],
            ['apellido_paterno','validateCarateres'],
            ['apellido_materno','validateCarateres'],
            ['nombre','validateCarateres'],
            ['telefono2','validateCarateres'],
            ['telefono1','validateCarateres'],
            [['edad'],'number','min'=>1,'max'=>100],
            [['email', 'email2'],'validateCarateresEmail'],
            [['sexo'], 'string', 'max' => 1],
            [['email', 'email2', 'telefono1', 'telefono2'], 'string', 'max' => 60],
            [['username'], 'string', 'max' => 50],
            [['auth_key', 'password_reset_token', 'password_hash'], 'string', 'max' => 255],
            [['passwordResetTokenExpire'], 'string', 'max' => 200],
            [['rut'], 'unique'],
            [['rut','nombre', 'apellido_paterno'],'required'],

        ];
    }

    public function getRolProfesor()
    {
        return $this->hasOne(RolUsuario::className(),['user_id'=>'id']);
    }

    
}
