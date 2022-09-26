<?php

namespace Profiler;

use Profiler\Tmp\ProfilerTmpElement;

class ProfilerElement {

    private string $name;
    private float $startTime;
    private float $endTime;

    public function __construct(ProfilerTmpElement $el) {
        $this->name = $el->getName();
        $this->startTime = $el->getStartTime();
        $this->endTime = $el->getEndTime();
    }

    /**
     * Name der Laufzeit
     *
     * @return string
     */
    public function getName(): string {
        return $this->name;
    }

    /**
     * Laufzeit ausgeben
     *
     * @return float
     */
    public function getExecTime(): float {
        return $this->endTime - $this->startTime;
    }

    /**
     * Startzeit der Laufzeitaufnahme
     *
     * @return float
     */
    public function getStartTime(): float {
        return $this->startTime;
    }

    /**
     * Endzeit der Laufzeitaufnahme
     *
     * @return float
     */
    public function getEndTime(): float {
        return $this->endTime;
    }

}