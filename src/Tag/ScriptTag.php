<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

final class ScriptTag extends ContentTag
{
    public function __construct(string $content)
    {
        parent::__construct($content, TagInterface::TYPE_SCRIPT);
    }
}
