<?php

namespace common\models;

use Yii;

/**
 * Esta es la clase de modelo para la tabla "mdl_question_answers_35".
 *
 * @property integer $id
 * @property integer $question
 * @property string $answer
 * @property integer $answerformat
 * @property string $fraction
 * @property string $feedback
 * @property integer $feedbackformat
 * @property integer $migrado
 * @property integer $reparar_imagenes
 */

class MdlilQuestionAnswers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdlil_question_answers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['question', 'answerformat', 'feedbackformat', 'migrado', 'reparar_imagenes'], 'integer'],
            [['answer'], 'required'],
            [['answer', 'feedback'], 'string'],
            [['fraction'], 'number']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question' => 'Question',
            'answer' => 'Answer',
            'answerformat' => 'Answerformat',
            'fraction' => 'Fraction',
            'feedback' => 'Feedback',
            'feedbackformat' => 'Feedbackformat',
            'migrado' => 'Migrado',
            'reparar_imagenes' => 'Reparar Imagenes',
        ];
    }
}
