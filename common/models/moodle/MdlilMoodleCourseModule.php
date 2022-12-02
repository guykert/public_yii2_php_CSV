<?php

namespace common\models\moodle;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "carrera".
 *
 * @property string $id
 * @property string $nombre
 * @property string $descripcion
 * @property boolean $activo
 * @property string $fecha_creacion
 * @property string $creado_por
 * @property string $fecha_modificacion
 * @property string $modificado_por
 */

class MdlilMoodleCourseModule extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdlil_course_modules';
    }

    public static function getDb()
    {

        return Yii::$app->get('dbmoodle');

    }

}
