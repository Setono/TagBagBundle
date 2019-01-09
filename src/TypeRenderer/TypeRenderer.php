<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

abstract class TypeRenderer implements TypeRendererInterface
{
    /**
     * @param array       $tags
     * @param string|null $wrapper The HTML tag to wrap the tags in, i.e. <script>
     *
     * @return string
     */
    protected function renderWithWrapper(array $tags, ?string $wrapper): string
    {
        $str = '';

        if (null !== $wrapper) {
            $str = $wrapper;
        }

        $str .= implode($tags);

        if (null !== $wrapper) {
            $wrapper = '</'.substr($wrapper, 1);
            $str .= preg_replace('/ [^>]+/', '', $wrapper);
        }

        return $str;
    }
}
