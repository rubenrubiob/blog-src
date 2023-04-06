<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\ValueObject\Llibre;

use rubenrubiob\Domain\Exception\ValueObject\Llibre\LlibreTitolIsEmpty;

use function trim;

final readonly class LlibreTitol
{
    private function __construct(
        /** @var non-empty-string */
        private string $titol
    ) {
    }

    /** @throws LlibreTitolIsEmpty */
    public static function create(string $titol): self
    {
        return new self(
            self::parseAndValidate($titol)
        );
    }

    public function toString(): string
    {
        return $this->titol;
    }

    /**
     * @return non-empty-string
     *
     * @throws LlibreTitolIsEmpty
     */
    private static function parseAndValidate(string $titol): string
    {
        $trimmedTitol = trim($titol);

        if ($trimmedTitol === '') {
            throw LlibreTitolIsEmpty::create();
        }

        return $trimmedTitol;
    }
}
