<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Exception;

class ExistingTypeRendererException extends \RuntimeException
{
    public function __construct(string $type)
    {
        parent::__construct(sprintf('A type renderer of the type %s already exists', $type));
    }
}
