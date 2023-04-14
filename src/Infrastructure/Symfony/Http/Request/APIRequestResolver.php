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
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;
use Symfony\Component\Validator\Validator\ValidatorInterface;

use function count;

final readonly class APIRequestResolver implements ArgumentValueResolverInterface
{
    public function __construct(
        private TreeMapper $treeMapper,
        private ValidatorInterface $validator,
    ) {
    }

    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        /** @var class-string|null $className */
        $className = $argument->getType();

        if ($className === null) {
            return false;
        }

        try {
            $reflection = new ReflectionClass($className);

            if ($reflection->implementsInterface(APIRequestBody::class)) {
                return true;
            }
        } catch (ReflectionException) {
        }

        return false;
    }

    /**
     * @return iterable<APIRequestBody>|iterable<null>
     *
     * @throws InvalidRequest
     */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        /** @var class-string<APIRequestBody>|null $class */
        $class = $argument->getType();

        if ($class === null) {
            yield null;

            return;
        }

        try {
            $request = $this->treeMapper->map(
                $class,
                Source::json((string) $request->getContent())->camelCaseKeys(),
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
}
