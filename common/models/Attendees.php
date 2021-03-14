<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meetings".
 *
 * @property int $id
 * @property int $meeting_id
 * @property int $attendee_id
 */
class Attendees extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meeting_attendees';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meeting_id', 'attendee_id'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'meeting_id' => 'Meeting',
            'attendee_id' => 'Attendee',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne('common\models\User', ['id' => 'created_by']);
    }

    public function getMeeting()
    {
        return $this->hasOne(Meetings::className(), ['id' => 'meeting_id']);
    }
}
