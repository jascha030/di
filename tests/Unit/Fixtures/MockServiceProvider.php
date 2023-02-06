<?php

declare(strict_types=1);

namespace Jascha030\DI\Fixtures;

use Jascha030\DI\ServiceProvider\ServiceProviderInterface;
use Psr\Container\ContainerInterface;

class MockServiceProvider implements ServiceProviderInterface
{
    public function getFactories(): iterable
    {
        return [
            'dependency.id' => static function (): string {
                return 'test';
            },
            DependencyInterface::class => static function (ContainerInterface $container): DependencyInterface {
                return new Dependency($container->get('dependency.id'));
            },
            Service::class => static function (ContainerInterface $container): Service {
                return new Service($container->get(DependencyInterface::class));
            },
        ];
    }

    public function getExtensions(): iterable
    {
        return [];
    }
}
