<?php

use yii\web\JsExpression;
use yii\helpers\Url;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $users */

$this->registerJsFile('@web/js/vk/index.js');
$this->title = 'Days Activity';
$this->params['breadcrumbs'][] = $this->title;

$JSEventClick = <<<JS
function(calEvent, jsEvent, view) {
    var newView = '';
    if(view.name == 'month' || view.name == 'agendaWeek'){
        newView = 'agendaDay';
    }
    if(view.name == 'agendaDay'){
        newView = 'month';
    }

    $('.fullcalendar').fullCalendar('gotoDate', calEvent.start);
    $('.fullcalendar').fullCalendar('changeView', newView);
}
JS;
?>
<div class="row">
    <div class="col-lg-2">
        <div>
            <strong>Users</strong>
        </div>
        <div class="users">
            <?php
            foreach ($users as $userId => $user) {
                echo Html::beginTag('div', [
                    'class' => 'user_label',
                    'style' => 'background-color: ' . $user['color'],
                ]);
                echo Html::beginTag('div', ['class' => 'checkbox',]);
                echo Html::beginTag('label');
                echo Html::tag('input', '', [
                    'type'    => 'checkbox',
                    'value'   => $userId,
                    'checked' => 'checked',
                ]);
                echo $user['name'];
                echo Html::endTag('label');
                echo Html::endTag('div');
                echo Html::endTag('div');
            }
            ?>
        </div>
    </div>
    <div class="col-lg-10">
        <?php
        $calendarUrl = Url::to(['/vk/json-calendar']);
        ?>
        <?= \yii2fullcalendar\yii2fullcalendar::widget(array(
            'ajaxEvents' => $calendarUrl,
            'options' => [
                'lang' => 'ru',
            ],
            'header' => [
                'left' => 'prev,next, today',
                'center' => 'title',
                'right' => 'month,agendaWeek,agendaDay'
            ],
            'clientOptions' => [
                'eventClick' => new JsExpression($JSEventClick),
                'height' => 'auto',
                'slotLabelFormat' => 'HH:mm',
                'views' => [
                    'month' => [
                        'columnFormat' => 'ddd',
                        'titleFormat' => 'MMMM YYYY',
                        'timeFormat' => 'HH:mm',
                    ],
                    'week' => [
                        'columnFormat' => 'ddd DD.MM',
                        'titleFormat' => 'D MMM YYYY',
                    ],
                    'day' => [
                        'columnFormat' => 'dddd',
                        'titleFormat' => 'D MMM YYYY',
                    ],
                ],
            ],
        ));
        ?>
    </div>
</div>

<script>
    var PORTAL = PORTAL || {};
    PORTAL.activityUrl = '<?=$calendarUrl?>';
</script>