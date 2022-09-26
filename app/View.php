<?php

class View {

    private DirectoryScanner $scanner;

    public function __construct() {
        $this->scanner = new DirectoryScanner;
    }

    public function render(String $__path, Array $data = array()): View {

        foreach ($data as $key => $value) {
            $$key = $value;
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