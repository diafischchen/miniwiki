<?php

class DirectoryScanner {

    public const DEFAULT = 1;
    public const DIRS_ONLY = 2;
    public const FILES_ONLY = 3;

    public function __construct() {
        
    }

    /**
     * scans the given directory recursively
     *
     * @param String $path
     * @param integer $option
     * @return Array
     */
    public function scan(String $path, int $option = 1): Array {

        $files = [];

        $path = rtrim($path, '/');

        // at first all directorys
        if ($option === 1 || $option === 2) {
            foreach(glob($path . '/*', GLOB_ONLYDIR) as $dir) {
                $files[$dir] = $this->scan($dir, $option);
            }
        }

        // then all files if option is default
        if ($option === 1 || $option === 3) {
            foreach(glob($path . '/*.*') as $file) {
                if (is_file($file)) {
                    $files[$file] = $file;
                }
            }
        }

        return $files;

    }

    /**
     * strips the path from the file- and directory names in the recursive scan array
     *
     * @param Array $array
     * @param String $path
     * @return Array
     */
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