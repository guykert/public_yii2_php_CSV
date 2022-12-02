<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class MallaHorariaClonar extends Model
{

    public $colegio_origen_id;
    public $colegio_id;
    public $malla_horaria_id;

    public function rules()
    {
        return [
            // username and password are both required
            [['colegio_id', 'malla_horaria_id', 'colegio_origen_id'], 'required'],
            [['colegio_id', 'malla_horaria_id', 'colegio_origen_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'colegio_origen_id' => 'Colegio Origen',
            'colegio_id' => 'Colegio',
            'malla_horaria_id' => 'Malla Horaria',

        ];
    }

}
