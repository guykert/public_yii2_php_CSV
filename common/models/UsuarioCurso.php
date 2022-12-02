<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "usuario_curso".
 *
 * @property integer $id
 * @property integer $usuario_id
 * @property integer $curso_id
 * @property integer $rol_id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class UsuarioCurso extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'usuario_curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['usuario_id', 'curso_id'], 'required'],
            [['usuario_id', 'curso_id', 'rol_id', 'creado_por', 'modificado_por'], 'integer'],
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
            'usuario_id' => 'Usuario ID',
            'curso_id' => 'Curso ID',
            'rol_id' => 'Rol ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCargados($curso_id,$usuario_id)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = UsuarioCurso::find()->where(['curso_id' => $curso_id,'usuario_id' => $usuario_id,'activo' => 1])->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getConfirnarCurso($curso_id,$usuario_id)
    {

        // consulto si este subRol ya está asignado al rol principal

        $data = UsuarioCurso::find()
        ->where(['usuario_curso.curso_id' => $curso_id,'usuario_curso.usuario_id' => $usuario_id,'usuario_curso.activo' => 1])
        ->count();

        if($data > 0){
            return true;
        }else{
            return false;
        }
        
    }

    
    /* consulto si esta Empresa ya está asignado a la empresa principal principal  */
    public static function getCursosMenu()
    {




        $UsuarioCurso = UsuarioCurso::find()
        ->select(['sub_ramo.nombre','ramo.codigo','curso_asignatura.id'])
        ->where(['usuario_curso.usuario_id' => Yii::$app->user->identity->id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        ->orderBy(['sub_ramo.nombre'=>SORT_ASC])
        // ->orWhere(['email2' => $model->email]) 
        ->asArray()
        ->all();

        return $UsuarioCurso;



        
    }


}
