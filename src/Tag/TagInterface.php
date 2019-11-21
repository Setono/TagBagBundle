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
     */
    public function getType(): string;

    /**
     * Returns the key for this tag.
     * This is used as a key for each tag in a given section which in turn
     * means that you can't add multiple tags with the same key in a given section.
     */
    public function getKey(): string;
}
