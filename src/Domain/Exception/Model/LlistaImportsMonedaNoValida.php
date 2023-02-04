<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\Model;

use Exception;

use function sprintf;

final class LlistaImportsMonedaNoValida extends Exception
{
    public static function perAConstruir(string $moneda): self
    {
        return new self(
            sprintf(
                'Moneda "%s" no vàlida',
                $moneda,
            )
        );
    }
}
