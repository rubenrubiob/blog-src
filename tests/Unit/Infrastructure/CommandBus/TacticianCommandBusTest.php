<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\CommandBus;

use League\Tactician\CommandBus as LeagueTacticianCommandBus;
use League\Tactician\Middleware;
use PHPUnit\Framework\TestCase;
use rubenrubiob\Infrastructure\CommandBus\TacticianCommandBus;

final class TacticianCommandBusTest extends TestCase
{
    public function test_that_command_is_handled(): void
    {
        $middleware = $this->middleware();

        $leagueTacticianCommandBus = new LeagueTacticianCommandBus([$middleware]);
        $tacticianCommandBus       = new TacticianCommandBus($leagueTacticianCommandBus);

        $command = new class (){
        };

        $tacticianCommandBus->__invoke($command);

        self::assertTrue($middleware->called);
    }

    private function middleware(): Middleware
    {
        return new class () implements Middleware {
            public bool $called = false;

            public function execute($command, callable $next): mixed
            {
                $this->called = true;

                return $next($command);
            }
        };
    }
}
