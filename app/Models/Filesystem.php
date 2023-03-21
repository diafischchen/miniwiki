<?php

namespace Models;

use BaseModel;
use Exception;
use Models\Validator\FilesystemValidator;

class Filesystem extends BaseModel {

    private FilesystemValidator $validator;
    private string $root;

    /**
     * Initialize a Filesystem Model for a given Path
     *
     * @param string $root This path will operate as the root Path for this Filesystem Model
     */
    public function __construct(string $root) {
        parent::__construct();
        $this->validator = new FilesystemValidator;
        $this->root = $root;
    }

    /**
     * Creates a Directory for the Given Path
     *
     * @param string $dir the Directory Path
     * @param boolean $nested if this is set to true, this method will also create all nested directorys needed to create the given directory
     * @return boolean success
     * 
     * @throws Exception
     */
    public function createDir(string $dir, bool $nested = false): bool {

        $dirValid = $this->validator->validateDirName($dir);

        if (!$dirValid) {
            throw new Exception('given directory name is not valid');
        }

        if ($this->dirExists($dir)) {
            throw new Exception('directory already exists');
        }

        return mkdir($this->root . $dir, 0777, $nested);

    }

    /**
     * Creates a File in a given Directory
     *
     * @param string $file the filename
     * @param string $dir the directory path
     * @param string $text the text of the file
     * @param bool $overwrite if this is set to false this method will not overwrite existing files
     * @return boolean success
     * 
     * @throws Exception
     */
    public function writeFile(string $file, string $dir = '/', string $text = '', bool $overwrite = true): bool {
        $fileValid = $this->validator->validateFileName($file);
        $dirValid = $this->validator->validateDirName($dir);

        if (!$fileValid || !$dirValid) {
            throw new Exception('filename or directory name is not valid');
        }

        if ($this->fileExists($dir . $file) && !$overwrite) {
            throw new Exception('not allowed to overwrite existing file');
        }

        if (file_put_contents($this->root . $dir . $file, $text) !== false) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Reads the Content of a File
     *
     * @param string $filepath the path to the file
     * @return string
     * 
     * @throws Exception
     */
    public function readFile(string $filepath): string {

        if ($this->fileExists($filepath)) {
            return file_get_contents($this->root . $filepath);
        } else {
            throw new Exception('could not find a file in the given path');
        }
        
    }

    /**
     * returns the size of the file in bytes
     *
     * @param string $filepath
     * @return integer
     * 
     * @throws Exception
     */
    public function getFilesize(string $filepath): int {

        if ($this->fileExists($filepath)) {
            return filesize($this->root . $filepath);
        } else {
            throw new Exception('could not find a file in the given path');
        }

    }

    /**
     * returns the mime type of the file as string
     *
     * @param string $filepath
     * @return string
     * 
     * @throws Exception
     */
    public function getMimeType(string $filepath): string {

        if ($this->fileExists($filepath)) {
            return mime_content_type($this->root . $filepath);
        } else {
            throw new Exception('could not find a file in the given path');
        }

    }

    /**
     * Deletes a given File
     *
     * @param string $filepath the path of the file
     * @return boolean
     * 
     * @throws Exception
     */
    public function deleteFile(string $filepath): bool {
        if (!$this->fileExists($filepath)) {
            throw new Exception('cannot delete nonexistent file');
        }

        if ($this->dirExists($filepath)) {
            throw new Exception('cannot delete directorys');
        }

        return unlink($this->root . $filepath);
    }

    public function renameFile(string $filepath, string $newFilename): bool {
        $oldFilepathValid = $this->validator->validateFilePath($filepath);
        $newFilenameValid = $this->validator->validateFileName($newFilename);

        if (!$oldFilepathValid || !$newFilenameValid) {
            throw new Exception('filepath or filename is not valid');
        }

        if (!$this->fileExists($filepath)) {
            throw new Exception('cannot rename nonexistent file');
        }

        $prev = $this->getFileDir($filepath);

        $newFilepath = $prev . $newFilename;

        return rename($this->root . $filepath, $this->root . $newFilepath);
    }

    public function renameDir(string $dirpath, string $newDirName): bool {
        $oldDirpathValid = $this->validator->validateDirName($dirpath);
        $newDirnameValid = $this->validator->validateSingleDirName($newDirName);

        if (!$oldDirpathValid) {
            throw new Exception('dirpath is not valid');
        }

        if (!$newDirnameValid) {
            throw new Exception('new dirname is not valid');
        }

        if (!$this->dirExists($dirpath)) {
            throw new Exception('cannot rename nonexistent directory');
        }

        if ($dirpath == '/') {
            throw new Exception('cannot rename root directory');
        }

        $prev = $this->getPrevDir($dirpath);

        $newDirpath = $prev . $newDirName . '/';

        return rename($this->root . $dirpath, $this->root . $newDirpath);
    }

    public function deleteDir(string $dirpath): bool {
        $dirpathValid = $this->validator->validateDirName($dirpath);

        if (!$dirpathValid) {
            throw new Exception('dirpath is not valid');
        }

        if (!$this->dirExists($dirpath)) {
            throw new Exception('cannot delete nonexistent directories');
        }

        return $this->delRecursive($dirpath);
    }

    private function delRecursive(string $dir) {
        $files = array_diff(scandir($this->root . $dir), array('.','..'));
        foreach ($files as $file) {
            ($this->dirExists($dir . $file)) ? $this->delRecursive($dir . $file . '/') : $this->deleteFile($dir . $file);
        }
        return rmdir($this->root . $dir);
    }

    /**
     * Checks if a Directory exists
     *
     * @param string $dir the directory path
     * @return boolean
     */
    public function dirExists(string $dir): bool {
        return is_dir($this->root . $dir);
    }

    /**
     * Checks if a File exists
     *
     * @param string $filepath the path to the file
     * @return boolean
     */
    public function fileExists(string $filepath): bool {
        if (file_exists($this->root . $filepath)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * returns the previous directory path. returns false if the root directory is given
     *
     * @param string $dirpath
     * @return mixed
     * 
     * @throws Exception
     */
    public function getPrevDir(string $dirpath): mixed {
        $dirpathValid = $this->validator->validateDirName($dirpath);

        if (!$dirpathValid) {
            throw new Exception('dirpath is not valid');
        }

        if ($dirpath == '/') {
            return false;
        }

        $pieces = explode('/', $dirpath);

        // first and last element are empty strings and need to be removed
        array_shift($pieces);
        array_pop($pieces);

        $pieces_count = count($pieces);
        $i = 0;
        $prev = '/';

        foreach ($pieces as $dirname) {
            $i++;
            if ($i >= $pieces_count) {
                break;
            } else {
                $prev .= $dirname . '/';
            }
        }

        return $prev;
    }

    public function getFileDir(string $filepath): string {
        $filepathValid = $this->validator->validateFilePath($filepath);

        if (!$filepathValid) {
            throw new Exception('filepath is not valid');
        }

        $pieces = explode('/', $filepath);

        // first element is empty string and needs to be removed
        array_shift($pieces);

        $pieces_count = count($pieces);
        $i = 0;
        $prev = '/';

        foreach ($pieces as $pathname) {
            $i++;
            if ($i >= $pieces_count) {
                break;
            } else {
                $prev .= $pathname . '/';
            }
        }

        return $prev;
    }

}