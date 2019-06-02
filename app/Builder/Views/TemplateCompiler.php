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

    private $nextTemplate = null;

    public function __construct($filePath, $vars = [])
    {
        $this->originalContent = file_get_contents($filePath);
        $this->resultContent = $this->originalContent;

        $this->vars = $vars;

        $this->findCommands();
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

    public function compile() : string
    {
        foreach ($this->commands as $command)
        {
            $parts = explode('=', $command[0]);

            if (isset($this->waitingCommands[$parts[0]]))
            {
                $this->waitingCommands[$parts[0]]->finish($command[1]);
            }
            else
            {
                $class = config('view.template.commands.'.$parts[0]);

                if (!isset($parts[1]))
                    $parts[1] = null;

                $handler = $class::create($this);
                $handler->handler($parts[1]);
            }
        }

        if ($this->nextTemplate == null)
        {
            $result =  $this->getResultContent();

            if (config('view.template.remove_multiple_empty_lines'))
            {
                $result = preg_replace('/(\n)+/', "\n", $result);
            }

            return $result;
        }

        $nextCompiler = new TemplateCompiler(
            $this->nextTemplate,
            $this->vars
        );

        return $nextCompiler->compile();
    }

    public function getOriginalContent()
    {
        return $this->originalContent;
    }

    public function setOriginalContent($content)
    {
        $this->originalContent = $content;
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

    public function getVar($key)
    {
        if (!isset($this->vars[$key]))
            return '';

        return $this->vars[$key];
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

    public function setNextTemplateToCompile(string $path)
    {
        $this->nextTemplate = $path;
    }
}