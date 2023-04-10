<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Unit\Infrastructure\QueryBus;

use League\Tactician\CommandBus as LeagueTacticianCommandBus;
use League\Tactician\Middleware;
use PHPUnit\Framework\TestCase;
use rubenrubiob\Infrastructure\QueryBus\TacticianQueryBus;

final class TacticianQueryBusTest extends TestCase
{
    public function test_that_query_is_handled(): void
    {
        $middleware = $this->middleware();

        $leagueTacticianQueryBus = new LeagueTacticianCommandBus([$middleware]);
        $tacticianQueryBus       = new TacticianQueryBus($leagueTacticianQueryBus);

        $query = new class () {
        };

        self::assertSame(
            'query bus called',
            $tacticianQueryBus->__invoke($query),
        );
    }

    private function middleware(): Middleware
    {
        return new class () implements Middleware {
            public function execute($command, callable $next): mixed
            {
                return 'query bus called';
            }
        };
    }
}
