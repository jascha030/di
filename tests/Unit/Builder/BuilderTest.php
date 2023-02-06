<?php

declare(strict_types=1);

namespace Jascha030\DI\Builder;

use DI\ContainerBuilder;
use Generator;
use InvalidArgumentException;
use Jascha030\DI\BuilderInterface;
use Jascha030\DI\ContainerConfigInterface;
use Jascha030\DI\ServiceProvider\ServiceProviderInterface;
use Jascha030\DI\TestServiceProviderTrait;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use ReflectionException;
use function PHPUnit\Framework\assertInstanceOf;

/**
 * @covers \Jascha030\DI\Builder\Builder
 * @covers \Jascha030\DI\Config\ContainerConfig
 */
final class BuilderTest extends TestCase
{
    use TestServiceProviderTrait;

    /**
     * @throws ReflectionException
     */
    public function testConstruct(): void
    {
        assertInstanceOf(BuilderInterface::class, $this->getBuilder());
    }

    /**
     * @depends testConstruct
     * @throws ReflectionException
     */
    public function testInvoke(): void
    {
        $builder = $this->getBuilder();

        assertInstanceOf(ContainerInterface::class, $builder($this->getContainerConfig()));
    }

    /**
     * @throws ReflectionException
     */
    public function testThrowsOnInvalidClosureArgumentType(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Builder(static fn (array $param) => false);
    }

    /**
     * @throws ReflectionException
     */
    public function testThrowsOnInvalidClosureArgummentNumber(): void
    {
        $this->expectException(InvalidArgumentException::class);

        new Builder(static fn (ContainerConfigInterface $config, string $ewa) => false);
    }
}
