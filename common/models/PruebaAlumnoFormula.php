<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "prueba_alumno_formula".
 *
 * @property integer $id
 * @property integer $prueba_alumno_id
 * @property string $formulas_datos
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 * @property boolean $activo
 */

class PruebaAlumnoFormula extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'prueba_alumno_formula';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['prueba_alumno_id', 'creado_por', 'modificado_por'], 'integer'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['activo'], 'boolean'],
            [['formulas_datos'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'prueba_alumno_id' => 'Prueba Alumno ID',
            'formulas_datos' => 'Formulas Datos',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
            'activo' => 'Activo',
        ];
    }

    /* función que retorna en un arreglo los registros del modelo campo id y nombre */
    public function guardarFormulas($rut,$pruebaAlmuno_id,$usuario_id)
    {



        $PruebaAlumnoFormula = new PruebaAlumnoFormula();
        $PruebaAlumnoFormula->fecha_creacion = date("Y-m-d H:i:s");
        $PruebaAlumnoFormula->creado_por = $usuario_id;
        $PruebaAlumnoFormula->formulas_datos = $rut;
        $PruebaAlumnoFormula->prueba_alumno_id = $pruebaAlmuno_id;
        $PruebaAlumnoFormula->save();




        // foreach ($formulas as $key => $formula) {
        //     $PruebaAlumnoFormula = new PruebaAlumnoFormula();
        //     $PruebaAlumnoFormula->fecha_creacion = date("Y-m-d H:i:s");
        //     $PruebaAlumnoFormula->creado_por = $usuario_id;
        //     $PruebaAlumnoFormula->formulas_datos = $rut;
        //     $PruebaAlumnoFormula->prueba_alumno_id = $pruebaAlmuno_id;
        //     $PruebaAlumnoFormula->save();

        // }

    }


}
