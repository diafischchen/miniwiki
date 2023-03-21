<?php

namespace Controllers;

use BaseController;
use DirectoryScanner;
use Models\Filesystem;

class ImageController extends BaseController {

    public function __construct() {
        parent::__construct();
    }

    public function interface() {

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Image Manager', 'back' => ABSURL . 'wiki'])
            ->render('/wiki/images/overview')
            ->renderWikiNav('image-manager')
            ->render('/wiki/footer');

    }

    public function show() {

        if (!isset($_GET['src'])) {
            return;
        }

        $filesystem = new Filesystem(IMAGES_PATH);
        $file = '/' . $_GET['src'];

        // check if the image is valid
        if (!$filesystem->fileExists($file)) {
            return;
        }

        // output the image
        header('Content-Type: ' . $filesystem->getMimeType($file));
        header('Content-Length: ' . $filesystem->getFilesize($file));
        echo $filesystem->readFile($file);

    }

    public function scanImages() {

        // scan the images directory
        $scanner = new DirectoryScanner;
        $images = $scanner->scan(IMAGES_PATH, DirectoryScanner::FILES_ONLY);
        $images = $scanner->stripPath($images, IMAGES_PATH . "/");

        // sort the output
        $output_array = [];

        foreach ($images as $image) {

            $output_array[] = $image;

        }

        // return all filenames as Array in JSON Format
        api_output($output_array);

    }

}