<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class PruebaClonar extends Model
{

    public $colegio_origen_id;
    public $colegio_id;
    public $nivel_id;
    public $prueba_id;
    public $anio_predeterminado;
    

    public function rules()
    {
        return [
            // username and password are both required
            [['colegio_id', 'prueba_id', 'colegio_origen_id'], 'required'],
            [['colegio_id', 'prueba_id', 'colegio_origen_id'], 'integer'],
            [['anio_predeterminado'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'colegio_origen_id' => 'Colegio Origen',
            'colegio_id' => 'Colegio',
            'prueba_id' => 'Prueba',
            'anio_predeterminado' => 'Año',

        ];
    }

}
