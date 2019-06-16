<?php

namespace App\Http;

use App\Builder\Views\View;
use App\Http\Request;

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

    public function json() : Response
    {
        $this->contentType = 'application/json';
        $this->content = json_encode($this->content);

        return $this;
    }

    public function setRequest(Request $request)
    {
        if ($this->content instanceof View)
            $this->content->addVar('request', $request);
    }

    public function response()
    {
        $this->writeHeader();
        
        if ($this->content instanceof View)
            $this->content->render();
        else
            echo $this->content;

        exit();
    }

    public static function redirect(string $url, bool $permanent, bool $found = true)
    {
        header('Location: '.$url, true, $permanent ? 301 : $found ? 302 : 303);
        
        exit();
    }
}