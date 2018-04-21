<?php

define('BE_PATH', dirname(__DIR__));
define('DEV_MODE', true);

// Point to the backend folder
chdir(BE_PATH);

require 'vendor/autoload.php';

use DI\ContainerBuilder;
use Doctrine\DBAL\Logging\SQLLogger;
use Zend\Expressive\Application;

// Keep the global namespace clean
call_user_func(function() {

    $defintion = require 'config/container.php';

    // 1. Create container with PHP-DI that uses autowiring technique
    $builder = new ContainerBuilder();
    $builder->addDefinitions($defintion);
    if (!DEV_MODE) {
        $builder->enableCompilation(BE_PATH . '/cache');
        // $builder->enableDefinitionCache();
    }
    $container = $builder->build();

    // 2. Create a new application with DI
    $app = $container->make(Application::class);

    // 3. Include global and modules middlewares
    require sprintf('config/index.pipes%s.php', DEV_MODE ? '': '-prod');

    // 4. Run the application
    $app->run();

    if (DEV_MODE) {
        $container->get(SQLLogger::class)->flush();
    }
});
