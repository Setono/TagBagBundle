<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

use Setono\TagBagBundle\Tag\TagInterface;

final class ScriptTypeRenderer extends TypeRenderer
{
    public function render(array $tags): string
    {
        return $this->renderWithWrapper($tags, '<script>');
    }

    public function supports(string $type): bool
    {
        return TagInterface::TYPE_SCRIPT === $type;
    }
}
