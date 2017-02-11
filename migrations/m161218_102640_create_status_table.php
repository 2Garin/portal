<?php

use yii\db\Migration;

/**
 * Handles the creation of table `status`.
 */
class m161218_102640_create_status_table extends Migration
{
    const STATUS = '{{%status}}';

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

        $this->createTable(self::STATUS, [
            'status_id' => $this->primaryKey()->unsigned(),
            'user_id'   => $this->integer()->unsigned()->notNull(),
            'date'      => $this->dateTime()->defaultValue(null),
            'status'    => $this->boolean()->defaultValue(0),
        ], $tableOptions);

        $this->addColumn(self::STATUS, 'response', "json DEFAULT NULL");

        $this->createIndex('uk_status_user_id_date', self::STATUS, ['user_id', 'date'], true);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::STATUS);
    }
}
