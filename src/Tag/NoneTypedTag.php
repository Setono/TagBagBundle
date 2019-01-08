<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

final class NoneTypedTag extends TypedTag
{
    public function __construct(string $tag)
    {
        parent::__construct($tag, TagInterface::TYPE_NONE);
    }
}
