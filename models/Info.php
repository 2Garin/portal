<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%info}}".
 *
 * @property integer $user_id
 * @property string $name
 * @property string $color
 *
 * @property Period[] $periods
 * @property Status[] $statuses
 */
class Info extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name', 'color'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'name'    => 'Name',
            'color'   => 'Color',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPeriods()
    {
        return $this->hasMany(Period::className(), ['user_id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatuses()
    {
        return $this->hasMany(Status::className(), ['user_id' => 'user_id']);
    }


    public function getUsersInfo()
    {
        $users = [];

        foreach (self::find()->all() as $key => $item) {
            /** @var Info $item */

            $users[$item->user_id] = [
                'color' => $item->color,
                'name'  => $item->name,
            ];
        }
        unset($item);

        return $users;
    }
}
