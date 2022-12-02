<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "malla_horaria_profesor".
 *
 * @property integer $id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property integer $estado
 * @property integer $asignatura_id
 * @property integer $curso_id
 * @property integer $profesor_id
 */

class MallaHorariaProfesor extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'malla_horaria_profesor';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por', 'curso_id', 'profesor_id'], 'required'],
            [['creado_por', 'modificado_por', 'estado', 'asignatura_id', 'curso_id', 'profesor_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'estado' => 'Estado',
            'asignatura_id' => 'Asignatura ID',
            'curso_id' => 'Curso ID',
            'profesor_id' => 'Profesor ID',
        ];
    }
}
