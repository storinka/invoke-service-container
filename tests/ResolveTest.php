<?php

namespace Tests;

use Tests\Services\AbstractService;
use Tests\Services\Service;

class ResolveClass
{
    public AbstractService $service;

    public function __construct(AbstractService $abstractService)
    {
        $this->service = $abstractService;
    }
}

class SomeClass
{
    public function some(AbstractService $abstractService): AbstractService
    {
        return $abstractService;
    }

    public function staticSome(AbstractService $abstractService): AbstractService
    {
        return $abstractService;
    }
}

function resolveFunction(AbstractService $service): AbstractService
{
    return $service;
}

class ResolveTest extends TestCase
{
    public function testResolveClass()
    {
        $this->container->singleton(AbstractService::class, Service::class);

        $resolved = $this->container->resolve(ResolveClass::class);
        $this->assertNotNull($resolved);
        $this->assertHasClass($resolved, ResolveClass::class);
        $service = $this->container->get(AbstractService::class);
        $this->assertSame($service, $resolved->service);

        $resolved1 = $this->container->resolveClass(ResolveClass::class);
        $this->assertNotNull($resolved1);
        $this->assertHasClass($resolved1, ResolveClass::class);
        $service = $this->container->get(AbstractService::class);
        $this->assertSame($service, $resolved1->service);
    }

    public function testResolveFunction()
    {
        $this->container->singleton(AbstractService::class, Service::class);

        $resolved = $this->container->resolve("Tests\\resolveFunction");
        $this->assertNotNull($resolved);
        $service = $this->container->get(AbstractService::class);
        $this->assertSame($service, $resolved);

        $resolved1 = $this->container->resolveFunction("Tests\\resolveFunction");
        $this->assertNotNull($resolved1);
        $service = $this->container->get(AbstractService::class);
        $this->assertSame($service, $resolved1);
    }

    public function testResolveMethod()
    {
        $this->container->singleton(AbstractService::class, Service::class);

        $someClass = new SomeClass();

        $resolved = $this->container->resolveMethod($someClass, "some");
        $this->assertNotNull($resolved);
        $service = $this->container->get(AbstractService::class);
        $this->assertSame($service, $resolved);
    }

    public function testResolveStaticMethod()
    {
        $this->container->singleton(AbstractService::class, Service::class);

        $resolved = $this->container->resolveStaticMethod(SomeClass::class, "some");
        $this->assertNotNull($resolved);
        $service = $this->container->get(AbstractService::class);
        $this->assertSame($service, $resolved);
    }
}
