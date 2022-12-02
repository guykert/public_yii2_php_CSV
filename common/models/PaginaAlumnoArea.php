<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "pagina_alumno_area".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $descripcion
 * @property integer $pagina_alumno_id
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property integer $creado_por
 * @property string $fecha_modificacion
 * @property integer $modificado_por
 */

class PaginaAlumnoArea extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pagina_alumno_area';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pagina_alumno_id', 'creado_por', 'modificado_por'], 'integer'],
            [['activo'], 'boolean'],
            [['fecha_creacion', 'fecha_modificacion'], 'safe'],
            [['creado_por'], 'required'],
            [['nombre'], 'string', 'max' => 150],
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
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'pagina_alumno_id' => 'Pagina Alumno',
            'activo' => 'Activo',
            'fecha_creacion' => 'Fecha Creacion',
            'creado_por' => 'Creado Por',
            'fecha_modificacion' => 'Fecha Modificacion',
            'modificado_por' => 'Modificado Por',
        ];
    }

    /* entrega los datos para el id relacionado con la tabla ramo  */
    public function getPaginaAlumno()
    {
        return $this->hasOne(PaginaAlumno::className(),['id'=>'pagina_alumno_id']);
    }

    public static function getPaginaAlumnoArea($id_pagina_alumno)
    {

        $sql  = PaginaAlumnoArea::find()
        ->where(['pagina_alumno_id'=>$id_pagina_alumno, 'activo'=> true])
        ->select(['id','nombre as name'])->asArray()->all() ;

        return $sql ;

    }

}
