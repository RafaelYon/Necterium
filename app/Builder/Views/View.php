<?php

namespace App\Builder\Views;

use App\Exceptions\ViewNotFoundException;

class View
{
    private $viewFile;
    private $vars;
    
    public static function make(string $viewFile, array $vars = null) : View
    {
        return new View($viewFile, $vars);
    }

    private function __construct(string $viewKey, array $vars = null)
    {
        $this->findFile($viewKey);
        $this->vars = $vars;
    }

    private function findFile(string $viewKey)
    {
        $pathParts = explode('.', $viewKey);

        $this->viewFile = config('view.folder') 
            . \implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';

        if (!file_exists($this->viewFile))
            throw new ViewNotFoundException($viewKey, $this->viewFile);
    }

    public function render()
    {
        ob_start();

        if ($this->vars != null)
            extract($this->vars, EXTR_OVERWRITE);

        require($this->viewFile);

        ob_flush();
    }
}