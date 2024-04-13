<?php

namespace MahdiAslami\Cli;

class Tag extends Command
{
    public function update()
    {
        $tags = $this->list();

        array_walk($tags, fn($name) => $this->delete($name));

        Process::run(['git', 'fetch', '-t']);
    }

    public function list(): array
    {
        $tags = Process::run(['git', 'tag'], $this->cwd, $this->env);

        return explode("\n", $tags, -1);
    }

    public function delete($name)
    {
        Process::run(['git', 'tag', '-d', $name], $this->cwd, $this->env);
    }

    public function add($name)
    {
        Process::run(['git', 'tag', $name], $this->cwd, $this->env);
    }
}
