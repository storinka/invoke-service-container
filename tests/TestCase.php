<?php

namespace Tests;

use Invoke\Di\Container;
use Invoke\Di\ServiceContainer;

class TestCase extends \PHPUnit\Framework\TestCase
{
    public Container $container;

    protected function setUp(): void
    {
        $this->container = new ServiceContainer();
    }

    public static function assertHasClass($actualObject, $expectedClass)
    {
        static::assertSame($expectedClass, get_class($actualObject));
    }

    public static function assertSameClass($expectedObject, $actualObject)
    {
        static::assertSame(get_class($expectedObject), get_class($actualObject));
    }
}
