<?php

namespace MahdiAslami\Console;

abstract class Command
{
    public ?array $env;

    public ?string $cwd;

    public function __construct(?string $cwd = null, ?array $env = null)
    {
        $this->env = $env;
        $this->cwd = $cwd;
    }
}
