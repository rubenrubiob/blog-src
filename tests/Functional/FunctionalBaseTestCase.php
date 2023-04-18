<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Functional;

use rubenrubiob\Tests\Common\Validation\OpenApi\OpenApiResponseAssert;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

abstract class FunctionalBaseTestCase extends WebTestCase
{
    protected readonly KernelBrowser $client;
    protected readonly OpenApiResponseAssert $openApiResponseAssert;

    protected function setUp(): void
    {
        parent::setUp();

        $this->client = static::createClient();
        $this->openApiResponseAssert = new OpenApiResponseAssert();
    }
}
