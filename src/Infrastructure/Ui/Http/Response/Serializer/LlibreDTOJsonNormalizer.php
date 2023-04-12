<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Ui\Http\Response\Serializer;

use rubenrubiob\Domain\DTO\Llibre\LlibreDTO;
use rubenrubiob\Infrastructure\Ui\Http\Response\Presenter\LlibreDTOPresenter;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;

use function assert;

final readonly class LlibreDTOJsonNormalizer implements ContextAwareNormalizerInterface
{
    private const FORMAT = 'json';

    public function __construct(
        private LlibreDTOPresenter $presenter
    ) {
    }

    /** @param array<array-key, mixed> $context */
    public function supportsNormalization(mixed $data, string $format = null, array $context = [])
    {
        return $format === self::FORMAT
            && $data instanceof LlibreDTO;
    }

    /**
     * @param array<array-key, mixed> $context
     *
     * @return array{
     *     'id': non-empty-string,
     *     'titol': non-empty-string,
     *     'autor': non-empty-string
     * }
     */
    public function normalize(mixed $object, string $format = null, array $context = []): array
    {
        assert($object instanceof LlibreDTO);

        return $this->presenter->__invoke($object);
    }
}
