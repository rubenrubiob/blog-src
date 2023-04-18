<?php

declare(strict_types=1);

namespace rubenrubiob\Tests\Common\Validation\OpenApi;

use League\OpenAPIValidation\PSR7\Exception\Validation\AddressValidationFailed;
use League\OpenAPIValidation\PSR7\Exception\ValidationFailed;
use League\OpenAPIValidation\PSR7\OperationAddress;
use League\OpenAPIValidation\PSR7\ResponseValidator;
use League\OpenAPIValidation\PSR7\ValidatorBuilder;
use Nyholm\Psr7\Factory\Psr17Factory;
use Symfony\Bridge\PsrHttpMessage\Factory\PsrHttpFactory;
use Symfony\Component\HttpFoundation\Response;

use function strtolower;

final readonly class OpenApiResponseAssert
{
    private PsrHttpFactory $psrHttpFactory;
    private ResponseValidator $validator;

    public function __construct()
    {
        $psr17Factory = new Psr17Factory();
        $this->psrHttpFactory = new PsrHttpFactory($psr17Factory, $psr17Factory, $psr17Factory, $psr17Factory);
        $this->validator = (new ValidatorBuilder())
            ->fromYamlFile(__DIR__ . '/../../../../specs/reference/blog-src.yaml')
            ->getResponseValidator();
    }

    /** @throws ValidationFailed */
    public function __invoke(Response $response, string $route, string $method): void
    {
        $psrResponse = $this->psrHttpFactory->createResponse($response);
        $operation = new OperationAddress($route, strtolower($method));

        try {
            $this->validator->validate($operation, $psrResponse);
        } catch (AddressValidationFailed $e) {
            $class = $e::class;

            throw new $class(
                $e->getVerboseMessage(),
                $e->getCode(),
                $e,
            );
        }
    }
}
