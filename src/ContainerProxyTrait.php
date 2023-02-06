<?php

declare(strict_types=1);

namespace Jascha030\DI;

use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

trait ContainerProxyTrait
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id): mixed
    {
        return $this->getInnerContainer()->get($id);
    }

    public function has(string $id): bool
    {
        return $this->getInnerContainer()->has($id);
    }

    abstract private function getInnerContainer(): ContainerInterface;
}
