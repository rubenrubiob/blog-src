<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Event;

use DateTimeImmutable;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;

final readonly class LlibreWasCreated implements DomainEvent
{
    private LlibreId $llibreId;

    private DateTimeImmutable $occurredOn;

    public function __construct(LlibreId $llibreId, DateTimeImmutable $occurredOn)
    {
        $this->llibreId   = $llibreId;
        $this->occurredOn = $occurredOn;
    }

    public function aggregateRootId(): string
    {
        return $this->llibreId->toString();
    }

    public function type(): string
    {
        return self::class;
    }

    public function occurredOn(): DateTimeImmutable
    {
        return $this->occurredOn;
    }

    public function payload(): array
    {
        return [
            'llibre_id' => $this->llibreId->toString(),
        ];
    }
}
