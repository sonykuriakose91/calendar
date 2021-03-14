<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "meetings".
 *
 * @property int $id
 * @property string $title
 * @property int $date
 * @property int $start_time
 * @property int $duration
 * @property int $created_by
 * @property int $created_at
 */
class Meetings extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'meetings';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'date', 'start_time', 'duration'], 'required'],
            [['duration', 'created_by', 'created_at'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['start_time', 'date', 'start_date','end_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'date' => 'Date',
            'start_time' => 'Start Time',
            'duration' => 'Duration',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }

    public function getCreatedBy()
    {
        return $this->hasOne('common\models\User', ['id' => 'created_by']);
    }

    public function getAttendees()
    {
        return $this->hasMany(Attendees::className(), ['meeting_id' => 'id']);
    }
}
