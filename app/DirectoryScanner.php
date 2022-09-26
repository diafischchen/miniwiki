<?php

class DirectoryScanner {

    public const DEFAULT = 1;
    public const DIRS_ONLY = 2;

    public function __construct() {
        
    }

    public function scan(String $path, int $option = 1): Array {

        $files = [];

        $path = rtrim($path, '/');

        // at first all directorys
        foreach(glob($path . '/*', GLOB_ONLYDIR) as $dir) {
            $files[$dir] = $this->scan($dir, $option);
        }

        // then all .md files if option is default
        if ($option === 1) {
            foreach(glob($path . '/*.md') as $file) {
                $files[$file] = $file;
            }
        }

        return $files;

    }

    public function stripPath(Array $array, String $path): Array {

        $striped = [];

        foreach($array as $key => $value) {

            $striped_key = str_replace($path, '', $key);

            // if a dir, strip only key and continue with the inner array
            // if a file, strip both key and value
            
            if (is_array($value)) {
                $striped[$striped_key] = $this->stripPath($value, $path . $striped_key . '/');
            } else {
                $striped[$striped_key] = str_replace($path, '', $value);
            }

        }

        return $striped;

    }


}