<?php

namespace MahdiAslami\Cli;

class Process
{
    public array $commands = [];

    public ?array $env;

    public ?string $cwd;

    public function __construct(?string $cwd = null, ?array $env = null)
    {
        $this->env = $env;
        $this->cwd = $cwd;
    }

    public static function run(array $command, ?string $cwd = null, ?array $env = null)
    {
        return (new Process($cwd, $env))->add($command)->runAll();
    }

    public static function create(?string $cwd = null, ?array $env = null)
    {
        return new Process($cwd, $env);
    }

    public function add(array $command)
    {
        $this->commands[] = $command;

        return $this;
    }

    public function runAll(): string
    {
        $result = '';

        array_walk($this->commands, function ($command) use (&$result) {
            $process = new \Symfony\Component\Process\Process($command, $this->cwd, $this->env);
            $process->run();
            $result .= "\n" . $process->getOutput();
        });

        return substr($result, 1);
    }
}
