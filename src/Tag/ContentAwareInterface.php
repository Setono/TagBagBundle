<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

interface ContentAwareInterface
{
    /**
     * Will return the tag contents.
     *
     * @return string
     */
    public function getContent(): string;
}
