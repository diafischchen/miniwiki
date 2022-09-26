<?php

namespace Moritz\Route;

class Auth {

    private static $auths = Array();

    public const VERSION = '1.0';

    public static function make($name, $function) {

        self::$auths[$name] = new AuthElement([
            'name' => $name,
            'function' => $function
        ]);

    }

    public static function get($name) {
        return self::$auths[$name];
    }

    public static function call($name, Array $param_arr = []) {
        return call_user_func_array(self::get($name)->getFunction(), $param_arr);
    }

}
