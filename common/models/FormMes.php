<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class FormMes extends Model
{
    public $mes;




    public function attributeLabels()
    {
        return [
            'mes' => 'Mes',

        ];
    }

}
