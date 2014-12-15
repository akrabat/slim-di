<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \RkaSc\Slim(
    [
        'mode' => 'development',
    ]
);

// Optionally register a controller with the container
$app->container->singleton('App\Home', function ($container) {
    // Retrieve any required dependencies from the container and
    // inject into the constructor of the controller
    return new \App\Controller\Home();
});

// Set up routes
$app->get('/', 'App\Home:index');
$app->get('/hello/:name', 'App\Controller\Home:hello');

$app->run();
