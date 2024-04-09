<?php

namespace Tests;

use MahdiAslami\Console\Process;
use MahdiAslami\Console\Repository;

class VersionTagTest extends TestCase
{
    public function test_get_all_versions()
    {
        Process::create($this->tempPath('r'))
            ->add(['git', 'init'])
            ->add(['git', 'config', '--local', 'user.email', "test@example.com"])
            ->add(['git', 'config', '--local', 'user.name', "Test"])
            ->add(['touch', 'file1'])
            ->add(['git', 'add', '.'])
            ->add(['git', 'commit', '-m', 'add file1'])
            ->add(['git', 'tag', 'tag-test'])
            ->add(['git', 'tag', 'v0.1.0'])
            ->add(['git', 'tag', 'v0.2.0'])
            ->runAll();

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals(['v0.1.0', 'v0.2.0'], $repository->versionTags());
    }


    public function test_latest_method()
    {
        Process::create($this->tempPath('r'))
            ->add(['git', 'init'])
            ->add(['git', 'config', '--local', 'user.email', "test@example.com"])
            ->add(['git', 'config', '--local', 'user.name', "Test"])
            ->add(['touch', 'file1'])
            ->add(['git', 'add', '.'])
            ->add(['git', 'commit', '-m', 'add file1'])
            ->add(['git', 'tag', 'v0.1.0'])
            ->add(['git', 'tag', 'v0.2.0'])
            ->runAll();

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals('v0.2.0', $repository->versionTag()->latest());
    }
}
