<?php

namespace MahdiAslami\Console;

class VersionTag
{
    public Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function latest(): string
    {
        $v = $this->list();

        uasort(
            $v,
            fn($a, $b) => version_compare($b, $a)
        );

        return array_values($v)[0];
    }

    public function list(): array
    {
        $result = array_filter(
            $this->repository->tags(),
            fn($tag) => preg_match('/v(?<num>\d+\.\d+\.\d+)/', $tag) > 0
        );

        return array_values($result);
    }
}
