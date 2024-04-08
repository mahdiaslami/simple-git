<?php

namespace Tests;

use MahdiAslami\Console\Process;
use MahdiAslami\Console\Repository;

class TagTest extends TestCase
{
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
}
