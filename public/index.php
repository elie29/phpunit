<?php

define('BE_PATH', dirname(__DIR__));
define('DEV_MODE', true);

// Point to the backend folder
chdir(BE_PATH);

require 'vendor/autoload.php';

dump('Hello world');