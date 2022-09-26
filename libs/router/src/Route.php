<?php

namespace Moritz\Route;

use ReflectionClass;

class Route {

    public static $routes = Array();
    private static $base = '/';

    private static $forbidden = null;
    private static $pathNotFound = null;
    private static $methodNotAllowed = null;

    public const FORBIDDEN = 403;
    public const PATH_NOT_FOUND = 404;
    public const METHOD_NOT_ALLOWED = 405;

    public const VERSION = '1.2';

    public static function add($uri, $function, $method = 'get') {

        $el = new RouteElement([
            'uri' => $uri,
            'function' => $function,
            'method' => $method
        ]);
        array_push(self::$routes, $el);
        return $el;

    }

    public static function error($code, $function) {

        switch ($code) {
            case 403:
                self::$forbidden = $function;
                break;
            case 404:
                self::$pathNotFound = $function;
                break;
            case 405:
                self::$methodNotAllowed = $function;
                break;
            default:
            return false;
        }

    }

    public static function base($uri) {

        self::$base = $uri;

    }

    public static function run() {

        $uri = parse_url($_SERVER['REQUEST_URI'])['path'];
        $method = $_SERVER['REQUEST_METHOD'];
        
        $route_match = false;
        $method_match = false;
        $auth_match = false;

        foreach (self::$routes as $route) {

            $pattern = $route->getUri();
            if (self::$base != '/' && self::$base != '') $pattern = '(' . self::$base . ')' . $pattern;
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {

                $route_match = true;

                if (strtolower($route->getMethod()) == strtolower($method)) {

                    $method_match = true;

                    if ($route->getAuth()) {

                        $auth_match = true;

                        array_shift($matches);

                        if (self::$base != '/' && self::$base != '') array_shift($matches);
    
                        if (is_string($route->getFunction())) {

                            $string = $route->getFunction();
                            $string_syntax = "/^([\\a-zA-Z_\x80-\xff][\\a-zA-Z0-9_\x80-\xff]*)@([a-zA-Z_\x80-\xff][a-zA-Z0-9_\x80-\xff]*)/";

                            if (preg_match($string_syntax, $string, $class_parts)) {

                                $class = $class_parts[1];
                                $method = $class_parts[2];
                                $instance = new $class;
                                call_user_func_array([$instance, $method], $matches);

                            } else {

                                $class = $route->getFunction();
                                $ref = new ReflectionClass($class);
                                $ref->newInstanceArgs($matches);

                            }
                            
                        } else {
                            call_user_func_array($route->getFunction(), $matches);
                        }

                    }

                }

            }

        }

        if (!$route_match) {
            header("HTTP/1.0 404 Not Found");
            if (Route::$pathNotFound) call_user_func(Route::$pathNotFound);
        } elseif (!$method_match) {
            header("HTTP/1.0 405 Method Not Allowed");
            if (Route::$methodNotAllowed) call_user_func(Route::$methodNotAllowed);
        } elseif (!$auth_match) {
            header("HTTP/1.0 403 Forbidden");
            if (Route::$forbidden) call_user_func(Route::$forbidden);
        }

    }

}
