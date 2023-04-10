<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\ValueObject\Llibre;

use rubenrubiob\Domain\Exception\ValueObject\Llibre\AutorNomIsEmpty;

use function trim;

final readonly class AutorNom
{
    private function __construct(
        /** @var non-empty-string */
        private string $nom
    ) {
    }

    /** @throws AutorNomIsEmpty */
    public static function create(string $nom): self
    {
        return new self(
            self::parseAndValidate($nom)
        );
    }

    /** @return non-empty-string */
    public function toString(): string
    {
        return $this->nom;
    }

    /**
     * @return non-empty-string
     *
     * @throws AutorNomIsEmpty
     */
    private static function parseAndValidate(string $nom): string
    {
        $trimmedNom = trim($nom);

        if ($trimmedNom === '') {
            throw AutorNomIsEmpty::create();
        }

        return $trimmedNom;
    }
}
