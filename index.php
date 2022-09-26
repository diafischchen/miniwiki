<?php

session_start();

const ABSPATH = __DIR__;

require ABSPATH . '/config/main.php';

new App;