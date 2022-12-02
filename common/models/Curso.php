<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "curso".
 *
 * @property integer $id
 * @property integer $sub_ramo_id
 * @property integer $colegio_id
 * @property string $codigo
 * @property string $nombre
 * @property string $descripcion
 * @property integer $capacidad
 * @property integer $cupo
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $anio_id
 * @property integer $ramo_id
 */

class Curso extends \yii\db\ActiveRecord
{

    public $colegioNombre = "";


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['colegio_id', 'capacidad', 'creado_por','nivel_id'], 'required'],
            [['colegio_id', 'capacidad', 'cupo', 'creado_por', 'modificado_por', 'anio_id'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion','ramo_id','nivel_id','letra_id'], 'safe'],
            [['codigo'], 'string', 'max' => 20],
            [['nombre'], 'string', 'max' => 80],
            [['descripcion'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'colegio_id' => 'Colegio',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'capacidad' => 'Capacidad',
            'cupo' => 'Cupo',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'anio_id' => 'Anio',
            'nivel_id' => 'Nivel',
            'letra_id' => 'Letra',
        ];
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getRamo()
    {
        return $this->hasOne(Ramo::className(),['id'=>'ramo_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getSubRamo()
    {
        return $this->hasOne(SubRamo::className(),['id'=>'sub_ramo_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getColegio()
    {
        return $this->hasOne(Empresa::className(),['id'=>'colegio_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getNivel()
    {
        return $this->hasOne(Nivel::className(),['id'=>'nivel_id']);
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getLetra()
    {
        return $this->hasOne(Letra::className(),['id'=>'letra_id']);
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getSubRamoCombo($ramo_id)
    {
        $data =  ArrayHelper::map(SubRamo::find()->where(['activo'=>true,'ramo_id'=>$ramo_id])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
         
        return $data ;    
    }

    public static function getActivoCursosComboDependiente($empresa_id)
    {

        $sql  = Curso::find()->where(['colegio_id'=>$empresa_id, 'activo'=> true])->select(['id','nombre as name'])->asArray()->all() ;

        return $sql ;

    }

    public static function getActivoCursosComboDependienteNivel($nivel)
    {

        $sql  = Curso::find()->where(['colegio_id'=>Yii::$app->user->identity->colegio_predeterminada, 'nivel_id'=>$nivel, 'activo'=> true])->select(['id','nombre as name'])->asArray()->all() ;

        return $sql ;

    }

    public static function getCursosColegioCombo()
    {

        $data =  ArrayHelper::map(Curso::find()->where(['activo'=>true,'colegio_id'=>Yii::$app->user->identity->colegio_predeterminada,'anio_id'=>Yii::$app->user->identity->anio_predeterminado])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
         

        return $data ;

    }

    /* Realizamos la busqueda en la base de datos de los subRamos  */
    public static function getCursosColegio($id_colegio)
    {

        return Curso::find()
        
        ->where(['colegio_id' => $id_colegio,'activo' => 1,'anio_id' => Yii::$app->user->identity->anio_predeterminado])->all();

    }

    public static function getBuscarCurso($Letra,$Nivel,$nombre,$id_colegio,$anio_id)
    {

        return Curso::find()
        
        ->where(['colegio_id' => $id_colegio,'activo' => 1,'anio_id' => $anio_id,'letra_id' => $Letra,'nivel_id' => $Nivel])->One();

    }

}
