<?php

declare(strict_types=1);

namespace Jascha030\DI\Fixtures;

/**
 * @internal
 */
final class Service
{
    public function __construct(private readonly DependencyInterface $dependency)
    {
    }

    public function getDependency(): DependencyInterface
    {
        return $this->dependency;
    }
}
