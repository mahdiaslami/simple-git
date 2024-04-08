<?php

namespace MahdiAslami\Console;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class Repository
{
    public ?array $env;

    public ?string $cwd;

    public function __construct(?string $cwd = null, ?array $env = null)
    {
        $this->env = $env;
        $this->cwd = rtrim(realpath($cwd), '\/');
    }

    public function tags(): array
    {
        return $this->tag()->list();
    }

    public function tag(): Tag
    {
        return new Tag($this->cwd, $this->env);
    }

    public function init()
    {
        Process::run(['git', 'init'], $this->cwd, $this->env);
    }

    public function removeVersionControl()
    {
        $this->removeDirectory($this->cwd . DIRECTORY_SEPARATOR . '.git');
    }

    public function removeWorkspace()
    {
        $this->removeDirectory($this->cwd);
    }

    private function removeDirectory($path)
    {
        $files = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($files as $fileinfo) {
            $func = ($fileinfo->isDir() ? 'rmdir' : 'unlink');
            $func($fileinfo->getRealPath());
        }

        rmdir($path);
    }

    public function add()
    {
        return new Add($this->cwd, $this->env);
    }

    public function shortStatus(): string
    {
        return Process::run(['git', 'status', '--short'], $this->cwd, $this->env);
    }
}