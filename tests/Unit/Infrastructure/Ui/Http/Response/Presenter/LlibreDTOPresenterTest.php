<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Ui\Http\Response\Presenter;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;
use rubenrubiob\Infrastructure\Ui\Http\Response\Presenter\LlibreDTOPresenter;

final class LlibreDTOPresenterTest extends TestCase
{
    private const ID = '24455e19-e74e-4600-9c7b-7abefda5bac6';
    private const TITOL = 'Odissea';
    private const AUTOR = 'Homer';

    private readonly LlibreDTOPresenter $presenter;

    protected function setUp(): void
    {
        $this->presenter = new LlibreDTOPresenter();
    }

    public function test_that_LlibreDTO_is_correctly_presented(): void
    {
        $expectedPresentation = [
            'id' => self::ID,
            'titol' => self::TITOL,
            'autor' => self::AUTOR,
        ];

        $llibreDTO = new LlibreDTO(
            LlibreId::fromString(self::ID),
            LlibreTitol::create(self::TITOL),
            AutorNom::create(self::AUTOR),
        );

        self::assertEquals(
            $expectedPresentation,
            $this->presenter->__invoke($llibreDTO),
        );
    }
}
