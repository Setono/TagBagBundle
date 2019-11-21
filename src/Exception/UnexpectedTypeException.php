<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Exception;

use function get_class;
use function gettype;
use InvalidArgumentException;
use function is_object;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;

final class UnexpectedTypeException extends InvalidArgumentException
{
    /**
     * @param mixed $value
     *
     * @throws StringsException
     */
    public function __construct($value, string $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type %s, %s given', $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
