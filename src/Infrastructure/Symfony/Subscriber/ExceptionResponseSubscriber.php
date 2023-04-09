<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Symfony\Subscriber;

use rubenrubiob\Domain\Exception\Repository\NotFound;
use rubenrubiob\Domain\Exception\ValueObject\InvalidValueObject;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Throwable;

use function array_key_exists;
use function Safe\class_implements;

final readonly class ExceptionResponseSubscriber implements EventSubscriberInterface
{
    private const RESPONSE_CODE_MAP = [
        NotFound::class => Response::HTTP_NOT_FOUND,
        InvalidValueObject::class => Response::HTTP_BAD_REQUEST,
    ];

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::EXCEPTION => ['__invoke']];
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
        /** @var class-string[] $interfaces */
        $interfaces = class_implements($throwable);

        foreach ($interfaces as $interface) {
            if (array_key_exists($interface, self::RESPONSE_CODE_MAP)) {
                return self::RESPONSE_CODE_MAP[$interface];
            }
        }

        return Response::HTTP_INTERNAL_SERVER_ERROR;
    }
}
