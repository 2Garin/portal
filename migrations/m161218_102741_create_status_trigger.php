<?php

use yii\db\Migration;

class m161218_102741_create_status_trigger extends Migration
{
    const TRIGGER_NAME = '`set_period`';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $triggerName = self::TRIGGER_NAME;
        $sql = "
            CREATE TRIGGER {$triggerName}
            AFTER INSERT ON `status`
            FOR EACH ROW
              BEGIN
                IF NEW.status = 1
                THEN
                  SET @PERIOD_ID = (SELECT period_id
                                    FROM period
                                    WHERE user_id = NEW.user_id AND period_end >= NEW.date - INTERVAL 90 SECOND
                                    ORDER BY period_id DESC
                                    LIMIT 1);
            
                  IF (ISNULL(@PERIOD_ID))
                  THEN
                    INSERT INTO period (user_id, period_start, period_end) VALUES (NEW.user_id, NEW.date, NEW.date);
                  ELSE
                    UPDATE period
                    SET period_end = (NEW.date)
                    WHERE period_id = @PERIOD_ID;
                  END IF;
                END IF;
              END;
        ";
        $this->execute($sql);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->execute("DROP TRIGGER IF EXISTS " . self::TRIGGER_NAME);
    }
}
