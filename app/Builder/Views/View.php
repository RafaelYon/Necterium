<?php

namespace App\Builder\Views;

use App\Exceptions\ViewNotFoundException;
use App\Exceptions\UnableOpenFileException;

use App\Builder\Views\TemplateCompiler;

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
        $this->handlerFile($viewKey);
        $this->vars = $vars;
    }

    private function getViewPath($folderKey, $viewKey)
    {
        $pathParts = explode('.', $viewKey);
        
        return config('app.resources.' . $folderKey)
            . implode(DIRECTORY_SEPARATOR, $pathParts) . '.php';
    }

    private function checkChache(string $viewFile, string $cacheFile)
    {
        // Em desenvolvimento sempre "recompile" a view
        if (config('app.debug'))
            return false;
        
        return file_exists($cacheFile);
    }

    private function createSubfoldersIfNeed(string $fileKey)
    {
        $paths = explode('.', $fileKey);

        $path = config('app.resources.cache_folder');

        @mkdir($path);

        for ($i = 0, $len = count($paths) - 1; $i < $len; $i++)
        {
            $path .= $paths[$i] . DIRECTORY_SEPARATOR;

            @mkdir($path);
        }
    }

    private function writeCacheFile(string $cacheKey, string $cacheFilePath, string $content)
    {
        $this->createSubfoldersIfNeed($cacheKey);
        
        $file = fopen($cacheFilePath, 'w+');

        if ($file === false)
        {
            throw new UnableOpenFileException($cacheFilePath, 'w+');
        }
        
        fwrite($file, $content);

        fclose($file);
    }

    private function constructView(string $viewFile)
    {
        $compiler = new TemplateCompiler($viewFile);
        return $compiler->compile();
    }

    private function handlerFile(string $viewKey)
    {
        $viewFile = $this->getViewPath('view_folder', $viewKey);
        $cacheFile = $this->getViewPath('cache_folder', $viewKey);

        if (!file_exists($viewFile))
            throw new ViewNotFoundException($viewKey, $viewFile);

        if (!$this->checkChache($viewFile, $cacheFile))
        {
            $this->writeCacheFile(
                $viewKey,
                $cacheFile,
                $this->constructView($viewFile)
            );
        }
        else
            dp('Cache esta atualizado');

        $this->viewFile = $cacheFile;
    }

    public function addVar($key, $var)
    {
        $this->vars[$key] = $var;
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