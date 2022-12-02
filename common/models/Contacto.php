<?php

namespace common\models;

use Yii;
use backend\models\Usuario;

/**
 * This is the model class for table "contacto".
 *
 * @property int $id
 * @property string $nombre
 * @property string $email
 * @property string $telefono
 * @property string $descripcion
 * @property string $fecha_creacion
 * @property string $respuesta
 * @property int $respondido_por
 * @property string $fecha_modificacion
 * @property string $estado
 */
class Contacto extends \yii\db\ActiveRecord
{
    public $codigoVerificacion;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'email'], 'required'],
            [['descripcion', 'respuesta'], 'string'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['respondido_por','estado'], 'integer'],
            [['nombre', 'email'], 'string', 'max' => 150],
            [['telefono'], 'string', 'max' => 45],
            // ['codigoVerificacion', 'captcha'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'telefono' => 'Telefono',
            'descripcion' => 'Descripcion',
            'fecha_creacion' => 'Fecha Creacion',
            'respuesta' => 'Respuesta',
            'respondido_por' => 'Respondido Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'estado' => 'Estado',
            //  'codigoVerificacion' => 'Código Verificación',
        ];
    }

    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(),['id'=>'respondido_por']);
    }
}
