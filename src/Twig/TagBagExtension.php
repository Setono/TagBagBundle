<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class TagBagExtension extends AbstractExtension
{
    /**
     * @var TagBagInterface
     */
    private $tagBag;

    public function __construct(TagBagInterface $tagBag)
    {
        $this->tagBag = $tagBag;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('setono_tag_bag_tags', [$this, 'tags'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_head_tags', [$this, 'headTags'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_body_begin_tags', [$this, 'bodyBeginTags'], ['is_safe' => ['html']]),
            new TwigFunction('setono_tag_bag_body_end_tags', [$this, 'bodyEndTags'], ['is_safe' => ['html']]),
        ];
    }

    /**
     * Returns some or all the existing tags:
     *  * tags() returns all the tags
     *  * tags('section') returns the tags for that section
     *  * tags(['section1', 'section2']) returns the tags for those sections.
     *
     * @param null|array|string $sections
     *
     * @return string
     */
    public function tags($sections = null): string
    {
        if (null === $sections || '' === $sections || [] === $sections) {
            return $this->renderSections($this->tagBag->all());
        }

        if (\is_string($sections)) {
            return $this->renderSections([$sections => $this->tagBag->getSection($sections)]);
        }

        $result = [];
        foreach ($sections as $section) {
            $result[$section] = $this->tagBag->getSection($section);
        }

        return $this->renderSections($result);
    }

    public function headTags(): string
    {
        return $this->tags(TagBagInterface::SECTION_HEAD);
    }

    public function bodyBeginTags(): string
    {
        return $this->tags(TagBagInterface::SECTION_BODY_BEGIN);
    }

    public function bodyEndTags(): string
    {
        return $this->tags(TagBagInterface::SECTION_BODY_END);
    }

    private function renderSections(array $sections): string
    {
        $str = '';

        foreach ($sections as $section) {
            $str .= implode('', $section);
        }

        return $str;
    }
}
