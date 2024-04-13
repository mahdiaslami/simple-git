<?php

namespace MahdiAslami\Support\Facades;

use MahdiAslami\Cli\Git\Repository;

/**
 * @method static array tags()
 * @method static \MahdiAslami\Cli\Git\Tag tag()
 * @method static void init()
 * @method static void removeVersionControl()
 * @method static void removeWorkspace()
 * @method static \MahdiAslami\Cli\Git\Add add()
 * @method static string shortStatus()
 * @method static \MahdiAslami\Cli\Git\Push push()
 * @method static void checkout(string $target)
 * @method static array versionTags()
 * @method static \MahdiAslami\Cli\Git\VersionTag versionTag()
 * @method static \MahdiAslami\Cli\Git\Repository workDir(string $path)
 * @method static \MahdiAslami\Cli\Git\Repository env(array $env)
 * 
 * @see \MahdiAslami\Cli\Git\Tag
 * @see \MahdiAslami\Cli\Git\Add
 * @see \MahdiAslami\Cli\Git\Push
 * @see \MahdiAslami\Cli\Git\VersionTag
 * @see \MahdiAslami\Cli\Git\Repository
 */
class Git
{
    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     *
     * @throws \RuntimeException
     */
    public static function __callStatic($method, $args)
    {
        $instance = new Repository;

        return $instance->$method(...$args);
    }
}
