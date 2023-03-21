<?php

use Controllers\ImageController;
use Controllers\LoginController;
use Controllers\WikiController;
use Moritz\Route\Auth;
use Moritz\Route\Route;

Route::base(substr($_SERVER['SCRIPT_NAME'], 0, -10));


/**
 * ------------------------------
 * Login Routen
 * ------------------------------
 */


Auth::make('login', function() {
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] == 'true') {
        return true;
    } else {
        return false;
    }
});

Route::add('/', function() {

    // Login Interface
    $c = new LoginController;
    $c->interface();

});

Route::add('/login', function() {
    // Login Post
    $c = new LoginController;
    $c->login();
}, 'post');

Route::add('/logout', function() {

    $c = new LoginController;
    $c->logout();

})->auth('login');



/**
 * ------------------------------
 * Wiki Routen
 * ------------------------------
 */


Route::add('/wiki', function() {
    // wiki overview
    $c = new WikiController;
    $c->home();
})->auth('login');


Route::add('/wiki/(.+).md', function($path) {
    // display a wiki
    $c = new WikiController;
    $c->wiki($path);
})->auth('login');


Route::add('/wiki/(.+).md/edit', function($path) {
    // edit a specific wiki
    $c = new WikiController;
    $c->editInterface($path);
})->auth('login');



Route::add('/wiki/(.+).md/edit', function($path) {
    $c = new WikiController;
    if (isset($_POST['filename']) && isset($_POST['directory']) && isset($_POST['text'])) {
        $c->editWikiEntry($path);
    } else {
        $c->editInterface($path, 'something went wrong');
    }
}, 'post')->auth('login');


Route::add('/wiki/(.+).md/download', function($path) {
    // edit a specific wiki
    $c = new WikiController;
    $c->download($path);
})->auth('login');


Route::add('/create', function() {
    $c = new WikiController;
    $c->createInterface();
})->auth('login');



Route::add('/create', function() {
    $c = new WikiController;
    if (isset($_POST['filename']) && isset($_POST['directory']) && isset($_POST['text'])) {
        $c->createWikiEntry();
    } else {
        $c->createInterface('something went wrong');
    }
}, 'post')->auth('login');



Route::add('/wiki/(.+).md/delete', function($path) {
    $c = new WikiController;
    $c->deleteWikiEntry($path);
}, 'post')->auth('login');


/**
 * ------------------------------
 * Directory Routen
 * ------------------------------
 */


Route::add('/directories', function() {
    $c = new WikiController;
    $c->dirManagerInterface();
})->auth('login');


Route::add('/directories/create', function() {
    $c = new WikiController;
    $c->createDirInterface();
})->auth('login');



Route::add('/directories/create', function() {
    $c = new WikiController;
        if (isset($_POST['dirname']) && isset($_POST['dir'])) {
        $c->createDir();
    } else {
        $c->createDirInterface('something went wrong');
    }
}, 'post')->auth('login');



Route::add('/directories/edit', function() {
    $c = new WikiController;
    if (isset($_GET['dir'])) {
        $c->renameDirInterface();
    } else {
        $c->dirManagerInterface('something went wrong');
    }
})->auth('login');



Route::add('/directories/edit', function() {
    $c = new WikiController;
    if (isset($_POST['dirname']) && isset($_POST['dir'])) {
        $c->renameDir();
    } else {
        $c->dirManagerInterface('something went wrong');
    }
}, 'post')->auth('login');



Route::add('/directories/delete', function() {
    $c = new WikiController;
    if (isset($_POST['dir'])) {
        $c->deleteDir();
    } else {
        $c->dirManagerInterface('something went wrong');
    }
}, 'post')->auth('login');



/**
 * ------------------------------
 * Image Routen
 * ------------------------------
 */


Route::add('/images', function(){
    $c = new ImageController;
    $c->interface();
})->auth('login');

Route::add('/image', function(){
    $c = new ImageController;
    $c->show();
})->auth('login');

Route::add('/images/scan', function(){
    $c = new ImageController;
    $c->scanImages();
}, 'post')->auth('login');


/**
 * ------------------------------
 * Error Routen
 * ------------------------------
 */

Route::error(Route::FORBIDDEN, function() {
    header('Location: ' . ABSURL);
});

Route::error(Route::PATH_NOT_FOUND, function() {
    header('Location: ' . ABSURL . 'wiki');
});

Route::error(Route::METHOD_NOT_ALLOWED, function() {
    header('Location: ' . ABSURL . 'wiki');
});