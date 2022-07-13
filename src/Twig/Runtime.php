<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

final class Runtime implements RuntimeExtensionInterface
{
    private TagBagInterface $tagBag;

    public function __construct(TagBagInterface $tagBag)
    {
        $this->tagBag = $tagBag;
    }

    public function renderAll(): string
    {
        return $this->tagBag->renderAll();
    }

    public function renderSection(string $section): string
    {
        return $this->tagBag->renderSection($section);
    }

    public function renderHead(): string
    {
        return $this->renderSection(TagInterface::SECTION_HEAD);
    }

    public function renderBodyBegin(): string
    {
        return $this->renderSection(TagInterface::SECTION_BODY_BEGIN);
    }

    public function renderBodyEnd(): string
    {
        return $this->renderSection(TagInterface::SECTION_BODY_END);
    }
}
