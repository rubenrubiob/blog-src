<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\ValueObject\Llibre;

use Exception;

final class LlibreTitolIsEmpty extends Exception
{
    public static function create(): self
    {
        return new self('LlibreTitol provided is empty');
    }
}
