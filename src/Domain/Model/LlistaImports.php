<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\Model;

use Brick\Money\Currency;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\ISOCurrencyProvider;
use Brick\Money\Money;
use rubenrubiob\Domain\Exception\Model\LlistaImportsMonedaNoCoincideix;
use rubenrubiob\Domain\Exception\Model\LlistaImportsMonedaNoValida;
use rubenrubiob\Domain\ValueObject\Import;

use function strtoupper;

final class LlistaImports
{
    /** @var list<Import> */
    private array $imports = [];

    private Money $totalPreusNets;
    private Money $totalImpostos;
    private Money $total;

    private function __construct(
        private readonly Currency $moneda,
    ) {
        $this->totalPreusNets = Money::zero($this->moneda);
        $this->totalImpostos  = Money::zero($this->moneda);
        $this->total          = Money::zero($this->moneda);
    }

    /** @throws LlistaImportsMonedaNoValida */
    public static function ambMoneda(string $moneda): self
    {
        return new self(
            self::parseAndValidateMoneda($moneda),
        );
    }

    /** @throws LlistaImportsMonedaNoCoincideix */
    public function afegirImport(Import $import): void
    {
        $this->validarMonedesCoincideixen($import);

        $this->imports[] = $import;

        $this->totalPreusNets = $this->totalPreusNets->plus(
            $import->preuNetAsMoney(),
        );

        $this->totalImpostos = $this->totalImpostos->plus(
            $import->quantitatImpostosAsMoney(),
        );

        $this->total = $this->total->plus(
            $import->preuFinalAsMoney(),
        );
    }

    public function totalPreusNetsMinor(): int
    {
        return $this->totalPreusNets->getMinorAmount()->toInt();
    }

    public function totalImpostosMinor(): int
    {
        return $this->totalImpostos->getMinorAmount()->toInt();
    }

    public function totalMinor(): int
    {
        return $this->total->getMinorAmount()->toInt();
    }

    /** @return list<Import> */
    public function imports(): array
    {
        return $this->imports;
    }

    /** @throws LlistaImportsMonedaNoValida */
    private static function parseAndValidateMoneda(string $moneda): Currency
    {
        try {
            return ISOCurrencyProvider::getInstance()->getCurrency(strtoupper($moneda));
        } catch (UnknownCurrencyException) {
            throw LlistaImportsMonedaNoValida::perAConstruir($moneda);
        }
    }

    /** @throws LlistaImportsMonedaNoCoincideix */
    private function validarMonedesCoincideixen(Import $import): void
    {
        if ($import->moneda() !== $this->moneda->getCurrencyCode()) {
            throw LlistaImportsMonedaNoCoincideix::perALlistaAmbMoneda(
                $this->moneda->getCurrencyCode(),
                $import->moneda(),
            );
        }
    }
}
