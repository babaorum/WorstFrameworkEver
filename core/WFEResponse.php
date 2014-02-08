<?php

namespace core;

/*
 * Class WFEResponse
 */

class WFEResponse {

    protected $content;
    protected $format;

    public function __construct() {

        if ($format == '.json' || '.html') {
            
        }
    }

    public function send() {

        header('Content-type: ' . $this->getFormat());
        exit($this->getContent());
    }

    public function getContent() {

        return $this->content;
    }

    public function setContent($content) {

        $this->content = $content;
    }

    public function getFormat() {

        return $this->format;
    }

    public function setFormat($format) {

        $this->format = $format;
    }

}
