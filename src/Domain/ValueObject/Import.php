<?php

declare(strict_types=1);

namespace rubenrubiob\Domain\ValueObject;

use Brick\Math\BigDecimal;
use Brick\Math\Exception\NumberFormatException;
use Brick\Math\Exception\RoundingNecessaryException;
use Brick\Math\RoundingMode;
use Brick\Money\Exception\UnknownCurrencyException;
use Brick\Money\Money;
use rubenrubiob\Domain\Exception\ValueObject\ImportIsNotValid;

use function strtoupper;

final readonly class Import
{
    private function __construct(
        private int $preuNet,
        private PercentatgeImpostos $percentatgeImpostos,
        private int $quantitatImpostos,
        private int $preuFinal,
        private string $moneda,
    ) {
    }

    /**
     * @throws ImportIsNotValid
     */
    public static function ambPreuFinalAmbPercentatgeImpostos(
        float|int|string $preuFinal,
        PercentatgeImpostos $percentatgeImpostos,
        string $moneda,
    ): self {
        $preuFinalAsMoney = self::parseAndGetMoney($preuFinal, $moneda);

        $preuNet = $preuFinalAsMoney->dividedBy(
            self::getValorImpostos($percentatgeImpostos),
            RoundingMode::HALF_UP,
        );

        $quantitatImpostos = $preuFinalAsMoney->minus($preuNet);

        return new self(
            $preuNet->getMinorAmount()->toInt(),
            $percentatgeImpostos,
            $quantitatImpostos->getMinorAmount()->toInt(),
            $preuFinalAsMoney->getMinorAmount()->toInt(),
            $preuFinalAsMoney->getCurrency()->getCurrencyCode(),
        );
    }

    public function preuNetMinor(): int
    {
        return $this->preuNet;
    }

    public function percentatgeImpostos(): PercentatgeImpostos
    {
        return $this->percentatgeImpostos;
    }

    public function quantitatImpostosMinor(): int
    {
        return $this->quantitatImpostos;
    }

    public function preuFinalMinor(): int
    {
        return $this->preuFinal;
    }

    public function moneda(): string
    {
        return $this->moneda;
    }

    /** @throws ImportIsNotValid */
    private static function parseAndGetMoney(float|int|string $quantitat, string $moneda): Money
    {
        try {
            return Money::of($quantitat, strtoupper($moneda), null, RoundingMode::HALF_UP);
        } catch (NumberFormatException | UnknownCurrencyException) {
            throw ImportIsNotValid::ambPreuFinal($quantitat, $moneda);
        }
    }

    private static function getValorImpostos(PercentatgeImpostos $percentatgeImpostos): BigDecimal
    {
        $percentatgeImpososAsBigDecimal = BigDecimal::of($percentatgeImpostos->value);

        return $percentatgeImpososAsBigDecimal
            ->dividedBy(100, RoundingMode::HALF_UP)
            ->plus(1);
    }
}
