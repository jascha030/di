<?php

declare(strict_types=1);

namespace Jascha030\DI;

use Closure;

interface ContainerConfigInterface
{
    /**
     * @return iterable<callable|Closure|mixed> definitions to put into container
     */
    public function getDefinitions(): iterable;

    /**
     * @return iterable<ServiceProviderInterface> service providers to get definitions from
     */
    public function getProviders(): iterable;
}
