<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

interface TagInterface
{
    public function __toString(): string;
}
