<?php

declare(strict_types=1);

namespace Jascha030\DI;

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
        $this->containers = $containers;

        $this->containers = array_filter(
            $this->containers,
            static fn ($item): bool => is_subclass_of(ContainerInterface::class, $item)
        );
    }

    /**
     * {@inheritDoc}
     */
    public function get(string $id)
    {
        if (isset($this->lookupTable[$id])) {
            return $this->containers[$this->lookupTable[$id]]->get($id);
        }
        // TODO: Throw exception.
    }

    /**
     * {@inheritDoc}
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
}
