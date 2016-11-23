<?php

namespace app\controllers;

use Yii;
use app\models\Status;
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
            'users' => (new Status)->getUsersInfo(),
        ]);
    }

    public function actionJsonCalendar($start = null, $end = null, $_ = null, array $users = null)
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $usersInfo = (new Status)->getUsersInfo();

        $journal = [];
        foreach (Status::find()
                     ->where(['between', 'date', $start, $end])
                     ->andWhere($users ? ['user_id' => $users] : [])
                     ->all() as $row) {
            /** @var Status $row */
            $journal[] = [
                'date' => $row->date,
                'user_id' => $row->user_id,
            ];
        }
        unset($row);

        $eventId = 0;
        $events = array();
//        foreach ($journal as $item) {
//            $Event = new cEvent();
//            $Event->id = ++$eventId;
//            $Event->title = 'title';
//            $Event->description = 'description';
//
//            $Event->start = date('Y-m-d\TH:i:s\Z');
//            $Event->end = date('Y-m-d\TH:i:s\Z');
//
//            $Event->color = 'color';
//
//            $events[] = $Event;
//        }
//        unset($item);

        $Event = new cEvent();
        $Event->id = 1;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:i:s\Z');
        $events[] = $Event;

        $Event = new cEvent();
        $Event->id = 2;
        $Event->title = 'Testing';
        $Event->start = date('Y-m-d\TH:i:s\Z',strtotime('tomorrow 6am'));
        $events[] = $Event;

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
