<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

interface TagInterface
{
    public const TYPE_NONE = 'none';
    public const TYPE_SCRIPT = 'script';
    public const TYPE_STYLE = 'style';

    /**
     * Will return the type of the tag.
     *
     * @return string
     */
    public function getType(): string;

    /**
     * Will return this tag represented as a string
     * This is the string that will be output onto your page.
     *
     * @return string
     */
    public function __toString(): string;
}
