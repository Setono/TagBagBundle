<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Exception;

class NonExistentTypeRendererException extends \RuntimeException
{
    public function __construct(string $requestedType, array $presentTypes = [])
    {
        parent::__construct(sprintf('A type renderer for the given type, %s, does not exist. Types available are: [%s]', $requestedType, implode(', ', $presentTypes)));
    }
}
