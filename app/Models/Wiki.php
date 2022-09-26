<?php

namespace Models;

use BaseModel;
use Exception;

class Wiki extends BaseModel {

    private Filesystem $filesystem;

    public function __construct() {
        parent::__construct();
        $this->filesystem = new Filesystem(WIKIS_PATH);
    }

    public function getWikiEntry(String $path): String {

        $path = $path . '.md';

        return $this->filesystem->readFile($path);

    }

    public function sepFilename(string $path): string {

        $path = explode('/', $path);

        return end($path) . '.md';

    }

    public function sepDirectory(string $path): string {

        $path = explode('/', $path);

        $path_length = count($path);
        $i = 0;
        $directory = '/';

        foreach($path as $string) {
            $i++;
            if ($i >= $path_length) {
                break;
            } else {
                $directory .= $string . '/';
            }
        }

        return $directory;
        
    }

}