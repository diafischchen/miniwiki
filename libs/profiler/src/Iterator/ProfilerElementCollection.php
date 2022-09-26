<?php

namespace Profiler\Iterator;

use Profiler\ProfilerElement;

class ProfilerElementCollection {

    private $array = Array();

    public function __construct() {
        
    }

    public function push(ProfilerElement $element): ProfilerElementCollection {
        $this->array[] = $element;
        return $this;
    }

    public function get(int $pos): ProfilerElement {
        return $this->array[$pos];
    }

    public function valid(int $pos): bool {
        return isset($this->array[$pos]);
    }

    public function count(): int {
        return count($this->array);
    }

}