<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

use Setono\TagBagBundle\Tag\TagInterface;

final class NoneTypeRenderer extends TypeRenderer
{
    public function render(array $tags): string
    {
        return $this->renderWithWrapper($tags, null);
    }

    public function supports(string $type): bool
    {
        return TagInterface::TYPE_NONE === $type;
    }
}
