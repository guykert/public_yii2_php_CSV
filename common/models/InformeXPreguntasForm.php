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
class InformeXPreguntasForm extends User
{
    public $curso_id;
    public $nivel_id;
    public $prueba_id;
    public $prueba_categoria_id;
    public $ramo_id;





    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [
            // [['password', 'password_repeat'], 'required', 'message' => 'Campo requerido'],
            [['prueba_id'], 'required'],
            [['prueba_id', 'curso_id', 'nivel_id', 'ramo_id','prueba_categoria_id'], 'integer'],

        ];
    }

     public function attributeLabels()
    {
        return [
            'prueba_id' => 'Prueba',
            'curso_id' => 'Curso',
            'nivel_id' => 'Nivel',
            'ramo_id' => 'Ramo',
            'prueba_categoria_id' => 'Categoría',
        ];
    }


}
