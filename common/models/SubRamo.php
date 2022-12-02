<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "sub_ramo".
 *
 * @property integer $id
 * @property integer $ramo_id
 * @property string $codigo
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $sesiones_id
 */

class SubRamo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sub_ramo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ramo_id', 'codigo', 'nombre', 'creado_por'], 'required'],
            [['ramo_id', 'creado_por', 'modificado_por', 'sesiones_id'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['codigo'], 'string', 'max' => 20],
            [['nombre'], 'string', 'max' => 100],
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
            'ramo_id' => 'Ramo ID',
            'codigo' => 'Codigo',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'sesiones_id' => 'Sesiones ID',
        ];
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getRamo()
    {
        return $this->hasOne(Ramo::className(),['id'=>'ramo_id']);
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getRamoCombo()
    {
        $data =  ArrayHelper::map(Ramo::find()->where(['activo'=>true])
                                                ->orderBy('nombre')->all(), 'id', 'nombre') ;
         
        return $data ;    
    }

    public static function getSubRamoCombo($ramo_id="")
    {

        $SubRamos = SubRamo::find()
        ->where(['sub_ramo.activo'=> true,'sub_ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->join('INNER JOIN','sub_ramo_hijo','sub_ramo_hijo.padre_id =sub_ramo.id')

        ->select(['sub_ramo.id','sub_ramo.nombre as nombre']);

        if($ramo_id!=""){
            $SubRamos->andWhere(['sub_ramo.ramo_id'=>$ramo_id]);
        }

        
        $SubRamos = $SubRamos->asArray()
        ->all();

        $data =  ArrayHelper::map($SubRamos, 'id', 'nombre') ;
         
        // $sql  = SubRamo::find()
        // ->where(['sub_ramo.ramo_id'=>$ramo_id, 'sub_ramo.activo'=> true,'sub_ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada])
        // ->join('INNER JOIN','sub_ramo_hijo','sub_ramo_hijo.padre_id =sub_ramo.id')
        // ->select(['sub_ramo.id','sub_ramo.nombre as name'])->asArray()->all() ;



        return $data ; 

    }

    public static function getSubRamosObj($Ramos)
    {
        $ramos_array = [];
        foreach ($Ramos as $key => $value) {
            $ramos_array[] = $value->id;
        }

        $subramo =  SubRamo::find()->where(['activo'=>true,'ramo_id'=>$ramos_array])->all();
         
        return $subramo ;    
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCargadosEmpresa($Empresa,$SubRamo)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = SubRamoHijo::find()->where(['padre_id' => $SubRamo,'hijo_id' => $Empresa,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCargadosAsignatura($Curso_id,$SubRamo)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = CursoAsignatura::find()->where(['curso_id' => $Curso_id,'sub_ramo_id' => $SubRamo,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* Eliminamos este subRol al rol principal  */
    public static function eliminarCursoAsignatura($Curso_id,$SubRamo)
    {

        $CursoAsignatura = CursoAsignatura::find()->where(['curso_id' => $Curso_id,'sub_ramo_id' => $SubRamo,'activo' => 1])->one();

        $CursoAsignatura->activo = 0;
        
        $CursoAsignatura->save();
        
    }

    /* asignamos este subRol al rol principal  */
    public static function asignarCursoAsignatura($Curso_id,$SubRamo)
    {

        $CursoAsignatura = new CursoAsignatura();

        $CursoAsignatura->curso_id = $Curso_id;
        $CursoAsignatura->sub_ramo_id = $SubRamo;
        $CursoAsignatura->activo = 1;
        $CursoAsignatura->creado_por = Yii::$app->user->identity->id;
        $CursoAsignatura->fecha_creacion = date("Y-m-d H:i:s");

        $CursoAsignatura->save();



    }



    /* Eliminamos este subRol al rol principal  */
    public static function eliminarHijo($padreid,$hijoid)
    {

        $EmpresaHijo = SubRamoHijo::find()->where(['padre_id' => $padreid,'hijo_id' => $hijoid,'activo' => 1])->one();

        $EmpresaHijo->activo = 0;
        
        $EmpresaHijo->save();
        
    }

    /* asignamos este subRol al rol principal  */
    public static function asignarHijo($hijoid,$hijoname,$padreid,$padrename)
    {

        $EmpresaHijo = new SubRamoHijo();

        $EmpresaHijo->padre_id = $padreid;
        $EmpresaHijo->nombre_padre = $padrename;
        $EmpresaHijo->hijo_id = $hijoid;
        $EmpresaHijo->nombre_hijo = $hijoname;
        $EmpresaHijo->activo = 1;
        $EmpresaHijo->creado_por = Yii::$app->user->identity->id;
        $EmpresaHijo->fecha_creacion = date("Y-m-d H:i:s");


        $EmpresaHijo->save();



    }



    public static function getSubRamoColegio($ramo_id)
    {

        $sql  = SubRamo::find()
        ->where(['sub_ramo.ramo_id'=>$ramo_id, 'sub_ramo.activo'=> true,'sub_ramo_hijo.hijo_id'=>Yii::$app->user->identity->colegio_predeterminada])
        ->join('INNER JOIN','sub_ramo_hijo','sub_ramo_hijo.padre_id =sub_ramo.id')
        ->select(['sub_ramo.id','sub_ramo.nombre as name'])->asArray()->all() ;

        return $sql ;

    }

}
