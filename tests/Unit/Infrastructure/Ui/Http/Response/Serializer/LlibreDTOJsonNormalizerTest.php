<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Ui\Http\Response\Serializer;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\Ui\Http\Response\Presenter\LlibreDTOPresenter;
use rubenrubiob\Infrastructure\Ui\Http\Response\Serializer\LlibreDTOJsonNormalizer;
use rubenrubiob\Tests\Common\Generator\Llibre\LlibreDTOGenerator;

final class LlibreDTOJsonNormalizerTest extends TestCase
{
    private const FORMAT_JSON = 'json';
    private const FORMAT_XML = 'xml';

    private readonly LlibreDTO $llibreDTO;
    private readonly LlibreDTOPresenter $presenter;
    private readonly LlibreDTOJsonNormalizer $normalizer;

    protected function setUp(): void
    {
        $this->llibreDTO = LlibreDTOGenerator::one();
        $this->presenter = new LlibreDTOPresenter();

        $this->normalizer = new LlibreDTOJsonNormalizer(
            $this->presenter
        );
    }

    public function test_that_supportsNormalization_returns_expected_value(): void
    {
        self::assertFalse(
            $this->normalizer->supportsNormalization('foo', self::FORMAT_XML),
        );
        self::assertFalse(
            $this->normalizer->supportsNormalization('foo', self::FORMAT_JSON),
        );
        self::assertFalse(
            $this->normalizer->supportsNormalization($this->llibreDTO, self::FORMAT_XML),
        );
        self::assertTrue(
            $this->normalizer->supportsNormalization($this->llibreDTO, self::FORMAT_JSON),
        );
    }

    public function test_that_normalize_returns_expected_response(): void
    {
        self::assertEquals(
            $this->presenter->__invoke($this->llibreDTO),
            $this->normalizer->normalize($this->llibreDTO, self::FORMAT_JSON),
        );
    }
}
