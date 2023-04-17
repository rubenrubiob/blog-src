<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\ValueObject;

interface ValueObject
{
    public static function defaultNamedConstructor(): callable;
}
