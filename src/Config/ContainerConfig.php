<?php

declare(strict_types=1);

namespace Jascha030\DI\Config;

use Jascha030\DI\ContainerConfigInterface;

class ContainerConfig implements ContainerConfigInterface
{
    private array $definitions = [];

    private array $providers = [];

    private function __construct()
    {
    }

    public static function create(): self
    {
        return new self();
    }

    public function withDefinitions(array $definitions): self
    {
        $new              = clone $this;
        $new->definitions = $definitions;

        return $new;
    }

    public function getDefinitions(): array
    {
        return $this->definitions;
    }

    /**
     * @param array $providers service providers to get definitions from
     */
    public function withProviders(array $providers): self
    {
        $new            = clone $this;
        $new->providers = $providers;

        return $new;
    }

    public function getProviders(): array
    {
        return $this->providers;
    }
}
