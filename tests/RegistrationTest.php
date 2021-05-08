<?php

namespace Tests;

use Tests\Services\AbstractService;
use Tests\Services\Service;

class RegistrationTest extends TestCase
{
    public function testSingleton()
    {
        $this->container->singleton(AbstractService::class, Service::class);

        $service = $this->container->get(AbstractService::class);

        $this->assertNotNull($service);
        $this->assertHasClass($service, Service::class);
    }

    public function testBind()
    {
        $this->container->bind(AbstractService::class, Service::class);

        $service1 = $this->container->get(AbstractService::class);
        $this->assertNotNull($service1);
        $this->assertHasClass($service1, Service::class);

        $service2 = $this->container->get(AbstractService::class);
        $this->assertNotNull($service2);
        $this->assertHasClass($service2, Service::class);

        $this->assertSameClass($service1, $service2);
        $this->assertNotSame($service1, $service2);
    }

    public function testDelete()
    {
        // bind

        $this->container->bind(AbstractService::class, Service::class);

        $service1 = $this->container->get(AbstractService::class);
        $this->assertNotNull($service1);

        $this->container->delete(AbstractService::class);

        $service1 = $this->container->get(AbstractService::class);
        $this->assertNull($service1);

        // singleton

        $this->container->singleton(AbstractService::class, Service::class);

        $service2 = $this->container->get(AbstractService::class);
        $this->assertNotNull($service2);

        $this->container->delete(AbstractService::class);

        $service2 = $this->container->get(AbstractService::class);
        $this->assertNull($service2);

        // both

        $this->container->bind(AbstractService::class, Service::class);
        $this->container->singleton(AbstractService::class, Service::class);

        $service2 = $this->container->get(AbstractService::class);
        $this->assertNotNull($service2);

        $this->container->delete(AbstractService::class);

        $service2 = $this->container->get(AbstractService::class);
        $this->assertNull($service2);
    }
}
