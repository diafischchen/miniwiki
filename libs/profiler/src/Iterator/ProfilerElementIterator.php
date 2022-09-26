<?php

namespace Profiler\Iterator;

use Iterator;
use Profiler\Iterator\ProfilerElementCollection;
use Profiler\ProfilerElement;

class ProfilerElementIterator implements Iterator {

    private ProfilerElementCollection $collection;
    private $position = 0;
    private $reverse = false;

    public function __construct(ProfilerElementCollection $collection, bool $reverse = false) {
        
        $this->collection = $collection;
        $this->reverse = $reverse;

    }

    public function current(): ProfilerElement {

        return $this->collection->get($this->position);

    }

    public function next(): void {

        if ($this->reverse) {
            $this->position--;
        } else {
            $this->position++;
        }

    }

    public function key(): int {

        return $this->position;

    }

    public function valid(): bool {

        return $this->collection->valid($this->position);

    }

    public function rewind(): void {

        if ($this->reverse) {
            $this->position = $this->collection->count() - 1;
        } else {
            $this->position = 0;
        }
        
    }

}
