<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Symfony\Subscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Serializer\SerializerInterface;

final readonly class ViewResponseSubscriber implements EventSubscriberInterface
{
    private const HEADERS = ['Content-Type' => 'application/json'];
    private const FORMAT = 'json';

    public function __construct(
        private SerializerInterface $serializer
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [KernelEvents::VIEW => '__invoke'];
    }

    public function __invoke(ViewEvent $event): void
    {
        $controllerResult = $event->getControllerResult();

        $response = new Response(
            $this->serializer->serialize(
                $controllerResult,
                self::FORMAT,
            ),
            Response::HTTP_OK,
            self::HEADERS,
        );

        $event->setResponse($response);
    }
}
