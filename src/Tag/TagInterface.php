<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

interface TagInterface
{
    public const TYPE_HTML = 'html';
    public const TYPE_SCRIPT = 'script';
    public const TYPE_STYLE = 'style';

    /**
     * Will return the type of the tag.
     *
     * @return string
     */
    public function getType(): string;
}
