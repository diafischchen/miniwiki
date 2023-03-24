<?php

namespace Controllers;

use BaseController;

class APIController extends BaseController {

    public function outputJSON(Array $data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}