<?php

namespace Controllers;

use BaseController;
use Models\AuthToken;

class LoginController extends BaseController {
 
    public function __construct() {
        parent::__construct();
    }

    public function interface() {
        $auth = new AuthToken();

        if ($auth->isAuthTokenValid(AUTH_PASSWORD)) {

            $this->writeSessionAndRedirect();

        }

        $this->view->render('/login');
    }

    public function login() {
        if (isset($_POST['username']) && isset($_POST['password'])) {
            $username = $_POST['username'];
            $password = sha1($_POST['password']);

            if ($username == AUTH_USERNAME && $password == AUTH_PASSWORD) {

                if (isset($_POST['keep_logged_in'])) {
                    $auth = new AuthToken();
                    $auth->generateAuthToken($password)->setAuthToken();
                }

                $this->writeSessionAndRedirect();

            } else {
                header('Location: ' . ABSURL);
                die();
            }
        }
    }

    public function logout() {
        session_unset();
        $auth = new AuthToken();
        $auth->unsetAuthToken();
        header('Location: ' . ABSURL);
        die();
    }

    private function writeSessionAndRedirect() {
        $_SESSION['logged_in'] = 'true';
        header('Location: ' . ABSURL . 'wiki/');
        die();
    }

}