<?php

namespace Profiler\Tmp;

class ProfilerTmpElement {

    private string $name;
    private float $startTime;
    private float $endTime;

    public function __construct(string $name, float $startTime) {
        $this->name = $name;
        $this->startTime = $startTime;
    }

    public function setEndTime(float $endTime): ProfilerTmpElement {
        $this->endTime = $endTime;
        return $this;
    }

    public function getName(): string {
        return $this->name;
    }

    public function getStartTime(): float {
        return $this->startTime;
    }

    public function getEndTime(): float {
        return $this->endTime;
    }

}