<?php

namespace Models;

use BaseModel;

class AuthToken extends BaseModel {

    private string $token;

    /**
     * initialize a new Token or leave the parameter empty to get the current token from the cookie
     *
     * @param string $token
     */
    function __construct(string $token = '') {
        if ($token === '' && isset($_COOKIE['AuthToken'])) {
            $token = $_COOKIE['AuthToken'];
        }

        $this->token = $token;
    }

    /**
     * check if the current auth token is a valid token for the given password
     *
     * @return boolean
     */
    public function isAuthTokenValid(string $password): bool {
        return $this->verifyToken($this->token, $password);
    }

    /**
     * generate a new Auth Token from a given password hash
     *
     * @param string $password
     * @return AuthToken
     */
    public function generateAuthToken(string $password): AuthToken {
        $token = $this->encryptToken($password);
        return new AuthToken($token);
    }

    /**
     * set the current auth token in the cookie
     *
     * @return void
     */
    public function setAuthToken(): void {
        setcookie('AuthToken', $this->token, time()+60*60*24*365, '/', '', true);
    }

    /**
     * unsets the current auth token in the cookie
     *
     * @return void
     */
    public function unsetAuthToken(): void {
        setcookie('AuthToken', '', time()-3600, '/', '', true);
    }

    /**
     * Encrypt a Token
     *
     * @param string $token the decrypted token
     * @return string
     */
    private function encryptToken(string $token): string {
        $token = password_hash($token, PASSWORD_DEFAULT);
        return $token;
    }

    /**
     * verify a Token
     *
     * @param string $token the encrypted token
     * @param string $password the password to match
     * @return boolean
     */
    private function verifyToken(string $token, string $password): bool {
        return password_verify($password, $token);
    }

}