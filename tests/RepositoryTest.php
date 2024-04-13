<?php

namespace Tests;

use MahdiAslami\Cli\Git\Repository;

class RepositoryTest extends TestCase
{
    public function test_init_method()
    {
        $repository = new Repository($this->tempPath('r'));
        $repository->init();

        $this->assertDirectoryExists($this->tempPath('r/.git'));
    }

    public function test_removeVertionControl_method()
    {
        $this->runOneCommand(['git', 'init'], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));
        $repository->removeVersionControl();

        $this->assertDirectoryDoesNotExist($this->tempPath('r/.git'));
    }

    public function test_removeWorksapce_method()
    {
        $repository = new Repository($this->tempPath('r'));
        $repository->removeWorkspace();

        $this->assertDirectoryDoesNotExist($this->tempPath('r'));
    }

    public function test_add_and_shortStatus_methods()
    {
        $repository = new Repository($this->tempPath('r'));
        $repository->init();

        file_put_contents($this->tempPath('r/file1'), '');

        $repository->add()->all();

        $this->assertEquals(
            'A  file1',
            trim($repository->shortStatus())
        );
    }

    public function test_checkout_method()
    {
        $this->runMultipleCommands([
            ['git', 'init'],
            ['git', 'config', '--local', 'user.email', "test@example.com"],
            ['git', 'config', '--local', 'user.name', "Test"],
            ['touch', 'file1'],
            ['git', 'add', '.'],
            ['git', 'commit', '-m', 'add file1'],
            ['git', 'branch', 'branch-test'],
        ], $this->tempPath('r'));

        $repository = new Repository($this->tempPath('r'));
        $repository->checkout('branch-test');

        $this->assertEquals(
            '## branch-test',
            trim($this->runOneCommand(['git', 'status', '-bs'], $this->tempPath('r')))
        );
    }
}