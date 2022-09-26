<?php

/* CLIENT CODE */

use Profiler\Profiler;

require 'autoload.php';


$profiler = new Profiler;


$profiler->rec('all')->rec('firstSection');

// some code

$profiler->stop('firstSection')->rec('secondSection');

// section code

$profiler->stop('secondSection')->stop('all')->stop(Profiler::SERVER_REQUEST_TIME);

$times = $profiler->dump();

foreach($times as $time) {
    echo $time->getName() . ': ';
    echo $time->getExecTime() . '<br />';
}
