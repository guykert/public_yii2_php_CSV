<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "ramo".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $orden
 * @property string $codigo
 * @property integer $division_menciones
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class Ramo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ramo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'creado_por'], 'required'],
            [['orden', 'division_menciones', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['nombre'], 'string', 'max' => 60],
            [['descripcion'], 'string', 'max' => 300],
            [['codigo'], 'string', 'max' => 5]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'orden' => 'Orden',
            'codigo' => 'Codigo',
            'division_menciones' => 'Division Menciones',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCargados($RamoPrinicipal,$RamoHijo)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = RamoHijo::find()->where(['padre_id' => $RamoPrinicipal,'hijo_id' => $RamoHijo,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCargadosEmpresa($Empresa,$Ramo)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = RamoHijo::find()->where(['padre_id' => $Ramo,'hijo_id' => $Empresa,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* Eliminamos este subRol al rol principal  */
    public static function eliminarHijo($padreid,$hijoid)
    {

        $EmpresaHijo = RamoHijo::find()->where(['padre_id' => $padreid,'hijo_id' => $hijoid,'activo' => 1])->one();

        $EmpresaHijo->activo = 0;
        
        $EmpresaHijo->save();
        
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getRamo()
    {
        $ramo =  ArrayHelper::map(Ramo::find()->where(['activo'=>true])->orderBy('orden')->all(), 'id', 'nombre') ;
         
        return $ramo ;    
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getRamoColegio()
    {

        $ramo =  ArrayHelper::map(Ramo::find()
        
        ->where(['ramo.activo'=>true,'ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->select(['ramo.id as id', 'ramo.nombre as nombre'])
        ->join('INNER JOIN','ramo_hijo','ramo_hijo.padre_id =ramo.id')
        ->orderBy('ramo.orden')->all(), 'id', 'nombre') ;
            
        return $ramo ;     
    }

    public static function getRamosSubRamosObj()
    {
        $ramo =  Ramo::find()->where(['ramo.activo'=>true,'sub_ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada,'ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada])
                    ->select(['ramo.id as id_ramo', 'ramo.nombre as ramo_nombre','sub_ramo.id as id_sub_ramo', 'sub_ramo.nombre as sub_ramo_nombre'])
                    ->join('inner JOIN','ramo_hijo','ramo_hijo.padre_id =ramo.id and ramo_hijo.activo = 1')
                    ->join('left outer JOIN','sub_ramo','sub_ramo.ramo_id =ramo.id and sub_ramo.activo = 1')
                    ->join('inner JOIN','sub_ramo_hijo','sub_ramo_hijo.padre_id =sub_ramo.id and sub_ramo_hijo.activo = 1')
                    ->asArray()
                    ->all();
         
        return $ramo ;    
    }

    
    public static function getRamosObj()
    {
        $ramo =  Ramo::find()->where(['activo'=>true])->all();
         
        return $ramo ;    
    }

    /* asignamos este subRol al rol principal  */
    public static function asignarHijo($hijoid,$hijoname,$padreid,$padrename)
    {

        $EmpresaHijo = new RamoHijo();

        $EmpresaHijo->padre_id = $padreid;
        $EmpresaHijo->nombre_padre = $padrename;
        $EmpresaHijo->hijo_id = $hijoid;
        $EmpresaHijo->nombre_hijo = $hijoname;
        $EmpresaHijo->activo = 1;
        $EmpresaHijo->creado_por = Yii::$app->user->identity->id;
        $EmpresaHijo->fecha_creacion = date("Y-m-d H:i:s");
        $EmpresaHijo->save();



    }



    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getRamoCombo()
    {
        $data =  ArrayHelper::map(Ramo::find()
        
        ->where(['ramo.activo'=>true,'ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->select(['ramo.id as id', 'ramo.nombre as nombre'])
        ->join('INNER JOIN','ramo_hijo','ramo_hijo.padre_id =ramo.id')
        ->orderBy('ramo.orden')->all(), 'id', 'nombre') ;
         
        return $data ;    

    }



}
