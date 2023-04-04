<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Domain\ValueObject;

use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\Exception\ValueObject\ImportIsNotValid;
use rubenrubiob\Domain\ValueObject\Import;
use rubenrubiob\Domain\ValueObject\PercentatgeImpostos;

final class ImportTest extends TestCase
{
    private const MONEDA_UPPER = 'EUR';
    private const MONEDA_LOWER = 'eur';

    public function test_moneda_incorrecta_throws_exception(): void
    {
        $this->expectException(ImportIsNotValid::class);

        Import::ambPreuFinalAmbPercentatgeImpostos(
            12,
            PercentatgeImpostos::ES_IVA_21,
            'FOO',
        );
    }

    public function test_preu_final_incorrecte_throws_exception(): void
    {
        $this->expectException(ImportIsNotValid::class);

        Import::ambPreuFinalAmbPercentatgeImpostos(
            'foo',
            PercentatgeImpostos::ES_IVA_21,
            self::MONEDA_UPPER,
        );
    }

    #[DataProvider('preuNetIImpostProvider')]
    public function test_import_amb_impost_retorna_valors_esperat(
        int $expectedMinorPreuNet,
        int $expectedMinorQuantitatImpostos,
        int $expectedMinorTotal,
        float|string $preuFinal,
    ): void {
        $import = Import::ambPreuFinalAmbPercentatgeImpostos(
            $preuFinal,
            PercentatgeImpostos::ES_IVA_21,
            self::MONEDA_LOWER,
        );

        self::assertSame($expectedMinorPreuNet, $import->preuNetMinor());
        self::assertSame($expectedMinorQuantitatImpostos, $import->quantitatImpostosMinor());
        self::assertSame($expectedMinorTotal, $import->preuFinalMinor());
        self::assertSame(21, $import->percentatgeImpostos()->value);
        self::assertSame(self::MONEDA_UPPER, $import->moneda());
    }

    public static function preuNetIImpostProvider(): array
    {
        return [
            '5.50 (float)' => [
                455,
                95,
                550,
                5.50,
            ],
            '5.50 (string)' => [
                455,
                95,
                550,
                '5.50',
            ],
            '5.30 (float)' => [
                438,
                92,
                530,
                5.30,
            ],
            '5.30 (string)' => [
                438,
                92,
                530,
                '5.30',
            ],
        ];
    }
}
