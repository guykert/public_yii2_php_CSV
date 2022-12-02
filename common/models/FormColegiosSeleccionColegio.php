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
class FormColegiosSeleccionColegio extends User
{

    public $colegio_predeterminada;


    /**
     * @var \common\models\User
     */
    private $_user;




    /**
     * @inheritdoc
     */
    public function rules()
    {

        return [

            [['colegio_predeterminada'],'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'colegio_predeterminada' => 'Colegio',

        ];
    }

}
