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
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::PERIOD, [
            'period_id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->string()->notNull(),
            'period_start' => $this->dateTime()->defaultValue(null),
            'period_end' => $this->dateTime()->defaultValue(null),
        ], $tableOptions);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::PERIOD);
    }
}
