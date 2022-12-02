<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\UsuarioCurso;

/**
 * Login form
 */
class AlumnoCurso extends Model
{

    public static function getCursoAlumno($alumno_id)
    {

        $UsuarioCurso = UsuarioCurso::find()
        ->select(['curso.nombre','curso.id'])
        ->where(['usuario_curso.usuario_id' => $alumno_id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        ->orderBy(['curso.nombre'=>SORT_ASC])
        // ->orWhere(['email2' => $model->email]) 
        ->one();




        return $UsuarioCurso;

    }

    public static function getMallaHorariaAlumno($alumno_id)
    {

        $UsuarioCurso = UsuarioCurso::find()
        //->select(['sub_ramo.nombre','ramo.codigo','curso_asignatura.id'])
        ->where(['usuario_curso.usuario_id' => $alumno_id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
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

        // var_dump($UsuarioCurso);
        // echo "<br><br>";
        

        $UsuarioCurso = UsuarioCurso::find()
        ->select(['sub_ramo.nombre','ramo.codigo','curso_asignatura.id','malla_horaria_curso.curso_id'])
        ->where(['usuario_curso.usuario_id' => $alumno_id,'usuario_curso.activo' => 1,'curso.anio_id'=>Yii::$app->user->identity->anio_predeterminado]) 
        //->join('INNER JOIN', 'curso','usuario_curso.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'curso_asignatura','curso_asignatura.id = usuario_curso.curso_id and curso_asignatura.activo = 1 ')
        ->join('INNER JOIN', 'curso','curso_asignatura.curso_id = curso.id and curso.activo = 1 ')
        ->join('INNER JOIN', 'malla_horaria_curso','malla_horaria_curso.asignatura_id =curso_asignatura.id and malla_horaria_curso.activo = 1')
        ->join('INNER JOIN', 'sub_ramo','curso_asignatura.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1 ')
        ->join('INNER JOIN', 'ramo','sub_ramo.ramo_id = ramo.id and ramo.activo = 1 ')
        // ->join('INNER JOIN', 'sub_ramo','curso.sub_ramo_id = sub_ramo.id and sub_ramo.activo = 1')
        ->orderBy(['sub_ramo.nombre'=>SORT_ASC])
        // ->orWhere(['email2' => $model->email]) 
        ->asArray()
        ->all();



        return $UsuarioCurso;

    }

    // Estructura 2021

        public static function matricularCursos($id_usuario,$curso_id)
        {




            // primero busco las asignaturas_curso qeu tiene este curso para asignarcelas al alumno

            $UsuarioCurso = UsuarioCurso::find()
            ->where(['curso_id' => $curso_id,'usuario_id' => $id_usuario,'activo' => 1]) 
            // ->orWhere(['email2' => $model->email]) 
            ->one();

            // echo "id_usuario : " . $id_usuario . "<br>";
            // echo "curso_id : " . $curso_id . "<br>";

            // var_dump($UsuarioCurso);


            if(!$UsuarioCurso){
                $UsuarioCurso = new UsuarioCurso();
                $UsuarioCurso->creado_por = Yii::$app->user->identity->id;
                $UsuarioCurso->fecha_creacion = date("Y-m-d H:i:s");
                $UsuarioCurso->usuario_id = $id_usuario;
                $UsuarioCurso->curso_id = $curso_id;
                $UsuarioCurso->activo = 1;
                $UsuarioCurso->save();

            }


            // exit;


        }

        public static function alumnosPorCurso($curso_id,$colegio_id)
        {




            // $Alumnos = Alumno::find()
            // ->where(['usuario.activo'=>true,'curso.id'=>$curso_id,'curso.colegio_id'=> $colegio_id])
            // ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
            // ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
            // ->asArray()
            // ->all();

            // var_dump($Alumnos);
            // exit;


            $Alumnos = Alumno::find()
            ->where(['usuario.activo'=>true,'curso.id'=>$curso_id,'rol_usuario.item_name'=>'alumno','curso.colegio_id'=> $colegio_id])
            ->join('INNER JOIN', 'usuario_curso','usuario.id =usuario_curso.usuario_id and usuario.activo = 1')
            ->join('INNER JOIN', 'rol_usuario','usuario.id =rol_usuario.user_id and rol_usuario.activo = 1')
            ->join('INNER JOIN', 'curso','curso.id =usuario_curso.curso_id and curso.activo = 1')
            ->join('INNER JOIN', 'empresa','empresa.id =curso.colegio_id and empresa.activo = 1')
            ->select(['usuario.id as usuario_id','usuario.rut','usuario.nombre','usuario.apellido_paterno','usuario.apellido_materno','usuario.email'])
            ->groupBy(['usuario.id'])
            ->orderBy(['usuario.id'=>SORT_ASC])
            ->asArray()
            ->all();



            return $Alumnos;


            // exit;


        }

}
