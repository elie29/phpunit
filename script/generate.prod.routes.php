<?php

/**
 * PHP SCRIPT to be run with: composer generate:routes
 *
 * AppMerge uses index.pipes.php and all routes files
 * to generate index.pipes-prod.php automatically.
 *
 * So all *.routes.php won't be used in production
 * and cache must be enabled.
 */
class AppMerge
{

    private $routes = [];
    private $modules = [];
    private $module = '';

    public function pipeDispatchMiddleware()
    {}

    public function pipeRoutingMiddleware()
    {}

    public function pipe($path, $middleware = null)
    {
        if (null !== $middleware) {
            $this->modules[] = $path;
        }
    }

    public function setModule($module)
    {
        $this->module = $module;
    }

    public function get($path, $middleware, $id)
    {
        $this->routes[] = [
            'get',
            $this->module . $path,
            $middleware,
            $id
        ];
    }

    public function post($path, $middleware, $id)
    {
        $this->routes[] = [
            'post',
            $this->module . $path,
            $middleware,
            $id
        ];
    }

    public function getModules()
    {
        return $this->modules;
    }

    public function getRoutesApp()
    {
        $res = '';
        foreach ($this->routes as $route) {
            $route[] = "\n";
            $res .= vsprintf ('$app->%s(\'%s\', \'%s\', \'%s\');%s', $route);
        }
        return $res;
    }
}

$app = new AppMerge();

// Fill in modules based on index.pipes.php
require 'config/index.pipes.php';

foreach ($app->getModules() as $module) {
    $app->setModule($module);
    require "config$module.routes.php";
}

$template = <<<'DEB'
<?php

// Generated file: %s

use Common\Middleware\AuthenticationMiddleware;
use Common\Middleware\AuthorisationMiddleware;
use Common\Middleware\RouteNotFoundMiddleware;
use Common\Middleware\SessionMiddleware;
use Middlewares\Whoops;
use Zend\Expressive\Helper\BodyParams\BodyParamsMiddleware;

/* @var $app \Zend\Expressive\Application */
$app->pipeRoutingMiddleware();
$app->pipe(Whoops::class);

$app->pipe(SessionMiddleware::class);
$app->pipe(AuthenticationMiddleware::class);
$app->pipe(AuthorisationMiddleware::class);
$app->pipe(BodyParamsMiddleware::class);

%s
$app->pipeDispatchMiddleware();
$app->pipe(RouteNotFoundMiddleware::class);

DEB;

$data = sprintf($template, date('Y-m-d H:i:s'), $app->getRoutesApp());
file_put_contents('config/index.pipes-prod.php', $data);
