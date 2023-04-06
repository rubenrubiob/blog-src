<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\ValueObject\Llibre;

use Exception;

final class AutorNomIsEmpty extends Exception
{
    public static function create(): self
    {
        return new self('AutorNom provided is empty');
    }
}
