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

    public function getUsersInfo(){
        $users = [];
        $colors = ['#5d788c', '#895d8c', '#618c5d', '#8c715d', '#5d688c', '#8c5d61', '#8c895d', '#467ba3', '#5d8c89'];

        foreach (static::find()->select('user_id')->distinct()->orderBy('user_id desc')->all() as $key => $item) {
            /** @var Status $item */

            $users[$item->user_id] = [
                'color' => array_key_exists($key, $colors) ? $colors[$key] : '#000000',
            ];
        }
        unset($item);

        return $users;
    }
}
