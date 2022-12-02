<?php
namespace common\models;

use Yii;
use yii\base\Model;

use sateler\rut\RutValidator;


/**
 * Login form
 */
class FormRut extends Model
{
    public $rut;
    public $prueba_id;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['rut','prueba_id'], 'required'],
            [['rut'], 'string', 'max' => 100],
            ['rut', RutValidator::className()]
        ];
    }

    public function attributeLabels()
    {
        return [
            'rut' => 'Rut',
            'prueba_id' => 'Prueba',

        ];
    }

}
