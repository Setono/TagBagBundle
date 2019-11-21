<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Exception;

use InvalidArgumentException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\TagBagBundle\Tag\TagInterface;

final class UnsupportedTagException extends InvalidArgumentException
{
    /**
     * @throws StringsException
     */
    public function __construct(TagInterface $tag)
    {
        parent::__construct(sprintf('The tag %s is not supported', get_class($tag)));
    }
}
