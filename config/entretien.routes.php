<?php

use Entretien\Middleware\Categorie\CategoriesAction;

/* @var $app \Zend\Expressive\Application */

// Register the routing middleware in the middleware pipeline
$app->pipeRoutingMiddleware();

// Route action -> One class per action & per type
$app->get('/categories', CategoriesAction::class, 'categories');

// Sometimes 2 types are needed for the same action
// $app.route(path, class, [...types], name)

// At this point, dispatch the resolved route if found
$app->pipeDispatchMiddleware();