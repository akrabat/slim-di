<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \App\Slim(
    [
        'mode' => 'development',
    ]
);

$app->get('/', 'App\Controller\Home:index');
$app->get('/hello/:name', 'App\Controller\Home:hello');

$app->run();
