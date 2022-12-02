<?php

namespace common\models;
use common\models\MdlilQuestionAnswers;
use Yii;

/**
 * Esta es la clase de modelo para la tabla "mdl_question_35".
 *
 * @property integer $id
 * @property integer $category
 * @property integer $parent
 * @property string $name
 * @property string $questiontext
 * @property integer $questiontextformat
 * @property string $generalfeedback
 * @property integer $generalfeedbackformat
 * @property string $defaultmark
 * @property string $penalty
 * @property string $qtype
 * @property integer $length1
 * @property string $stamp
 * @property string $version1
 * @property integer $hidden
 * @property integer $timecreated
 * @property integer $timemodified
 * @property integer $createdby
 * @property integer $modifiedby
 * @property string $idnumber
 */

class MdlilQuestion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'mdlil_question';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category', 'parent', 'questiontextformat', 'generalfeedbackformat', 'length1', 'hidden', 'timecreated', 'timemodified', 'createdby', 'modifiedby'], 'integer'],
            [['questiontext'], 'required'],
            [['questiontext', 'generalfeedback'], 'string'],
            [['defaultmark', 'penalty'], 'number'],
            [['name', 'stamp', 'version1'], 'string', 'max' => 255],
            [['qtype'], 'string', 'max' => 20],
            [['idnumber'], 'string', 'max' => 100],
            // [['category', 'idnumber'], 'unique', 'targetAttribute' => ['category', 'idnumber'], 'message' => 'The combination of Category and Idnumber has already been taken.']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category' => 'Category',
            'parent' => 'Parent',
            'name' => 'Name',
            'questiontext' => 'Questiontext',
            'questiontextformat' => 'Questiontextformat',
            'generalfeedback' => 'Generalfeedback',
            'generalfeedbackformat' => 'Generalfeedbackformat',
            'defaultmark' => 'Defaultmark',
            'penalty' => 'Penalty',
            'qtype' => 'Qtype',
            'length1' => 'Length1',
            'stamp' => 'Stamp',
            'version1' => 'Version1',
            'hidden' => 'Hidden',
            'timecreated' => 'Timecreated',
            'timemodified' => 'Timemodified',
            'createdby' => 'Createdby',
            'modifiedby' => 'Modifiedby',
            'idnumber' => 'Idnumber',
        ];
    }

    public function getAlternativas()
    {
        return $this->hasMany(MdlilQuestionAnswers::className(),['question'=>'id']);
    }

}
