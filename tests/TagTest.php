<?php

namespace Tests;

use MahdiAslami\Console\Process;
use MahdiAslami\Console\Repository;
use PHPUnit\Framework\TestCase;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class TagTest extends TestCase
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

    public function test_get_all_tags()
    {
        Process::create($this->tempPath('r'))
            ->add(['git', 'init'])
            ->add(['git', 'config', '--local', 'user.email', "test@example.com"])
            ->add(['git', 'config', '--local', 'user.name', "Test"])
            ->add(['touch', 'file1'])
            ->add(['git', 'add', '.'])
            ->add(['git', 'commit', '-m', 'add file1'])
            ->add(['git', 'tag', 'tag-1'])
            ->add(['git', 'tag', 'tag-2'])
            ->runAll();

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals(['tag-1', 'tag-2'], $repository->tags());
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
