<?php

namespace MahdiAslami\Cli\Git;

class Process
{
    public static function run(array $command, ?string $cwd = null, ?array $env = null)
    {
        $process = new \Symfony\Component\Process\Process($command, $cwd, $env);
        $process->run();
        return $process->getOutput();
    }
}
