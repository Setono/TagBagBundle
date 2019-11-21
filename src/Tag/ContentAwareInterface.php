<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

interface ContentAwareInterface
{
    /**
     * Will return the tag contents.
     */
    public function getContent(): string;
}
