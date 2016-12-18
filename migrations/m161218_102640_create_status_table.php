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
        $this->createTable(self::STATUS, [
            'status_id' => $this->primaryKey()->unsigned(),
            'user_id' => $this->string()->notNull(),
            'date' => $this->dateTime()->defaultValue(null),
            'status' => $this->boolean()->defaultValue(0),
            'response' => $this->text(),
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

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
