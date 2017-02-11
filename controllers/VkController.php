<?php

namespace app\controllers;

use Yii;
use app\models\Status;
use app\models\Period;
use app\models\Info;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii2fullcalendar\models\Event as cEvent;

/**
 * VkController implements the CRUD actions for Status model.
 */
class VkController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
            'users' => (new Info)->getUsersInfo(),
        ]);
    }

    public function actionJsonCalendar($start = null, $end = null, $_ = null, array $users = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $usersInfo = (new Info)->getUsersInfo();

        $query = Period::find()
            ->where([
                'or',
                ['between', 'period_start', $start, $end],
                ['between', 'period_end', $start, $end],
            ]);

        if (!empty($users)) {
            $query->andWhere(['user_id' => $users]);
        }

        $journal = $query->all();

        $eventId = 0;
        $events = array();
        foreach ($journal as $item) {
            /* @var Period $item */
            $Event = new cEvent();
            $Event->id = ++$eventId;
//            $Event->title = $item->user_id;
            $Event->description = 'description';

            $Event->start = $item->period_start;
            $Event->end = $item->period_end;

            $Event->color = $usersInfo[$item->user_id]['color'];

            $events[] = $Event;
        }
        unset($item);

        return $events;
    }

    /**
     * Lists all Status models.
     * @return mixed
     */
    public function actionLog()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Status::find(),
        ]);

        return $this->render('log', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Finds the Status model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Status the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Status::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
