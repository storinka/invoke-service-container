<?php

namespace Invoke\Di;

interface Container
{
    public function bind(string $abstract, $service);

    public function singleton(string $abstract, $service);

    public function get(string $abstract);

    public function delete(string $abstract);

    public function resolve($classOrFunction);

    public function resolveClass(string $class);

    public function resolveFunction($function);

    public function resolveMethod(object $object, string $method);

    public function resolveStaticMethod(string $class, string $method);
}
