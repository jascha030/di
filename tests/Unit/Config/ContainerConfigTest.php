<?php
declare(strict_types=1);

namespace Jascha030\DI\Config;

use Closure;
use Jascha030\DI\ContainerConfigInterface;
use Jascha030\DI\TestServiceProviderTrait;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertInstanceOf;

/**
 * @covers \Jascha030\DI\Config\ContainerConfig
 */
class ContainerConfigTest extends TestCase
{
    use TestServiceProviderTrait;

    public function testCreate(): void
    {
        assertInstanceOf(ContainerConfigInterface::class, ContainerConfig::create());
    }

    public function testDefinitions(): void
    {
        assertInstanceOf(
            Closure::class,
            ContainerConfig::create()->withDefinitions(
                ['test' => static fn (): string => 'value']
            )->getDefinitions()['test']
        );
    }

    public function testProviders(): void
    {
        assertEquals(
            $this->getServiceProviders(),
            ContainerConfig::create()->withProviders($this->getServiceProviders())->getProviders()
        );
    }
}
