<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "curso_asignatura".
 *
 * @property integer $id
 * @property integer $curso_id
 * @property integer $sub_ramo_id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class CursoAsignatura extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'curso_asignatura';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['creado_por'], 'required'],
            [['id', 'curso_id', 'sub_ramo_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'curso_id' => 'Curso ID',
            'sub_ramo_id' => 'Sub Ramo ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getCursosMenuProfesor()
    {

        // $UsuarioCurso = UsuarioCurso::find()
        // //->select(['sub_ramo.nombre','ramo.codigo','curso_asignatura.id'])
        // ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1]) 
        // //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        // // ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        // //->orderBy(['sub_ramo.nombre'=>SORT_ASC])
        // // ->orWhere(['email2' => $model->email]) 
        // ->asArray()
        // ->all();

        // var_dump($UsuarioCurso);
        // exit;

        $CursoAsignatura = CursoAsignatura::find()
        ->select(['sub_ramo.nombre','ramo.codigo','curso_asignatura.id','curso_asignatura.curso_id'])
        ->where(['curso_asignatura.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado,'curso.colegio_id'=>Yii::$app->user->identity->colegio_predeterminada]) 
        //->where(['curso_asignatura.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        ->orderBy(['sub_ramo.nombre'=>SORT_ASC])
        ->groupBy(['curso_asignatura.sub_ramo_id'])
        // ->orWhere(['email2' => $model->email]) 
        ->asArray()
        ->all();
        


        return $CursoAsignatura;



        
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getAsignaturasCursoCombo($curso)
    {



        $data =  ArrayHelper::map(CursoAsignatura::find()
                                ->select(['curso_asignatura.id as id','sub_ramo.nombre as nombre'])
                                ->where(['curso_asignatura.curso_id' => $curso,'curso_asignatura.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado,'curso.colegio_id'=>Yii::$app->user->identity->colegio_predeterminada]) 
                                //->where(['curso_asignatura.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
                                //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
                                // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
                                ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
                                ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
                                ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
                                // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
                                ->orderBy(['sub_ramo.nombre'=>SORT_ASC])
                                ->groupBy(['curso_asignatura.sub_ramo_id'])
                                ->asArray()
                                ->all()
                                , 'id', 'nombre') ;
         
        return $data ;    
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getAsignaturaPorCurso($curso_id)
    {

        // $UsuarioCurso = UsuarioCurso::find()
        // //->select(['sub_ramo.nombre','ramo.codigo','curso_asignatura.id'])
        // ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1]) 
        // //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        // // ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        // //->orderBy(['sub_ramo.nombre'=>SORT_ASC])
        // // ->orWhere(['email2' => $model->email]) 
        // ->asArray()
        // ->all();



        $CursoAsignatura = CursoAsignatura::find()
        ->select(['curso_asignatura.id as id','sub_ramo.nombre as name'])
        ->where(['curso_asignatura.curso_id' => $curso_id,'curso_asignatura.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado,'curso.colegio_id'=>Yii::$app->user->identity->colegio_predeterminada]) 
        //->where(['curso_asignatura.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.curso_id = curso.id and malla_horaria_curso.asignatura_id = curso_asignatura.id and malla_horaria_curso.activo = 1 ')
        // // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        ->orderBy(['sub_ramo.nombre'=>SORT_ASC])
        ->groupBy(['curso_asignatura.sub_ramo_id'])
        // ->orWhere(['email2' => $model->email]) 
        ->asArray()
        ->all();


        


        return $CursoAsignatura;



        
    }

}
