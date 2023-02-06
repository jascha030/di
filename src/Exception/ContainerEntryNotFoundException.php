<?php

declare(strict_types=1);

namespace Jascha030\DI\Exception;

use Exception;
use Psr\Container\NotFoundExceptionInterface;
use Throwable;

class ContainerEntryNotFoundException extends Exception implements NotFoundExceptionInterface
{
    public function __construct($id, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('No entry was found for identifier: "%s".', $id),
            $code,
            $previous
        );
    }
}
