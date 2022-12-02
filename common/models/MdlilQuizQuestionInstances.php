<?php

namespace common\models;
use common\models\MdlQuestion;
use common\models\MdlQuestion35;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "mdl_quiz_question_instances".
 *
 * @property integer $id
 * @property integer $quiz
 * @property integer $question
 * @property integer $grade
 * @property integer $numero_pregunta
 * @property integer $mencion
 */

class MdlilQuizQuestionInstances extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdlil_quiz_question_instances';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['quiz', 'question', 'grade', 'numero_pregunta', 'mencion'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'quiz' => 'Quiz',
            'question' => 'Question',
            'grade' => 'Grade',
            'numero_pregunta' => 'Numero Pregunta',
            'mencion' => 'Mencion',
        ];
    }

    /*genera la relación entre la instancia y lapregunta */
    public function getPregunta ()
    {

        return $this->hasOne(MdlilQuestion::className(),['id'=>'question']);

    }

    /*genera la relación entre la instancia y lapregunta */
    public function getPreguntaNiveles ()
    {

        return $this->hasOne(MdlilQuestion::className(),['id'=>'question']);
        
    }

}
