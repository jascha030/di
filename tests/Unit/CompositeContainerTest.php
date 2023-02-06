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
 * @covers \Jascha030\DI\Builder\Builder
 * @covers \Jascha030\DI\CompositeContainer
 * @covers \Jascha030\DI\Config\ContainerConfig
 * @covers \Jascha030\DI\Exception\ContainerEntryNotFoundException
 * @covers \Jascha030\DI\Exception\ContainerLookupException
 *
 * @internal
 */
final class CompositeContainerTest extends TestCase
{
    use TestServiceProviderTrait;

    /**
     * @throws ContainerExceptionInterface|NotFoundExceptionInterface|ReflectionException
     */
    public function testGet(): void
    {
        assertInstanceOf(DependencyInterface::class, $this->getContainer()->get(DependencyInterface::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testHas(): void
    {
        assertTrue($this->getContainer()->has(DependencyInterface::class));
    }

    /**
     * @throws ReflectionException
     */
    public function testConstruct(): void
    {
        assertInstanceOf(ContainerInterface::class, $this->getContainer());
    }

    /**
     * @throws ReflectionException
     */
    private function getContainer(): ContainerInterface
    {
        $containers = [$this->getBuilder()($this->getContainerConfig())];

        return new CompositeContainer($containers);
    }
}
