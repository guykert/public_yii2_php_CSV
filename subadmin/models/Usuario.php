<?php

namespace backend\models;

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
class Usuario extends ActiveRecord implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['edad', 'clave_actualizada', 'status', 'updated_at', 'creado_por', 'created_at', 'modificado_por', 'rol_predeterminado', 'anio_predeterminado'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['rut'], 'string', 'max' => 11],
            [['nombre'], 'string', 'max' => 120],
            [['apellido_paterno', 'apellido_materno'], 'string', 'max' => 80],
            ['apellido_paterno','validateCarateres'],
            ['apellido_materno','validateCarateres'],
            ['nombre','validateCarateres'],
            ['telefono2','validateCarateres'],
            ['telefono1','validateCarateres'],
            ['email','validateCarateresEmail'],
            [['sexo'], 'string', 'max' => 1],
            [['email', 'email2', 'telefono1', 'telefono2'], 'string', 'max' => 60],
            [['username'], 'string', 'max' => 50],
            [['auth_key', 'password_reset_token', 'password_hash'], 'string', 'max' => 255],
            [['passwordResetTokenExpire'], 'string', 'max' => 200],
            [['rut'], 'unique'],
            // ['rut','validateRut'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rut' => 'Rut',
            'nombre' => 'Nombre',
            'apellido_paterno' => 'Apellido Paterno',
            'apellido_materno' => 'Apellido Materno',
            'sexo' => 'Sexo',
            'edad' => 'Edad',
            'email' => 'Email',
            'email2' => 'Email2',
            'telefono1' => 'Telefono1',
            'telefono2' => 'Telefono2',
            'username' => 'Username',
            'clave_actualizada' => 'Clave Actualizada',
            'auth_key' => 'Auth Key',
            'password_reset_token' => 'Password Reset Token',
            'password_hash' => 'Password Hash',
            'status' => 'Status',
            'activo' => 'Activo',
            'updated_at' => 'Updated At',
            'fecha_creacion' => 'Fecha Creacion',
            'fecha_modificacion' => 'Fecha Modificacion',
            'creado_por' => 'Creado Por',
            'created_at' => 'Created At',
            'modificado_por' => 'Modificado Por',
            'passwordResetTokenExpire' => 'Password Reset Token Expire',
            'rol_predeterminado' => 'Rol Predeterminado',
            'anio_predeterminado' => 'Anio Predeterminado',
        ];
    }

    public function validateCarateres($attribute, $params)
    {
         //  \t tabulacion  \n salto de linea \r retorno de carro
         $final=preg_replace('/[\t-\n-\r]/',' ',(string) trim($this->$attribute));
         $this->$attribute=$final;

    }    

    public function validateCarateresEmail($attribute, $params)
    {
         //  \t tabulacion  \n salto de linea \r retorno de carro
         $final=preg_replace('/[\t \n \r]/','',(string) trim($this->$attribute));
         $this->$attribute=$final;

    } 

    public function validateRut($attribute, $params)
    {

        if($this->$attribute == "11111111-1" || $this->$attribute == "22222222-2" || $this->$attribute == "33333333-3" || $this->$attribute == "44444444-4" || $this->$attribute == "55555555-5" || $this->$attribute == "66666666-6" || $this->$attribute == "77777777-7" || $this->$attribute == "88888888-8" || $this->$attribute == "99999999-9"  || $this->$attribute == "1-9" ){

            $this->addError($attribute, "Rut inválido.");
        }else{

            if(strlen($this->$attribute) < 1 || strlen($this->$attribute) > 10){  

                $this->addError($attribute, "Rut inválido.");
            }else{

                if(!preg_match("/[0-9]{5,8}[-][kK0-9]/", $this->$attribute)) {

                    $this->addError($attribute, "Rut inválido.");
                }else{

                    $name = strtoupper(preg_replace('/[^0-9kK]/','',(string) $this->$attribute));

                    $sub_rut=substr($name,0,strlen($name)-1);

                    $sub_dv=substr($name,-1);

                    $x=2;
                    $s=0;

                    for ( $i=strlen($sub_rut)-1;$i>=0;$i-- )
                    {
                        if ( $x >7 )
                        {
                            $x=2;
                        }
                        $s += $sub_rut[$i]*$x;
                        $x++;
                    }

                    $dv=11-($s%11);

                    if ( $dv==10 )
                    {
                        $dv='K';
                    }
                    if ( $dv==11 )
                    {
                        $dv='0';
                    }

                    if ( $dv!=$sub_dv )
                    {

                        $this->addError($attribute, "Rut inválido.");

                    }
                }
            }
        }

    }
    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public static function isActive()
    {
        return Yii::$app->user->identity->status == self::STATUS_ACTIVE;
    }
}
