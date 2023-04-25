<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Service\Event;

use rubenrubiob\Domain\Event\DomainEvent;

interface EventCollector
{

    public function handle(DomainEvent $event): void;

    public function isSubscribedTo(DomainEvent $event): bool;

    /**
     * @return list<DomainEvent>
     */
    public function events(): array;
}
