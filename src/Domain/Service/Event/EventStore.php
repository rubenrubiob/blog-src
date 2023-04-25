<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Service\Event;

use BadMethodCallException;
use rubenrubiob\Domain\Event\DomainEvent;

final class EventStore
{
    private static self $instance;

    /** @var array<int, EventCollector> */
    private array $collectors = [];

    private int $id = 0;

    public function __construct()
    {
    }

    public static function getInstance(): self
    {
        /** @psalm-suppress RedundantPropertyInitializationCheck */
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /** @throws BadMethodCallException */
    public function __clone()
    {
        throw new BadMethodCallException('Clone is not supported');
    }

    public function publish(DomainEvent $event): void
    {
        foreach ($this->collectors as $collector) {
            if ($collector->isSubscribedTo($event)) {
                $collector->handle($event);
            }
        }
    }

    public function addCollector(EventCollector $collector): int
    {
        $id = $this->id;
        $this->collectors[$id] = $collector;
        $this->id++;

        return $id;
    }

    public function removeCollector(int $id): void
    {
        if (isset($this->collectors[$id])) {
            unset($this->collectors[$id]);
        }
    }
}
