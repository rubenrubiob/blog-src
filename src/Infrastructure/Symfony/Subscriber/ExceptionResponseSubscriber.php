<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Symfony\Subscriber;

use InvalidArgumentException;
use rubenrubiob\Domain\Exception\Repository\NotFound;
use rubenrubiob\Domain\Exception\ValueObject\InvalidValueObject;
use rubenrubiob\Infrastructure\Symfony\Http\Exception\InvalidRequest;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

use function array_key_exists;
use function Safe\class_implements;

final readonly class ExceptionResponseSubscriber implements EventSubscriberInterface
{
    private const EXCEPTION_CONCRETE_HTTP_CODE_MAP = [
        InvalidRequest::class => Response::HTTP_BAD_REQUEST,
    ];

    private const EXCEPTION_INTERFACE_RESPONSE_HTTP_CODE_MAP = [
        NotFound::class => Response::HTTP_NOT_FOUND,
        InvalidValueObject::class => Response::HTTP_BAD_REQUEST,
    ];

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => '__invoke'];
    }

    public function __invoke(ExceptionEvent $event): void
    {
        $throwable = $event->getThrowable();

        $response = new JsonResponse(
            [
                'error' => $throwable->getMessage(),
            ],
            $this->httpCode($throwable),
            [
                'Content-Type' => 'application/json',
            ]
        );

        $event->setResponse($response);
    }

    private function httpCode(Throwable $throwable): int
    {
        try {
            return $this->httpCodeFromSymfonyHttpException($throwable);
        } catch (InvalidArgumentException) {
        }

        try {
            return $this->httpCodeFromConcreteException($throwable);
        } catch (InvalidArgumentException) {
        }

        try {
            return $this->httpCodeFromInterfaceException($throwable);
        } catch (InvalidArgumentException) {
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }

    /** @throws InvalidArgumentException */
    private function httpCodeFromSymfonyHttpException(Throwable $exception): int
    {
        if ($exception instanceof HttpExceptionInterface) {
            return $exception->getStatusCode();
        }

        throw new InvalidArgumentException();
    }

    /** @throws InvalidArgumentException */
    private function httpCodeFromConcreteException(Throwable $exception): int
    {
        $exceptionClassName = $exception::class;

        if (array_key_exists($exceptionClassName, self::EXCEPTION_CONCRETE_HTTP_CODE_MAP)) {
            return self::EXCEPTION_CONCRETE_HTTP_CODE_MAP[$exceptionClassName];
        }

        throw new InvalidArgumentException();
    }

    /** @throws InvalidArgumentException */
    private function httpCodeFromInterfaceException(Throwable $exception): int
    {
        /** @var class-string[] $interfaces */
        $interfaces = class_implements($exception);

        foreach ($interfaces as $interface) {
            if (array_key_exists($interface, self::EXCEPTION_INTERFACE_RESPONSE_HTTP_CODE_MAP)) {
                return self::EXCEPTION_INTERFACE_RESPONSE_HTTP_CODE_MAP[$interface];
            }
        }

        throw new InvalidArgumentException();
    }
}
