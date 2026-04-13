<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;
use Twig\Extension\RuntimeExtensionInterface;

final readonly class Runtime implements RuntimeExtensionInterface
{
    public function __construct(private TagBagInterface $tagBag)
    {
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
