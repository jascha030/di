<?php

declare(strict_types=1);

namespace Jascha030\DI;

use Psr\Container\ContainerInterface;

interface ContainerAwareInterface
{
    /**
     * @return ContainerAwareInterface|void
     */
    public function setContainer(ContainerInterface $container);
}
