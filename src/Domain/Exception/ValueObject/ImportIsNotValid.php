<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\ValueObject;

use Exception;

use function sprintf;

final class ImportIsNotValid extends Exception
{
    public static function ambPreuFinal(float|int|string $quantitat, string $moneda): self
    {
        return new self(
            sprintf(
                'Import amb preu final "%s" i moneda "%s" no vàlid',
                $quantitat,
                $moneda,
            ),
        );
    }
}
