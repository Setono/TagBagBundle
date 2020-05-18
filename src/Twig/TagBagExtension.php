<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TagBagExtension extends AbstractExtension
{
    /** @var TagBagInterface */
    private $tagBag;

    public function __construct(TagBagInterface $tagBag)
    {
        $this->tagBag = $tagBag;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setono_tag_bag_render_all', [$this, 'renderAll'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_section', [$this, 'renderSection'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_head', [$this, 'renderHead'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_body_begin', [$this, 'renderBodyBegin'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_render_body_end', [$this, 'renderBodyEnd'], ['is_safe' => ['html']]),
        ];
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
