<?php

class BaseController {

    public View $view;

    public function __construct() {
        
        $this->view = new View;

    }

}