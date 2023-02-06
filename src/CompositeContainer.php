<?php

declare(strict_types=1);

namespace Jascha030\DI;

use Jascha030\DI\Exception\ContainerEntryNotFoundException;
use Jascha030\DI\Exception\ContainerLookupException;
use Psr\Container\ContainerInterface;

class CompositeContainer implements ContainerInterface
{
    private array $lookupTable = [];

    private iterable $containers;

    /**
     * @param iterable<ContainerInterface> $containers
     */
    public function __construct(iterable $containers)
    {
        $this->containers = array_filter($containers, [$this, 'validateContainer']);
    }

    /**
     * {@inheritDoc}
     *
     * @throws ContainerEntryNotFoundException|ContainerLookupException
     */
    public function get(string $id)
    {
        if ($this->has($id)) {
            if (! isset($this->containers[$this->lookupTable[$id]])) {
                throw new ContainerLookupException($id);
            }

            return $this->containers[$this->lookupTable[$id]]->get($id);
        }

        throw new ContainerEntryNotFoundException($id);
    }

    /**
     * {@inheritDoc}
     *
     * @noinspection MultipleReturnStatementsInspection
     */
    public function has(string $id): bool
    {
        if (isset($this->lookupTable[$id])) {
            return true;
        }

        foreach ($this->containers as $index => $container) {
            if (! $container->has($id)) {
                continue;
            }

            $this->lookupTable[$id] = $index;

            return true;
        }

        return false;
    }

    private function validateContainer(ContainerInterface $item): ContainerInterface
    {
        return $item;
    }
}
