<?php

namespace MahdiAslami\Cli\Git;

class VersionTag
{
    public Repository $repository;

    public function __construct(Repository $repository)
    {
        $this->repository = $repository;
    }

    public function nextPatch()
    {
        return $this->next('patch');
    }

    public function nextMinor()
    {
        return $this->next('minor');
    }

    public function nextMajor()
    {
        return $this->next('major');
    }

    public function next(string $change)
    {
        $current = $this->latest();
        $arr = [];
        preg_match('/(?<j>\d+)\.(?<i>\d+)\.(?<p>\d+)/', $current, $arr);

        return match ($change) {
            'major' => (++$arr['j']) . '.0.0',
            'minor' => $arr['j'] . '.' . (++$arr['i']) . '.0',
            'patch' => $arr['j'] . '.' . $arr['i'] . '.' . (++$arr['p']),
        };
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
