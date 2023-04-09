<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\Symfony\Subscriber;

use Exception;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use rubenrubiob\Domain\Exception\Repository\NotFound;
use rubenrubiob\Domain\Exception\ValueObject\InvalidValueObject;
use rubenrubiob\Infrastructure\Symfony\Kernel;
use rubenrubiob\Infrastructure\Symfony\Subscriber\ExceptionResponseSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\KernelInterface;
use Throwable;

use function Safe\json_encode;

final class ExceptionResponseSubscriberTest extends TestCase
{
    private const EXCEPTION_MESSAGE = 'Exception message';
    private const CONTENT_TYPE = 'application/json';

    private readonly ExceptionResponseSubscriber $subscriber;

    protected function setUp(): void
    {
        $this->subscriber = new ExceptionResponseSubscriber();
    }

    public function test_that_getSubscribedEvents_only_returns_kernel_exception(): void
    {
        self::assertSame(
            [KernelEvents::EXCEPTION => '__invoke'],
            ExceptionResponseSubscriber::getSubscribedEvents()
        );
    }

    #[DataProvider('throwableWithCodeProvider')]
    public function test_that_response_is_correctly_set(
        int $expectedHttpCode,
        Throwable $throwable
    ): void {
        $exceptionEvent = new ExceptionEvent(
            $this->getKernel(),
            $this->request(),
            HttpKernelInterface::MAIN_REQUEST,
            $throwable,
        );

        $expectedResponseContent = json_encode(
            [
                'error' => self::EXCEPTION_MESSAGE,
            ],
        );

        $this->subscriber->__invoke($exceptionEvent);

        $response = $exceptionEvent->getResponse();

        self::assertInstanceOf(Response::class, $response);
        self::assertSame($expectedHttpCode, $response->getStatusCode());
        self::assertJsonStringEqualsJsonString(
            $expectedResponseContent,
            $response->getContent()
        );
        self::assertSame(
            self::CONTENT_TYPE,
            $response->headers->get('content-type')
        );
    }

    public static function throwableWithCodeProvider(): array
    {
        return [
            'NotFound' => [
                Response::HTTP_NOT_FOUND,
                new class (self::EXCEPTION_MESSAGE) extends Exception implements NotFound {},
            ],
            'InvalidValueObject' => [
                Response::HTTP_BAD_REQUEST,
                new class (self::EXCEPTION_MESSAGE) extends Exception implements InvalidValueObject {},
            ],
        ];
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
