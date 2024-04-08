<?php

namespace Tests;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public function setUp(): void
    {
        if (file_exists($this->tempPath('r'))) {
            $this->removeDirectory($this->tempPath('r'));
        }

        mkdir($this->tempPath('r'), recursive: true);
    }

    public function tearDown(): void
    {
        if (file_exists($this->tempPath('r'))) {
            $this->removeDirectory($this->tempPath('r'));
        }
    }

    public function tempPath($path = '')
    {
        return rtrim(join(DIRECTORY_SEPARATOR, [__DIR__, 'temp', trim($path, '\/')]), '\/');
    }

    public function removeDirectory($path)
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
}
