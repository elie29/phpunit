<?php

use Outils\Middleware\Ping\PingAction;
use Outils\Middleware\Sum\SumAction;
use Outils\Middleware\Uppercase\UppercaseAction;

/* @var \Zend\Expressive\Application $app */
$app->pipeDispatchMiddleware();

// One Middleware per action & per type
$app->get('/ping', PingAction::class, 'ping.route');

$app->get('/uppercase', UppercaseAction::class, 'uppercase.empty.route');
$app->get('/uppercase/{name}', UppercaseAction::class, 'uppercase.route');

$app->post('/sum', SumAction::class, 'sum.post.route');

// At the end
$app->pipeRoutingMiddleware();