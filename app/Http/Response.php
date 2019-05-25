<?php

namespace App\Http;

use App\Builder\Views\View;

class Response
{
    private $content;
    private $code;
    private $contentType = 'text/html';
    
    public function __construct($content, int $code = 200)
    {
        $this->content = $content;
        $this->code = $code;
    }

    private function writeHeader()
    {
        $this->contentType .= '; charset=UTF-8';

        header('Content-Type: ' . $this->contentType, true, $this->code);
    }

    public function json()
    {
        $this->contentType = 'application/json';
        $this->content = json_encode($this->content);
    }

    public function response() : string
    {
        $this->writeHeader();
        
        if ($this->content instanceof View)
            $this->content->render();
        else
            echo $this->content;

        exit();
    }
}