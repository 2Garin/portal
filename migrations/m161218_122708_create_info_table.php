<?php

use yii\db\Migration;

/**
 * Handles the creation of table `period`.
 */
class m161218_122708_create_info_table extends Migration
{
    const INFO = '{{%info}}';
    const STATUS = '{{%status}}';
    const PERIOD = '{{%period}}';

    const FK_STATUS = 'fk_status_user_id';
    const FK_PERIOD = 'fk_period_user_id';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable(self::INFO, [
            'user_id' => $this->primaryKey()->unsigned(),
            'name'    => $this->string()->notNull(),
            'color'   => $this->string(),
        ], $tableOptions);

        $this->addForeignKey(self::FK_STATUS, self::STATUS, 'user_id', self::INFO, 'user_id', 'CASCADE', 'CASCADE');
        $this->addForeignKey(self::FK_PERIOD, self::PERIOD, 'user_id', self::INFO, 'user_id', 'CASCADE', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropForeignKey(self::FK_STATUS, self::STATUS);
        $this->dropForeignKey(self::FK_PERIOD, self::PERIOD);

        $this->dropTable(self::INFO);
    }
}
