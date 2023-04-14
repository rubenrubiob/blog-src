<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\ValueObject\Llibre;

use Ramsey\Uuid\Uuid;
use rubenrubiob\Domain\Exception\ValueObject\Llibre\LlibreIdFormatIsNotValid;
use rubenrubiob\Domain\Exception\ValueObject\Llibre\LlibreIdIsEmpty;

use rubenrubiob\Domain\ValueObject\ValueObject;

use function strtolower;
use function trim;

final readonly class LlibreId implements ValueObject
{
    private function __construct(
        /** @var non-empty-string */
        private string $id
    ) {
    }

    public static function generate(): self
    {
        return new self(
            Uuid::uuid4()->toString()
        );
    }

    /**
     * @throws LlibreIdFormatIsNotValid
     * @throws LlibreIdIsEmpty
     */
    public static function fromString(string $id): self
    {
        $id =  self::parse($id);
        self::validate($id);

        return new self($id);
    }

    public static function defaultNamedConstructor(): callable
    {
        return [self::class, 'fromString'];
    }

    public function isEqualTo(LlibreId $anotherLlibreId): bool
    {
        return $this->id === $anotherLlibreId->id;
    }

    /** @return non-empty-string */
    public function toString(): string
    {
        return $this->id;
    }

    /**
     * @return non-empty-string
     *
     * @throws LlibreIdIsEmpty
     */
    private static function parse(string $id): string
    {
        $trimmedId = trim(strtolower($id));

        if ($trimmedId === '') {
            throw LlibreIdIsEmpty::create();
        }

        return $trimmedId;
    }

    /**
     * @throws LlibreIdFormatIsNotValid
     */
    private static function validate(string $id): void
    {
        if (!Uuid::isValid($id)) {
            throw LlibreIdFormatIsNotValid::withValue($id);
        }
    }
}
