<?php

namespace Erekle\Commissions;

use Psr\Container\ContainerInterface;

/**
 * Class ServiceContainer
 *
 * A custom implementation of a service container, which manages dependencies
 * and their life cycles based on their definitions.
 */
class ServiceContainer implements ContainerInterface
{
    /**
     * @var array An array of instantiated services.
     */
    public array $services = [];

    /**
     * @var array An array of service definitions.
     */
    private array $definitions = [];

    /**
     * ServiceContainer constructor.
     *
     * @param array $config An array of service definitions.
     */
    public function __construct(array $config)
    {
        $this->definitions = $config;
    }

    /**
     * Retrieve a service from the container.
     *
     * @param string $id The service identifier.
     *
     * @return mixed The requested service.
     *@throws \Exception If the service is not found.
     *
     */
    public function get(string $id): mixed
    {
        if (!$this->has($id)) {
            throw new \Exception("Service {$id} not found.");
        }

        if (!isset($this->services[$id])) {
            $this->services[$id] = $this->createService($id);
        }

        return $this->services[$id];
    }

    /**
     * Check if the container has a service with the given identifier.
     *
     * @param string $id The service identifier.
     *
     * @return bool True if the service exists, false otherwise.
     */
    public function has(string $id): bool
    {
        return isset($this->definitions[$id]);
    }

    /**
     * Create a new service instance based on its definition.
     *
     * @param string $id The service identifier.
     *
     * @return mixed The created service.
     */
    private function createService($id): mixed
    {
        $entry = $this->definitions[$id];
        return $entry($this);
    }
}
