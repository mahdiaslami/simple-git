<?php

namespace Tests;

use MahdiAslami\Cli\Repository;

class TagTest extends TestCase
{
    public function test_get_all_tags()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'tag', 'tag-1'],
            ['git', 'tag', 'tag-2'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals(['tag-1', 'tag-2'], $repository->tags());
    }

    public function test_add_method()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));
        $repository->tag()->add('tag-test');

        $this->assertEquals('tag-test', trim($this->runOneCommand(['git', 'tag'], $this->tempPath('r'))));
    }
}
