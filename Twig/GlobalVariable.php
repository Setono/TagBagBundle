<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBagInterface;
use Symfony\Component\HttpFoundation\RequestStack;

class GlobalVariable
{
    /**
     * @var RequestStack|null
     */
    private $requestStack;

    public function __construct(?RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    /**
     * Returns some or all the existing tags:
     *  * getTags() returns all the flash messages
     *  * getTags('section') returns a simple array with tags for that section
     *  * getTags(['section1', 'section2']) returns a nested array of section => tags.
     *
     * @param mixed $sections
     * @return array
     */
    public function getTags($sections = null): array
    {
        $tagBag = $this->getTagBag();
        if(null === $tagBag) {
            return [];
        }

        if (null === $sections || '' === $sections || [] === $sections) {
            return $tagBag->all();
        }

        if (\is_string($sections)) {
            return $tagBag->get($sections);
        }

        $result = [];
        foreach ($sections as $section) {
            $result[$section] = $tagBag->get($section);
        }

        return $result;
    }

    private function getTagBag(): ?TagBagInterface
    {
        if (null === $this->requestStack) {
            return null;
        }

        $request = $this->requestStack->getCurrentRequest();

        if(null === $request) {
            return null;
        }

        $session = $request->getSession();

        if(null === $session) {
            return null;
        }

        /** @var TagBagInterface $tagBag */
        $tagBag = $session->getBag('tags');

        return $tagBag;
    }
}
