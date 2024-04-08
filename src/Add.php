<?php

namespace MahdiAslami\Console;

class Add extends Command
{
    public function all()
    {
        Process::run(['git', 'add', '.'], $this->cwd, $this->env);
    }
}
