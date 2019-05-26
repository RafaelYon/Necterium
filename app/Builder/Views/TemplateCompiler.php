<?php

namespace App\Builder\Views;

class TemplateCompiler
{
    private $originalContent;
    private $resultContent;

    private $fullCommands = [];
    private $commands = [];

    private $vars = [];

    private $waitingCommands = [];

    private $nextTemplateCompilers = [];

    public function __construct($filePath, $vars = [])
    {
        $this->originalContent = file_get_contents($filePath);
        $this->resultContent = $this->originalContent;

        $this->vars = $vars;
    }

    private function findCommands()
    {
        $matchCommands = null;

        preg_match_all('/({{)(([a-z])+(=|:|\'|.)*([a-z])*)+(}})/mi', $this->originalContent, 
            $matchCommands, PREG_OFFSET_CAPTURE);

        if (empty($matchCommands) || empty($matchCommands[2]))
            return;

        $this->fullCommands = $matchCommands[0];
        $this->commands = $matchCommands[2];
    }

    public function compile()
    {
        foreach ($this->commands as $command)
        {

        }
    }

    public function getOriginalContent()
    {
        return $this->originalContent;
    }

    public function getResultContent()
    {
        return $this->resultContent;
    }
    
    public function setResultContent(string $content)
    {
        $this->resultContent = $content;
    }

    public function getFullCommands()
    {
        return $this->fullCommands;
    }

    public function getCommands()
    {
        return $this->commands;
    }

    public function getVars()
    {
        return $this->vars;
    }

    public function setVar($key, $value)
    {
        $this->vars[$key] = $value;
    }

    public function getWaitingCommands()
    {
        return $this->waitingCommands;
    }

    public function addWaitingCommand($commandKey, $commandHandler)
    {
        $this->waitingCommands[$commandKey] = $commandHandler;
    }

    public function addNextTemplateCompile(string $replaceKey, TemplateCompiler $compiler)
    {
        $this->nextTemplateCompilers[$replaceKey] = $compiler;
    }
}