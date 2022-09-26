<?php

namespace Moritz\Route;

class AuthElement {

    private $name;
    private $function;

    function __construct(Array $params) {

        $this->name = $params['name'];
        $this->function = $params['function'];

    }

    public function getName() {
        return $this->name;
    }

    public function getFunction() {
        return $this->function;
    }

}
