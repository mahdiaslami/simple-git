<?php

namespace MahdiAslami\Cli\Git;

class Add extends Command
{
    public function all()
    {
        Process::run(['git', 'add', '.'], $this->cwd, $this->env);
    }
}
