<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $status_id
 * @property integer $user_id
 * @property string $date
 * @property integer $status
 * @property string $response
 *
 * @property Info $user
 */
class Status extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status'], 'integer'],
            [['date'], 'safe'],
            [['response'], 'string'],
            [
                ['user_id', 'date'],
                'unique',
                'targetAttribute' => ['user_id', 'date'],
                'message'         => 'The combination of User ID and Date has already been taken.',
            ],
            [
                ['user_id'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => Info::className(),
                'targetAttribute' => ['user_id' => 'user_id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'status_id' => 'Status ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'status' => 'Status',
            'response' => 'Response',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Info::className(), ['user_id' => 'user_id']);
    }
}
