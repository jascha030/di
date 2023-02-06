<?php

declare(strict_types=1);

namespace Jascha030\DI\Exception;

use Exception;
use Psr\Container\ContainerExceptionInterface;
use Throwable;

class ContainerLookupException extends Exception implements ContainerExceptionInterface
{
    public function __construct($id, $code = 0, Throwable $previous = null)
    {
        parent::__construct(
            sprintf('Error while retrieving entry with ID: "%s".', $id),
            $code,
            $previous
        );
    }
}
