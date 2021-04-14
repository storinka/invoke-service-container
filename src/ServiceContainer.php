<?php

namespace Invoke\Di;

use ReflectionClass;
use ReflectionFunction;

class ServiceContainer
{
    protected array $services = [];
    protected array $singletons = [];

    public function bind(string $abstract, $service)
    {
        $this->services[$abstract] = $service;
    }

    public function singleton(string $abstract, $service)
    {
        $this->singletons[$abstract] = $service;
    }

    public function get(string $abstract)
    {
        if (isset($this->services[$abstract])) {
            $service = $this->services[$abstract] ?? null;

            if (is_callable($service) || (is_string($service) && class_exists($service))) {
                $service = $this->resolve($service);
            }
        } else if (isset($this->singletons[$abstract])) {
            $service = $this->singletons[$abstract] ?? null;

            if (is_callable($service) || (is_string($service) && class_exists($service))) {
                $service = $this->resolve($service);
            }

            $this->singletons[$abstract] = $service;
        } else {
            return $this->resolve($abstract);
        }

        return $service;
    }

    public function resolve($service)
    {
        if (is_callable($service)) {
            $reflectionFunction = new ReflectionFunction($service);
            $params = $this->resolveParameters($reflectionFunction->getParameters());

            return $service(...$params);
        }

        if (is_string($service) && class_exists($service)) {
            $reflectionClass = new ReflectionClass($service);

            if ($reflectionClass->isInstantiable()) {
                $reflectionConstructor = $reflectionClass->getConstructor();

                if ($reflectionConstructor) {
                    $params = $this->resolveParameters($reflectionConstructor->getParameters());
                } else {
                    $params = [];
                }

                return new $service(...$params);
            }
        }

        return null;
    }

    protected function resolveParameters(array $parameters): array
    {
        $params = [];

        foreach ($parameters as $param) {
            $paramType = $param->getType();

            if ($paramType->isBuiltin()) {
                $params[] = null;
            } else {
                $params[] = $this->get($paramType->getName());
            }
        }

        return $params;
    }
}