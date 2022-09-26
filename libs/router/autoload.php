<?php

spl_autoload_register(function ($class) {

    $namespace = 'Moritz\\Route\\';

    $dir = __DIR__ . '/src/';

    $len = strlen($namespace);
    if (strncmp($namespace, $class, $len) !== 0) {
        return;
    }

    $relative_class = substr($class, $len);
    $file = $dir . str_replace('\\', '/', $relative_class) . '.php';
    if (file_exists($file)) {
        require $file;
    }

});