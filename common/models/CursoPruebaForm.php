<?php
namespace common\models;

use common\models\User;
use yii\base\InvalidParamException;
use yii\base\Model;
use Yii;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;

/**
 * Password reset form
 */
class CursoPruebaForm extends User
{
    public $curso_id;

    public $prueba_id;





    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            // [['password', 'password_repeat'], 'required', 'message' => 'Campo requerido'],
            [['prueba_id', 'curso_id'], 'required'],
            [['prueba_id', 'curso_id'], 'integer'],

        ];
    }

     public function attributeLabels()
    {
        return [
            'prueba_id' => 'Prueba',
            'curso_id' => 'Curso',
        ];
    }


}
