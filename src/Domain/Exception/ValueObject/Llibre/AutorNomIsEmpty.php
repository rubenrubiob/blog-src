<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\ValueObject\Llibre;

use Exception;
use rubenrubiob\Domain\Exception\ValueObject\InvalidValueObject;

final class AutorNomIsEmpty extends Exception implements InvalidValueObject
{
    public static function create(): self
    {
        return new self('AutorNom provided is empty');
    }
}
