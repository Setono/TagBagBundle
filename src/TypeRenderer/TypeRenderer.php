<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

use Setono\TagBagBundle\Collection\TagCollectionInterface;

abstract class TypeRenderer implements TypeRendererInterface
{
    /**
     * @param TagCollectionInterface $tags
     * @param string|null            $wrapper The HTML tag to wrap the tags in, i.e. <script>
     *
     * @return string
     */
    protected function renderWithWrapper(TagCollectionInterface $tags, ?string $wrapper): string
    {
        $str = '';

        if (null !== $wrapper) {
            $str = $wrapper;
        }

        $str .= implode($tags->toArray());

        if (null !== $wrapper) {
            $wrapper = '</'.substr($wrapper, 1);
            $str .= preg_replace('/ [^>]+/', '', $wrapper);
        }

        return $str;
    }
}
