<?php

$path = __DIR__ . DIRECTORY_SEPARATOR . "src" . DIRECTORY_SEPARATOR . "autoload.php";
require_once $path;

use api\core\App;

Dotenv::load();
App::run();