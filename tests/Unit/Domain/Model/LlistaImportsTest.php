<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Domain\Model;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\Exception\Model\LlistaImportsMonedaNoCoincideix;
use rubenrubiob\Domain\Exception\Model\LlistaImportsMonedaNoValida;
use rubenrubiob\Domain\Model\LlistaImports;
use rubenrubiob\Domain\ValueObject\Import;
use rubenrubiob\Domain\ValueObject\PercentatgeImpostos;

final class LlistaImportsTest extends TestCase
{
    private const MONEDA_LOWER = 'eur';

    private const UNA_ALTRA_MONEDA = 'gbp';

    public function test_amb_moneda_no_valida_throws_exception(): void
    {
        $this->expectException(LlistaImportsMonedaNoValida::class);

        LlistaImports::ambMoneda('FOO');
    }

    public function test_amb_dues_monedes_diferents_throws_exception(): void
    {
        $this->expectException(LlistaImportsMonedaNoCoincideix::class);

        $llistaImports = LlistaImports::ambMoneda(self::MONEDA_LOWER);

        $llistaImports->afegirImport(
            Import::ambPreuFinalAmbPercentatgeImpostos(
                1,
                PercentatgeImpostos::ES_IVA_21,
                self::UNA_ALTRA_MONEDA,
            ),
        );
    }

    public function test_amb_imports_valids_calculs_correctes(): void
    {
        $primerImport = Import::ambPreuFinalAmbPercentatgeImpostos(
            5.50,
            PercentatgeImpostos::ES_IVA_21,
            self::MONEDA_LOWER,
        );

        $segonImport = Import::ambPreuFinalAmbPercentatgeImpostos(
            5.30,
            PercentatgeImpostos::ES_IVA_21,
            self::MONEDA_LOWER,
        );

        $llistaImports = LlistaImports::ambMoneda(self::MONEDA_LOWER);

        $llistaImports->afegirImport($primerImport);
        $llistaImports->afegirImport($primerImport);
        $llistaImports->afegirImport($primerImport);
        $llistaImports->afegirImport($primerImport);
        $llistaImports->afegirImport($primerImport);

        $llistaImports->afegirImport($segonImport);
        $llistaImports->afegirImport($segonImport);
        $llistaImports->afegirImport($segonImport);
        $llistaImports->afegirImport($segonImport);
        $llistaImports->afegirImport($segonImport);

        self::assertSame(4465, $llistaImports->totalPreusNetsMinor());
        self::assertSame(935, $llistaImports->totalImpostosMinor());
        self::assertSame(5400, $llistaImports->totalMinor());
        self::assertCount(10, $llistaImports->imports());
    }
}
