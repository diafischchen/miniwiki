<?php

spl_autoload_register(function($class) {

    $class = '/' . $class;

    // Namespaces zu Ordnernamen Konvertieren
    $class = str_replace('\\', '/', $class);

    // Dateiendung .php anhängen
    $class .= '.php';

    // Datei includen wenn sie existiert
    if (file_exists(APP_PATH . $class)) {
        require APP_PATH . $class;
    } else {
        return;
    }

});