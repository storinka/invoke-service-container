<?php

require "vendor/autoload.php";

use Invoke\Di\ServiceContainer;

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$container = new ServiceContainer();

$container->singleton(ServiceContainer::class, $container);

echo $container->resolve(function (ServiceContainer $wow) use ($container) {
    echo $wow === $container;
    return "rofl";
});