<?php

use yii\db\Migration;

/**
 * Handles the creation of table `period`.
 */
class m161218_102708_create_period_table extends Migration
{
    const PERIOD = '{{%period}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::PERIOD, [
            'period_id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->string()->notNull(),
            'period_start' => $this->dateTime()->defaultValue(null),
            'period_end' => $this->dateTime()->defaultValue(null),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::PERIOD);
    }
}
