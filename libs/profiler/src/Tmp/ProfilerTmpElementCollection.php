<?php

namespace Profiler\Tmp;

class ProfilerTmpElementCollection {

    private Array $array;

    public function __construct() {
        $this->array = [];
    }

    public function push(string $name, ProfilerTmpElement $el): ProfilerTmpElementCollection {
        $this->array[$name] = $el;
        return $this;
    }

    public function get($name): ProfilerTmpElement | false {
        if (isset($this->array[$name])) {
            return $this->array[$name];
        } else {
            return false;
        }
    }

}