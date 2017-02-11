<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%period}}".
 *
 * @property integer $period_id
 * @property string $user_id
 * @property string $period_start
 * @property string $period_end
 */
class Period extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%period}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['period_start', 'period_end'], 'safe'],
            [['user_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'period_id'    => 'Period ID',
            'user_id'      => 'User ID',
            'period_start' => 'Period Start',
            'period_end'   => 'Period End',
        ];
    }
}
