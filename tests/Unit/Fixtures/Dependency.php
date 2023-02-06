<?php

declare(strict_types=1);

namespace Jascha030\DI\Fixtures;

/**
 * @internal
 */
final class Dependency implements DependencyInterface
{
    public function __construct(private readonly string $id)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }
}
