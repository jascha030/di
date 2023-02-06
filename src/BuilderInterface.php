<?php

declare(strict_types=1);

namespace Jascha030\DI;

use Psr\Container\ContainerInterface;
use Jascha030\DI\Config\ContainerConfig;

interface BuilderInterface
{
    public function __invoke(ContainerConfig $config): ContainerInterface;
}
