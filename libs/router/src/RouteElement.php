<?php

namespace Moritz\Route;

class RouteElement {

    private $uri;
    private $function;
    private $method;
    private $auth = true;

    function __construct(Array $params) {

        $this->uri = $params['uri'];
        $this->function = $params['function'];
        $this->method = $params['method'];

    }

    public function getUri() {
        return $this->uri;
    }

    public function getFunction() {
        return $this->function;
    }

    public function getMethod() {
        return $this->method;
    }

    public function getAuth() {
        return $this->auth;
    }

    public function auth($name, Array $params_arr = []) {
        $this->auth = Auth::call($name, $params_arr);
    }

}