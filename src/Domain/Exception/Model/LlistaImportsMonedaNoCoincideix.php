<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Exception\Model;

use Exception;

use function sprintf;

final class LlistaImportsMonedaNoCoincideix extends Exception
{
    public static function perALlistaAmbMoneda(string $monedaLlista, string $monedaImport): self
    {
        return new self(
            sprintf(
                'La moneda "%s" no és vàlida per a la llista amb moneda "%s"',
                $monedaLlista,
                $monedaImport,
            ),
        );
    }
}
