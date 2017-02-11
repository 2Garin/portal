<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "status".
 *
 * @property integer $status_id
 * @property string $user_id
 * @property string $date
 * @property integer $status
 * @property string $response
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
            [['date'], 'safe'],
            [['status'], 'integer'],
            [['response'], 'string'],
            [['user_id'], 'string', 'max' => 255],
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
}
