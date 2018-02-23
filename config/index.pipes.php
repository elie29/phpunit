<?php

use Common\Middleware\AuthenticationMiddleware;
use Common\Middleware\AuthorisationMiddleware;
use Common\Middleware\RouteNotFoundMiddleware;
use Common\Middleware\SessionMiddleware;
use Entretien\Middleware\EntretienMiddleware;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;
use Outils\Middleware\OutilsMiddleware;
use Middlewares\Whoops;

/* @var $app \Zend\Expressive\Application */

// Register the routing middleware in the middleware pipeline
$app->pipeRoutingMiddleware();

// Middleware for handling exceptions of all routes -> cf. container.php
$app->pipe(Whoops::class);

$app->pipe(SessionMiddleware::class);
$app->pipe(AuthenticationMiddleware::class);
$app->pipe(AuthorisationMiddleware::class);
$app->pipe(BodyParamsMiddleware::class); // JSON parse

// Add modules middleware here...
$app->pipe('/entretien', EntretienMiddleware::class);
$app->pipe('/outils', OutilsMiddleware::class);

// At this point, dispatch the resolved route if found
$app->pipeDispatchMiddleware();

// Call this middleware if no route resolved: Keep it at the end !!!
$app->pipe(RouteNotFoundMiddleware::class);
