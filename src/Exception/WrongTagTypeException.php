<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Exception;

use Setono\TagBagBundle\Tag\TagInterface;

class WrongTagTypeException extends \RuntimeException
{
    public function __construct(TagInterface $tag, string $expectedType)
    {
        parent::__construct(sprintf('The tag %s has type %s, but %s was expected', get_class($tag), $tag->getType(), $expectedType));
    }
}
