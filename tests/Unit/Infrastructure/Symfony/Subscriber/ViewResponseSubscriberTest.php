<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Symfony\Subscriber;

use PHPUnit\Framework\TestCase;
use rubenrubiob\Infrastructure\Symfony\Kernel;
use rubenrubiob\Infrastructure\Symfony\Subscriber\ViewResponseSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Serializer;

use function Safe\json_encode;

final class ViewResponseSubscriberTest extends TestCase
{
    private const CONTENT_TYPE = 'application/json';
    private const CONTROLLER_RESULT = ['foo'];
    private readonly ViewResponseSubscriber $subscriber;

    protected function setUp(): void
    {
        $this->subscriber = new ViewResponseSubscriber(
            new Serializer(
                [],
                [new JsonEncoder()]
            )
        );
    }

    public function test_that_getSubscribedEvents_only_returns_kernel_exception(): void
    {
        self::assertSame(
            [KernelEvents::VIEW => '__invoke'],
            $this->subscriber::getSubscribedEvents(),
        );
    }

    public function test_that_subscriber_sets_correct_response(): void
    {
        $event = new ViewEvent(
            $this->getKernel(),
            $this->request(),
            HttpKernelInterface::MAIN_REQUEST,
            self::CONTROLLER_RESULT,
        );

        self::assertNull($event->getResponse());

        $this->subscriber->__invoke($event);

        $response = $event->getResponse();

        self::assertInstanceOf(Response::class, $response);
        self::assertSame(Response::HTTP_OK, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            json_encode(self::CONTROLLER_RESULT),
            $response->getContent()
        );
        self::assertSame(
            self::CONTENT_TYPE,
            $response->headers->get('content-type')
        );
    }

    private function getKernel(): KernelInterface
    {
        return new Kernel('test', true);
    }

    private function request(): Request
    {
        return new Request();
    }
}
