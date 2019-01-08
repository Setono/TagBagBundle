<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBagInterface;
use Setono\TagBagBundle\Collection\TagCollectionInterface;
use Setono\TagBagBundle\TypeRenderer\TypeRendererInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TagBagExtension extends AbstractExtension
{
    /**
     * @var TypeRendererInterface
     */
    private $typeRenderer;

    /**
     * @var RequestStack|null
     */
    private $requestStack;

    public function __construct(TypeRendererInterface $typeRenderer, ?RequestStack $requestStack)
    {
        $this->typeRenderer = $typeRenderer;
        $this->requestStack = $requestStack;
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('tags', [$this, 'tags'], ['is_safe' => ['html']]),
            new TwigFunction('head_tags', [$this, 'headTags'], ['is_safe' => ['html']]),
            new TwigFunction('body_begin_tags', [$this, 'bodyBeginTags'], ['is_safe' => ['html']]),
            new TwigFunction('body_end_tags', [$this, 'bodyEndTags'], ['is_safe' => ['html']]),
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
        $tagBag = $this->getTagBag();
        if (null === $tagBag) {
            return '';
        }

        if (null === $sections || '' === $sections || [] === $sections) {
            return $this->sectionsToString($tagBag->all());
        }

        if (\is_string($sections)) {
            return $this->sectionsToString([$tagBag->get($sections)]);
        }

        $result = [];
        foreach ($sections as $section) {
            $result[$section] = $tagBag->get($section);
        }

        return $this->sectionsToString($result);
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

    private function sectionsToString(array $sections): string
    {
        $res = '';

        foreach ($sections as $section) {
            /** @var TagCollectionInterface $type */
            foreach ($section as $type) {
                if (!$this->typeRenderer->supports($type->getType())) {
                    continue;
                }

                $res .= $this->typeRenderer->render($type);
            }
        }

        return $res;
    }

    private function getTagBag(): ?TagBagInterface
    {
        if (null === $this->requestStack) {
            return null;
        }

        $request = $this->requestStack->getCurrentRequest();

        if (null === $request) {
            return null;
        }

        $session = $request->getSession();

        if (null === $session) {
            return null;
        }

        /** @var TagBagInterface $tagBag */
        $tagBag = $session->getBag('tags');

        return $tagBag;
    }
}
