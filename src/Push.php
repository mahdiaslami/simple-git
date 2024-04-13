<?php

namespace MahdiAslami\Cli;

class Push extends Command
{
    public function tags()
    {
        return Process::run(['git', 'push', '--tags'], $this->cwd, $this->env);
    }
}
