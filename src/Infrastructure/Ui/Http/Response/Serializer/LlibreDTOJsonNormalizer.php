<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Response\Serializer;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\Ui\Http\Response\Presenter\LlibreDTOPresenter;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

final readonly class LlibreDTOJsonNormalizer implements ContextAwareNormalizerInterface
{
    private const FORMAT = 'json';

    public function __construct(
        private LlibreDTOPresenter $presenter
    ) {
    }

    public function supportsNormalization($data, string $format = null, array $context = [])
    {
        return $format === self::FORMAT
            && $data instanceof LlibreDTO;
    }

    public function normalize($object, string $format = null, array $context = [])
    {
        return $this->presenter->__invoke($object);
    }
}
