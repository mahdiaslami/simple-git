<?php

namespace Tests;

use MahdiAslami\Cli\Git\Repository;

class VersionTagTest extends TestCase
{
    public function test_get_all_versions()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'tag', 'tag-test'],
            ['git', 'tag', 'v0.1.0'],
            ['git', 'tag', 'v0.2.0'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals(['v0.1.0', 'v0.2.0'], $repository->versionTags());
    }


    public function test_latest_method()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'tag', 'v0.1.0'],
            ['git', 'tag', 'v0.2.0'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals('v0.2.0', $repository->versionTag()->latest());
    }

    public function test_nextPatch_method()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'tag', 'v0.1.0'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals('0.1.1', $repository->versionTag()->nextPatch());
    }

    public function test_nextMinor_method()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'tag', 'v0.1.1'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals('0.2.0', $repository->versionTag()->nextMinor());
    }

    public function test_nextMajor_method()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'tag', 'v0.1.1'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));

        $this->assertEquals('1.0.0', $repository->versionTag()->nextMajor());
    }
}
