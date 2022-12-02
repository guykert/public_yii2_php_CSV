<?php

namespace common\models;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "malla_horaria_curso".
 *
 * @property integer $id
 * @property integer $dia_id
 * @property string $hora_desde
 * @property string $hora_hasta
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $estado
 * @property integer $malla_horaria_colegio_id
 * @property integer $asignatura_id
 * @property integer $curso_id
 * @property integer $bloque_id
 */

class MallaHorariaCurso extends \yii\db\ActiveRecord
{

    public $usar_bloques;

    public $horarios_anteriores;

    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'malla_horaria_curso';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['dia_id', 'hora_desde', 'hora_hasta', 'creado_por', 'curso_id'], 'required'],
            [['dia_id', 'creado_por', 'modificado_por', 'estado', 'malla_horaria_colegio_id', 'asignatura_id', 'curso_id', 'bloque_id'], 'integer'],
            [['hora_desde', 'hora_hasta', 'fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['activo'], 'boolean']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'dia_id' => 'Dia ID',
            'hora_desde' => 'Hora Desde',
            'hora_hasta' => 'Hora Hasta',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'estado' => 'Estado',
            'malla_horaria_colegio_id' => 'Malla Horaria Colegio ID',
            'asignatura_id' => 'Asignatura ID',
            'curso_id' => 'Curso ID',
            'bloque_id' => 'Bloque ID',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getHorariosAnterioresCombo()
    {

        // busco los horarios creados apra este curso

        // $MallaHorariaCurso = MallaHorariaCurso::find()
        // ->select(['malla_horaria_curso.id','malla_horaria_curso.dia_id', 'malla_horaria_curso.hora_desde', 'malla_horaria_curso.hora_hasta', 'malla_horaria_curso.asignatura_id', 'malla_horaria_curso.curso_id', 'sub_ramo.nombre as nombre_sub_ramo'])
        // ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id =malla_horaria_curso.asignatura_id and curso_asignatura.activo = 1')
        // ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        // ->where(['malla_horaria_curso.activo'=>true])
        // ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        // ->asArray()
        // ->all();

        $MallaHorariaCurso = MallaHorariaCurso::find()
        ->select(['malla_horaria_curso.id','malla_horaria_curso.hora_desde','malla_horaria_curso.hora_hasta','concat(COALESCE(malla_horaria_curso.hora_desde,"")," - ",COALESCE(malla_horaria_curso.hora_hasta,"")) as nombre'])
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true])
        ->orderBy(['malla_horaria_curso.hora_desde'=>SORT_ASC])
        ->groupBy(['malla_horaria_curso.hora_desde'])
        ->asArray()
        ->all();



        foreach ($MallaHorariaCurso as $key => &$value) {

  
            
            $value['nombre'] = date('H:i', strtotime($value["hora_desde"])) . " - " . date('H:i', strtotime($value["hora_hasta"]));
            
        }



        $datas =  ArrayHelper::map($MallaHorariaCurso
            , 'id', 'nombre') ;


        return $datas;    
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getAsignaturasCurso($curso_id)
    {



        $MallaHorariaCurso = MallaHorariaCurso::find()
        ->select(['malla_horaria_curso.id'])
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_curso.curso_id'=>$curso_id,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado])
        ->asArray()
        ->all();




        return $MallaHorariaCurso;    
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public static function getAsignaturasCursoComboDependiente($curso_id)
    {



        $MallaHorariaCurso = MallaHorariaCurso::find()
        ->select(['sub_ramo.id as id','sub_ramo.nombre as name'])
        ->join('INNER JOIN', 'curso','malla_horaria_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'sub_ramo','malla_horaria_curso.asignatura_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->where(['malla_horaria_curso.activo'=>true,'malla_horaria_curso.curso_id'=>$curso_id])
        ->asArray()
        ->all();




        return $MallaHorariaCurso;    
    }

}
