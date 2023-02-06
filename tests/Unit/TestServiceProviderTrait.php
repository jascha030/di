<?php

declare(strict_types=1);

namespace Jascha030\DI;

use DI\ContainerBuilder;
use Generator;
use Jascha030\DI\Builder\Builder;
use Jascha030\DI\Config\ContainerConfig;
use Jascha030\DI\Fixtures\MockServiceProvider;
use Jascha030\DI\ServiceProvider\ServiceProviderInterface;
use Psr\Container\ContainerInterface;
use ReflectionException;
use function iterator_to_array;

trait TestServiceProviderTrait
{
    private function getServiceProvider(): ServiceProviderInterface
    {
        return new MockServiceProvider();
    }

    private function getServiceProviders(): array
    {
        return [MockServiceProvider::class];
    }

    private function getDefinitions(): array
    {
        $this->getServiceProvider()->getFactories();
    }

    private function getContainerConfig(): ContainerConfigInterface
    {
        return ContainerConfig::create()->withProviders($this->getServiceProviders());
    }

    /**
     * @throws ReflectionException
     */
    public function getBuilder(): Builder
    {
        return new Builder(function (ContainerConfigInterface $config): ContainerInterface {
            return (new ContainerBuilder())
                ->addDefinitions(iterator_to_array((static function () use ($config): Generator {
                    foreach ($config->getProviders() as $class) {
                        /** @var ServiceProviderInterface $class */
                        yield from (new $class())->getFactories();
                    }
                })()))
                ->build();
        });
    }
}
