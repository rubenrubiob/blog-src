<?php

declare(strict_types=1);

namespace rubenrubiob\Infrastructure\Symfony\Http\Exception;

use Exception;
use Symfony\Component\Validator\ConstraintViolationListInterface;

use function sprintf;

final class InvalidRequest extends Exception
{
    public static function fromConstraintViolationList(ConstraintViolationListInterface $errors): self
    {
        if (!$errors->has(0)) {
            return new self('Error in request');
        }

        $firstError = $errors->get(0);

        return new self(
            sprintf(
                '%s: %s',
                $firstError->getPropertyPath(),
                (string) $firstError->getMessage()
            )
        );
    }

    public static function createFromBadMapping(): self
    {
        return new self('Error in mapping');
    }
}
