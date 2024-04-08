<?php

namespace MahdiAslami\Console;

class Push extends Command
{
    public function tags()
    {
        return Process::run(['git', 'push', '--tags'], $this->cwd, $this->env);
    }
}
