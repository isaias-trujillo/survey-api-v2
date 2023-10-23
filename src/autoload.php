<?php

function my_custom_autoloader($class_name)
{
    $file = __DIR__ . DIRECTORY_SEPARATOR . $class_name . '.php';
    $fixed_file = str_replace("\\", DIRECTORY_SEPARATOR, $file);

    if (!file_exists($fixed_file)) {
        throw new Error("File $fixed_file not found");
    }
    require_once $file;
}

// add a new autoloader by passing a callable into spl_autoload_register()
spl_autoload_register('my_custom_autoloader');
