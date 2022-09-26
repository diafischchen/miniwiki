<?php

use Moritz\Route\Route;

class App {

    function __construct() {
        
        
        $this->importRoutes();

        Route::run();

    }

    private function importRoutes() {
        require CONFIG_PATH . '/routes.php';
    }

}