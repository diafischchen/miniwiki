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
     * check if the current auth token is a valid token for the given username and password
     *
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function isAuthTokenValid(string $username, string $password): bool {
        return $this->verifyToken($this->token, $username, $password);
    }

    /**
     * generate a new Auth Token from a given username and password hash
     *
     * @param string $username
     * @param string $password
     * @return AuthToken
     */
    public function generateAuthToken(string $username, string $password): AuthToken {
        $token = $this->encryptToken($username, $password);
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
     * Encrypt a Token using username and password
     *
     * @param string $username the username
     * @param string $password the password
     * @return string
     */
    private function encryptToken(string $username, string $password): string {
        // Combine username and password with a separator to create unique token
        $tokenData = $username . '|' . $password;
        $token = password_hash($tokenData, PASSWORD_DEFAULT);
        return $token;
    }

    /**
     * verify a Token using username and password
     *
     * @param string $token the encrypted token
     * @param string $username the username to match
     * @param string $password the password to match
     * @return boolean
     */
    private function verifyToken(string $token, string $username, string $password): bool {
        // Combine username and password with the same separator used during encryption
        $tokenData = $username . '|' . $password;
        return password_verify($tokenData, $token);
    }

}