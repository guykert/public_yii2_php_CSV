<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class AlumnoMultiple extends Model
{
    public $colegio_id;
    public $curso_id;
    public $excel;



    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['curso_id'], 'required','on'=>['segundo_paso']],
            [['excel'], 'required','on'=>['tercer_paso']],
            [['curso_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'colegio_id' => 'Colegio',
            'curso_id' => 'Curso',

        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['segundo_paso'] = ['colegio_id', 'curso_id'];//Scenario Values Only Accepted

        $scenarios['tercer_paso'] = ['colegio_id', 'curso_id', 'excel'];


        return $scenarios;
    }  

}
