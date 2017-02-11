<?php

return [
    'class'        => 'jumper423\VK',
    'clientId'     => '11111',
    'clientSecret' => 'n9wsv98svSD867SA7dsda87',
    'delay'        => 0.7, // Минимальная задержка между запросами
    'delayExecute' => 120, // Задержка между группами инструкций в очереди
    'limitExecute' => 1, // Количество инструкций на одно выполнении в очереди
    'captcha'      => 'captcha', // Компонент по распознованию капчи
];
