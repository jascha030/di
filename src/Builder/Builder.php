<?php

declare(strict_types=1);

namespace Jascha030\DI\Builder;

use Closure;
use InvalidArgumentException;
use Jascha030\DI\ContainerConfigInterface;
use Psr\Container\ContainerInterface;
use Jascha030\DI\Config\ContainerConfig;
use Jascha030\DI\BuilderInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use function reset;
use function sprintf;

class Builder implements BuilderInterface
{
    private Closure $factory;

    /**
     * @param callable $callable
     *
     * @throws ReflectionException
     */
    public function __construct(callable|Closure $callable)
    {
        $this->setFactory($callable(...));
    }

    public function __invoke(ContainerConfig $config): ContainerInterface
    {
        return ($this->factory)($config);
    }

    /**
     * @throws ReflectionException
     */
    private function setFactory(Closure $factory): void
    {
        $reflection = new ReflectionFunction($factory);

        if ($reflection->getNumberOfParameters() > 1) {
            throw throw self::invalidArgumentException();
        }

        $params = $reflection->getParameters();
        $param  = reset($params);

        if ($param->getType()?->isBuiltin()) {
            throw self::invalidArgumentException();
        }

        $type = new ReflectionClass($param->getType()?->getName());

        if (
            ! $type->isSubclassOf(ContainerConfigInterface::class)
            && ContainerConfigInterface::class !== $type->getName()
        ) {
            throw self::invalidArgumentException();
        }

        $this->factory = $factory;
    }

    private static function invalidArgumentException(): InvalidArgumentException
    {
        return new InvalidArgumentException(
            sprintf('Factory callable should take 1 argument of type :%s.', ContainerConfigInterface::class)
        );
    }
}
