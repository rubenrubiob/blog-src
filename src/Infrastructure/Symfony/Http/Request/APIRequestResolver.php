<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Symfony\Http\Request;

use CuyZ\Valinor\Mapper\MappingError;
use CuyZ\Valinor\Mapper\Source\Source;
use CuyZ\Valinor\Mapper\TreeMapper;
use ReflectionClass;
use ReflectionException;
use rubenrubiob\Infrastructure\Symfony\Http\Exception\InvalidRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

final readonly class APIRequestResolver implements ValueResolverInterface
{
    public function __construct(
        private TreeMapper $treeMapper,
        private ValidatorInterface $validator,
    ) {
    }

    /**
     * @return iterable<APIRequestBody>|iterable<null>
     *
     * @throws InvalidRequest
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var class-string|null $class */
        $class = $argument->getType();

        if (! $this->supports($class)) {
            return [null];
        }

        try {
            $request = $this->treeMapper->map(
                $class,
                Source::json($request->getContent())->camelCaseKeys(),
            );
        } catch (MappingError) {
            throw InvalidRequest::createFromBadMapping();
        }

        $errors = $this->validator->validate($request);

        if (count($errors) > 0) {
            throw InvalidRequest::fromConstraintViolationList($errors);
        }

        yield $request;
    }

    /**
     * @param class-string|null $class
     *
     * @psalm-assert-if-true class-string<APIRequestBody> $class
     * @phpstan-assert-if-true class-string<APIRequestBody> $class
     */
    private function supports(?string $class): bool
    {
        if ($class === null) {
            return false;
        }

        try {
            $reflection = new ReflectionClass($class);

            if ($reflection->implementsInterface(APIRequestBody::class)) {
                return true;
            }
        } catch (ReflectionException) {
        }

        return false;
    }
}
