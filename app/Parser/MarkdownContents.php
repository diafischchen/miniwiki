<?php

namespace Parser;

class MarkdownContents {

    public function __construct() {
    
    }

    public function text(string $text): string {

        // standardize line breaks
        $text = str_replace(array("\r\n", "\r"), "\n", $text);

        // remove surrounding line breaks
        $text = trim($text, "\n");

        // split text into lines
        $lines = explode("\n", $text);

        // loop through lines
        $markup = $this->lines($lines);

        return $markup;

    }

    private function lines(array $lines): string {

        $blocks = array();

        // loop through lines
        foreach ($lines as $line) {
            
            // check if line is empty
            if ($line == '') {
                continue;
            }

            // check if line is a heading
            if (preg_match('/^(#{1,6})[ ]{1}(.+)$/', $line, $matches)) {

                // add heading to blocks
                $blocks[] = $this->block($matches);

            }

        }

        $markup = '';
        $currentLayer = 0;

        // loop through blocks
        foreach ($blocks as $block) {

            // adjust the layer to the current block
            while ($currentLayer < $block['layer']) {
                $markup .= '<ul>' . PHP_EOL;
                $currentLayer++;
            }

            while ($currentLayer > $block['layer']) {
                $markup .= '</ul>' . PHP_EOL;
                $currentLayer--;
            }

            // add block to markup
            $markup .= '<li><a href="#text-header-' . $this->autoIncrementId() . '">' . $block['text'] . '</a></li>' . PHP_EOL;
            
        }

        // close remaining layers
        while ($currentLayer > 0) {
            $markup .= '</ul>' . PHP_EOL;
            $currentLayer--;
        }

        return $markup;
    }

    private function block(array $matches): array {

        // get heading level
        $layer = strlen($matches[1]);

        // get heading text
        $text = $matches[2];

        return array(
            'layer' => $layer,
            'text' => $text
        );

    }

    private int $autoIncrement = 0;

    private function autoIncrementId(): int {
        $this->autoIncrement++;
        return $this->autoIncrement;
    }

}
?>
