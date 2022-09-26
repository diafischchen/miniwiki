<?php

namespace Models\Validator;

class FilesystemValidator {

    public function __construct() {
        
    }

    public function validateDirName(string $dir): bool {
        $regex = '/^\/([a-zA-Z0-9_-]+\/)*$/';
        if (preg_match($regex, $dir)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateFileName(string $file): bool {
        $regex = '/^[a-zA-Z0-9._-]+[.]{1}md$/';
        if (preg_match($regex, $file)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateFilePath(string $filepath): bool {
        $regex = '/^\/([a-zA-Z0-9_-]+\/)*([a-zA-Z0-9._-]+[.]{1}md){1}$/';
        if (preg_match($regex, $filepath)) {
            return true;
        } else {
            return false;
        }
    }

    public function validateSingleDirName(string $dirname): bool {
        $regex = '/^[a-zA-Z0-9_-]+$/';
        if (preg_match($regex, $dirname)) {
            return true;
        } else {
            return false;
        }
    }

}