# Invoke Service Container

WIP...

## Installation

```shell
composer require storinka/invoke-service-container
```

## Usage

```php
use Invoke\Di\ServiceContainer;

$container = new ServiceContainer();

$container->singleton(AbstractService::class, Service::class);
$container->singleton(AbstractService::class, new Service());
$container->singleton(AbstractService::class, fn() => new Service());

$service = $container->get(AbstractService::class);
```