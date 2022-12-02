<?php

namespace common\models;

use yii\helpers\FileHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_pauta".
 *
 * @property integer $id
 * @property integer $prueba_id
 * @property integer $numero_pregunta
 * @property string $correcta
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property boolean $activo
 * @property integer $eje_tematico
 * @property integer $habilidad_id
 * @property integer $sub_tema_id
 */

class PruebaPauta extends \yii\db\ActiveRecord
{

    public $excel;


    public $respuesta_alumno = "";

    public $solucionario_id = "";
    public $pregunta_id = "";
    public $resultado_pregunta = "Omitida";
    public $resultado_pregunta_bonus = "Desafío Superado";
    public $buenas = 0;
    public $malas = 0;
    public $omitidas = 0;
    public $respuesta="";
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_pauta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prueba_id', 'numero_pregunta', 'creado_por', 'modificado_por', 'eje_tematico', 'habilidad_id', 'sub_tema_id'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion','sub_eje_tematico'], 'safe'],
            [['creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['excel'], 'required','on'=>['carga_excel']],
            [['correcta'], 'string', 'max' => 1]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prueba_id' => 'Prueba ID',
            'numero_pregunta' => 'Numero Pregunta',
            'correcta' => 'Correcta',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
            'eje_tematico' => 'Eje Tematico',
            'habilidad_id' => 'Habilidad ID',
            'sub_tema_id' => 'Sub Tema ID',
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['carga_excel'] = ['excel','prueba_id'];

        return $scenarios;
    }

    /*genera la relación entre la prueba del alumno y laprueba  por medio del id*/
    public function getEjes ()
    {

        return $this->hasOne(PruebaEjeTematico::className(),['id'=>'eje_tematico']);

    }

    /*genera la relación entre la prueba del alumno y laprueba  por medio del id*/
    public function getSubEjes ()
    {

        return $this->hasOne(PruebaSubEjeTematico::className(),['id'=>'sub_eje_tematico']);

    }

    /*genera la relación entre la prueba del alumno y laprueba  por medio del id*/
    public function getHabilidades ()
    {

        return $this->hasOne(PruebaHabilidad::className(),['id'=>'habilidad_id']);

    }

    /*genera la relación entre la prueba del alumno y laprueba  por medio del id*/
    public function getEjesRamos ()
    {

        return $this->hasOne(PruebaEjeTematico::className(),['id'=>'eje_tematico']);

    }

    public function creoDirectorios() {
        $ruta = Yii::$app->params['uploadPath'] . "/" . Yii::$app->user->identity->id."/profile/";


        FileHelper::createDirectory($ruta);

    }

}
