<?php

function debug_r(Array $array) {
    echo '<pre>';
    print_r($array);
    echo '</pre>';
}

function api_output(Array $data) {
    header('Content-Type: application/json');
    echo json_encode($data);
    die();
}