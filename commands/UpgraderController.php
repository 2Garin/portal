<?php

namespace app\commands;

use yii\console\Controller;
use app\components\Vk;
use app\models\Status;
use app\models\Info;
use yii\helpers\VarDumper;

class UpgraderController extends Controller
{
    public function actionIndex()
    {
        $user_ids = (new \yii\db\Query())
            ->select(new \yii\db\Expression("GROUP_CONCAT(DISTINCT user_id) as user_ids"))
            ->from(Info::tableName())
            ->scalar();

        $v = new Vk();
        $s = $v->api('users.get',
            [
                'user_ids'  => $user_ids,
                'fields'    => 'online,status,photo,photo_medium,photo_big,nickname,screen_name,counters,relation,last_seen,activity',
                'name_case' => 'Nom',
            ]);

        if (is_array($s)) {
            foreach ($s as $row) {
                $status = new Status();
                $status->user_id = $row['id'];
                $status->date = new \yii\db\Expression('NOW()');
                $status->status = $row['online'];
                $status->response = json_encode($row);
                $status->save();
            }
            unset($row);
        } else {
            \Yii::warning('VK response is not array ' . VarDumper::dumpAsString($s));
        }
    }
}
