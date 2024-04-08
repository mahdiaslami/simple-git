<?php

namespace Tests;

use MahdiAslami\Console\Process;
use MahdiAslami\Console\Repository;

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
        Process::create($this->tempPath('r'))
            ->add(['git', 'init'])
            ->runAll();

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
}