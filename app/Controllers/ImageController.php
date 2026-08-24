<?php

namespace Controllers;

use BaseController;
use DirectoryScanner;
use Exception;
use Models\Filesystem;

class ImageController extends BaseController {

    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/gif',
        'image/webp',
        'image/svg+xml',
        'image/bmp',
    ];

    public function __construct() {
        parent::__construct();
    }

    public function interface() {

        $this->view
            ->render('/wiki/header')
            ->render('/wiki/toolbar', ['title' => 'Image Manager', 'back' => ABSURL . 'wiki'])
            ->render('/wiki/images/overview')
            ->render('/wiki/images/upload-modal')
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
        $api = new APIController;
        $api->outputJSON($output_array);

    }

    public function upload() {

        $api = new APIController;

        if (!isset($_FILES['images'])) {
            $api->outputJSON(['uploaded' => [], 'errors' => []]);
            return;
        }

        $filesystem = new Filesystem(IMAGES_PATH);

        $names = $_FILES['images']['name'];
        $tmpPaths = $_FILES['images']['tmp_name'];
        $errorCodes = $_FILES['images']['error'];

        $uploaded = [];
        $errors = [];

        for ($i = 0; $i < count($names); $i++) {

            $name = basename($names[$i]);

            if ($errorCodes[$i] !== UPLOAD_ERR_OK) {
                $errors[] = $name;
                continue;
            }

            // validate that the uploaded file is actually an image
            $mimeType = mime_content_type($tmpPaths[$i]);
            if (!in_array($mimeType, self::ALLOWED_MIME_TYPES)) {
                $errors[] = $name;
                continue;
            }

            try {
                $filesystem->writeUploadedImage($name, $tmpPaths[$i]);
                $uploaded[] = $name;
            } catch (Exception $e) {
                $errors[] = $name;
            }

        }

        $api->outputJSON(['uploaded' => $uploaded, 'errors' => $errors]);

    }

}