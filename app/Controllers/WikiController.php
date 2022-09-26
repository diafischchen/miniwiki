<?php

namespace Controllers;

use BaseController;
use DirectoryScanner;
use Exception;
use Models\Filesystem;
use Models\Wiki;
use Parsedown;
use Profiler\Profiler;

class WikiController extends BaseController {

    private Parsedown $parsedown;

    public function __construct() {
        parent::__construct();
        $this->parsedown = new Parsedown;
    }

    public function home() {

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/home', ['heading' => APP_NAME])
            ->renderWikiNav()
            ->render('/wiki/footer');

    }

    public function comingSoon() {
        $this->view
        ->render('/wiki/header')
        ->render('/wiki/home', ['heading' => 'Coming Soon'])
        ->renderWikiNav()
        ->render('/wiki/footer');
    }

    public function wiki(String $path) {

        $wiki = new Wiki;
        $profiler = new Profiler;

        try {
            $text = $wiki->getWikiEntry('/' . $path);
        } catch (Exception $e) {
            $text = $e->getMessage();
        }

        if ($text == '') {
            $text = '# Such Empty, Much Wow';
        }

        $profiler->rec('parse');
        $text = $this->parsedown->text($text);
        $profiler->stop('parse');

        $parse_time = $profiler->dump()->current()->getExecTime();

        // get Wiki Name
        $title = $wiki->sepFilename($path);

        $this->view
            ->render('/wiki/header', ['title' => $title])
            ->render('/wiki/topnav', ['path' => $path])
            ->render('/wiki/entry', ['text' => $text, 'parse_time' => $parse_time])
            ->renderWikiNav($path)
            ->render('/wiki/footer');

    }

    public function createInterface(string $errorstring = '') {

        $in = '/';
        if (isset($_GET['in'])) {
            $in = $_GET['in'];
        }

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Create new', 'back' => ABSURL . 'wiki'])
            ->render('/wiki/editor', [
                'title' => 'Create new Wiki Entry',
                'values' => [
                    'filename' => 'New.md',
                    'directory' => $in,
                    'text' => '',
                    'button' => 'Submit',
                    'submit' => ABSURL . 'create',
                ],
                'errorstring' => $errorstring,
                'second_submit' => false
            ])
            ->renderWikiNav()
            ->render('/wiki/footer');

    }

    public function editInterface(string $path, string $errorstring = '') {

        $wiki = new Wiki;

        try {
            $text = $wiki->getWikiEntry('/' . $path);
            
            $filename = $wiki->sepFilename($path);
            $directory = $wiki->sepDirectory($path);
        } catch (Exception $e) {
            $this->createInterface($e->getMessage());
            die();
        }

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Edit', 'back' => ABSURL . 'wiki/' . $path . '.md'])
            ->render('/wiki/editor', [
                'title' => 'Edit Wiki Entry',
                'values' => [
                    'filename' => $filename,
                    'directory' => $directory,
                    'text' => $text,
                    'button' => 'Edit',
                    'submit' => ABSURL . 'wiki/' . $path . '.md/edit',
                ],
                'errorstring' => $errorstring,
                'second_submit' => [
                    'submit' => ABSURL . 'wiki/' . $path . '.md/delete',
                    'button' => 'Delete'
                ]
            ])
            ->renderWikiNav()
            ->render('/wiki/footer');

    }

    public function dirManagerInterface(string $errorstring = '') {

        // der root wird automatisch auf / gesetzt wenn er vom get nicht gegeben ist
        // der root muss immer mit / anfangen. Nutzer kann zwar manipulieren gewinnt dadurch aber nichts
        $root = '/';
        if (isset($_GET['dir']) && $_GET['dir'] != '') {
            $root = $_GET['dir'];
        }

        $prev = $root;

        // wenn man sich bereits im root befindet kann man kein verzeichnis zurück
        if ($root == '/') {
            $prev = '';
        } else {
            // sonst soll man ins vorherige verzeichnis
            $prev = preg_replace('/^(\/.+)*(\/.+){1}$/', '$1', $prev);

            // Wenn dabei ein leerer string ensteht muss davon ausgehen das das letzte verzeichnis der root ist
            if ($prev == '') {
                $prev = '/';
            }
        }


        $scanner = new DirectoryScanner;

        $dirs = $scanner->scan(WIKIS_PATH . $root);

        // Um die Dateiname / Ordnernamen richtig zu cutten muss jetzt beim root verzeichnis ein / angehangen werden. vorausgesetzt der root ist nicht /
        if ($root != '/') {
            $root .= '/';
        }
        $dirs = $scanner->stripPath($dirs, WIKIS_PATH . $root);

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Directory Manager', 'back' => ABSURL . 'wiki'])
            ->render('/wiki/directory/directories', ['dirs' => $dirs, 'root' => $root, 'prev' => $prev, 'errorstring' => $errorstring])
            ->renderWikiNav('directory-manager')
            ->render('/wiki/footer');

    }

    public function createDirInterface(string $errorstring = '') {
        $in = '';
        if (isset($_GET['in'])) {
            $in = $_GET['in'];
        }

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Create new Directory', 'back' => ABSURL . 'directories?dir=' . rtrim($in, '/')])
            ->render('/wiki/directory/editor', [
                'dirname' => 'New-Folder',
                'dir' => $in,
                'title' => 'Create new Directory',
                'submit' => ABSURL . 'directories/create',
                'button' => 'Submit',
                'errorstring' => $errorstring
            ])
            ->renderWikiNav('directory-manager')
            ->render('/wiki/footer');
    }

    public function renameDirInterface() {

        // ob dir gesetzt ist wird auf dem route level geprüft
        $dir = $_GET['dir'];

        $filesystem = new Filesystem(WIKIS_PATH);

        $dirname = preg_replace('/^.*\/(.+)$/', '$1', $dir);
        $prev = rtrim(str_replace($dirname, '', $dir), '/');
        

        if (!$filesystem->dirExists($dir)) {
            $this->dirManagerInterface();
        }

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Rename Directory', 'back' => ABSURL . 'directories?dir=' . $prev])
            ->render('/wiki/directory/editor', [
                'dirname' => $dirname,
                'dir' => $dir . '/',
                'title' => 'Rename Directory',
                'submit' => ABSURL . 'directories/edit',
                'button' => 'Rename'
            ])
            ->renderWikiNav('directory-manager')
            ->render('/wiki/footer');

    }

    public function createWikiEntry() {

        $filename = $_POST['filename'];
        $directory = $_POST['directory'];
        $text = $_POST['text'];

        $filesystem = new Filesystem(WIKIS_PATH);

        try {
            if (!$filesystem->dirExists($directory)) {
                $filesystem->createDir($directory, true);
            }

            $success = $filesystem->writeFile($filename, $directory, $text, false);

            if ($success) {
                header('Location: ' . ABSURL . 'wiki' . $directory . $filename);
            } else {
                throw new Exception('file could not be created');
            }
        } catch (Exception $e) {
            $this->createInterface($e->getMessage());
        }

    }

    public function editWikiEntry(string $path) {

        // edit a given wiki entry

        // at first get the params from the post. fail save is on route level
        $filename = $_POST['filename'];
        $directory = $_POST['directory'];
        $text = $_POST['text'];

        // initialize a new Filesystem Model with the Wikis Path as Root
        $filesystem = new Filesystem(WIKIS_PATH);
        $wiki = new Wiki;

        try {

            if (!$filesystem->dirExists($directory)) {
                $filesystem->createDir($directory, true);
            }
    
            // write the new file
            $success = $filesystem->writeFile($filename, $directory, $text);

    
            if ($success) {
                // capital and lower letter change support
                $prevFilename = $wiki->sepFilename($path);
                if (strtolower($filename) == strtolower($prevFilename) && $filename != $prevFilename) {
                    $filesystem->renameFile('/' . $path . '.md', $filename);
                }

                // delete old file if it is not the same location
                if (strtolower($directory . $filename) != strtolower('/' . $path . '.md')) {
                    $filesystem->deleteFile('/' . $path . '.md');
                }
    
                header('Location: ' . ABSURL . 'wiki' . $directory . $filename);
            } else {
                throw new Exception('file could not be edited');
            }

        } catch (Exception $e) {

            $this->editInterface($path, $e->getMessage());

        }


    }

    public function deleteWikiEntry(string $path) {

        $filesystem = new Filesystem(WIKIS_PATH);

        try {

            $filesystem->deleteFile('/' . $path . '.md');
            header('Location: ' . ABSURL . 'wiki');

        } catch (Exception $e) {

            $this->createInterface($e->getMessage());

        }

    }

    public function createDir() {
        $dir = $_POST['dir'];
        $dirname = $_POST['dirname'];

        $filesystem = new Filesystem(WIKIS_PATH);

        try {
            $filesystem->createDir($dir . $dirname . '/');

            header('Location: ' . ABSURL . 'directories?dir=' . rtrim($dir, '/'));
        } catch (Exception $e) {
            $this->createDirInterface($e->getMessage());
        }
    }

    public function renameDir() {

        $dir = $_POST['dir'];
        $dirname = $_POST['dirname'];

        $filesystem = new Filesystem(WIKIS_PATH);

        try {
            $success = $filesystem->renameDir($dir, $dirname);

            if ($success) {
                $prev = $filesystem->getPrevDir($dir);
                header('Location: ' . ABSURL . 'directories?dir=' . rtrim($prev, '/'));
            } else {
                throw new Exception('something went wrong');
            }
        } catch (Exception $e) {
            $this->dirManagerInterface($e->getMessage());
        }

    }

    public function deleteDir() {

        $dir = $_POST['dir'];

        $filesystem = new Filesystem(WIKIS_PATH);

        try {
            $filesystem->deleteDir($dir);

            $prev = $filesystem->getPrevDir($dir);
            header('Location: ' . ABSURL . 'directories?dir=' . rtrim($prev, '/'));
        } catch (Exception $e) {
            $this->dirManagerInterface($e->getMessage());
        }

    }

    public function download(string $path) {

        $wiki = new Wiki;
        try {
            $entry = $wiki->getWikiEntry('/' . $path);
            header('Content-Type: text/markdown; charset=UTF-8');
            header('Content-Disposition: attachment; filename="' . $wiki->sepFilename($path) . '"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            header('Cache-Control: private');
            echo $entry;
        } catch (Exception $e) {
            header('Location: ' . ABSURL . 'wiki');
        }

    }

}