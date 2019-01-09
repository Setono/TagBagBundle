<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

use Setono\TagBagBundle\Tag\TagInterface;

final class StyleTypeRenderer extends TypeRenderer
{
    public function render(array $tags): string
    {
        return $this->renderWithWrapper($tags, '<style>');
    }

    public function supports(string $type): bool
    {
        return TagInterface::TYPE_STYLE === $type;
    }
}
