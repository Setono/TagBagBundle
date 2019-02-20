<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

abstract class Renderer implements RendererInterface
{
    /**
     * @param string      $tag
     * @param string|null $wrapper The HTML tag to wrap the tags in, i.e. <script>
     *
     * @return string
     */
    protected function renderWithWrapper(string $tag, ?string $wrapper): string
    {
        $str = '';

        if (null !== $wrapper) {
            $str = $wrapper;
        }

        $str .= $tag;

        if (null !== $wrapper) {
            $wrapper = '</'.substr($wrapper, 1);
            $str .= preg_replace('/ [^>]+/', '', $wrapper);
        }

        return $str;
    }
}
