<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Ui\Http\Response\Presenter;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Domain\ValueObject\Llibre\AutorNom;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreId;
use rubenrubiob\Domain\ValueObject\Llibre\LlibreTitol;
use rubenrubiob\Infrastructure\Ui\Http\Response\Presenter\LlibreDTOPresenter;
use rubenrubiob\Tests\Common\Generator\Llibre\LlibreDTOGenerator;

final class LlibreDTOPresenterTest extends TestCase
{
    private const ID = '132deb5e-f75b-465c-91f8-4c55d40e025a';
    private const TITOL = 'Crim i càstig';
    private const AUTOR = 'Dostoievski';

    private readonly LlibreDTOPresenter $presenter;

    protected function setUp(): void
    {
        $this->presenter = new LlibreDTOPresenter();
    }

    public function test_that_LlibreDTO_is_correctly_presented(): void
    {
        $llibreDTO = LlibreDTOGenerator::one(
            llibreId: self::ID,
            llibreTitol: self::TITOL,
            autorNom: self::AUTOR,
        );

        $expectedPresentation = [
            'id' => self::ID,
            'titol' => self::TITOL,
            'autor' => self::AUTOR,
        ];

        self::assertEquals(
            $expectedPresentation,
            $this->presenter->__invoke($llibreDTO),
        );
    }
}
