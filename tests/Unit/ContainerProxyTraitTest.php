<?php

declare(strict_types=1);

namespace Jascha030\DI;

use Jascha030\DI\Fixtures\DependencyInterface;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;
use ReflectionException;
use function PHPUnit\Framework\assertInstanceOf;
use function PHPUnit\Framework\assertTrue;

/**
 * @covers \Jascha030\DI\ContainerProxyTrait
 * @covers \Jascha030\DI\Builder\Builder
 * @covers \Jascha030\DI\Config\ContainerConfig
 */
class ContainerProxyTraitTest extends TestCase
{

    use TestServiceProviderTrait;

    /**
     * @throws ContainerExceptionInterface
     * @throws ReflectionException
     * @throws NotFoundExceptionInterface
     */
    public function testGet(): void
    {
        assertInstanceOf(DependencyInterface::class, $this->mock()->get(DependencyInterface::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testHas(): void
    {
        assertTrue($this->mock()->has(DependencyInterface::class));
    }

    /**
     * @throws ReflectionException
     *
     * @noinspection PhpMissingReturnTypeInspection
     */
    private function mock()
    {
        return new class($this->getBuilder()($this->getContainerConfig())) {
            use ContainerProxyTrait;

            public function __construct(private readonly ContainerInterface $container)
            {}

            private function getInnerContainer(): ContainerInterface
            {
                return $this->container;
            }
        };
    }
}
