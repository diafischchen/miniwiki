<?php

class View {

    private DirectoryScanner $scanner;

    public function __construct() {
        $this->scanner = new DirectoryScanner;
    }

    public function render(String $__path, Array $__data = array()): View {

        foreach ($__data as $__key => $__value) {
            $$__key = $__value;
        }

        require VIEW_PATH . $__path . '.php';

        return $this;

    }

    public function renderWikiNav(string $current = '') {
        $files = $this->scanner->scan(WIKIS_PATH);
        $files = $this->scanner->stripPath($files, WIKIS_PATH . '/');
        return $this->render('/wiki/navbar', ['files' => $files, 'current' => $current]);
    }

}