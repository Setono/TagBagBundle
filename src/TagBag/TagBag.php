<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TagBag;

use Setono\TagBagBundle\Renderer\RendererInterface;
use Setono\TagBagBundle\Tag\TagInterface;
use Webmozart\Assert\Assert;

final class TagBag implements TagBagInterface
{
    /**
     * @var RendererInterface
     */
    private $renderer;

    /**
     * @var array
     */
    private $tags = [];

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function initialize(array $tags): void
    {
        $this->tags = array_merge($this->tags, $tags);
    }

    public function add(TagInterface $tag, string $section = self::SECTION_BODY_END): void
    {
        Assert::true($this->renderer->supports($tag), sprintf('The tag %s is not supported by the given tag renderer', get_class($tag)));

        $renderedTag = $this->renderer->render($tag);

        $this->tags[$section][$tag->getKey()] = $renderedTag;
    }

    public function getSection(string $section, array $default = []): array
    {
        if (!$this->hasSection($section)) {
            return $default;
        }

        $return = $this->tags[$section];

        unset($this->tags[$section]);

        return $return;
    }

    public function all(): array
    {
        $tags = $this->tags;
        $this->tags = [];

        return $tags;
    }

    /**
     * Returns the total number of tags.
     *
     * @return int
     */
    public function count(): int
    {
        $sections = count($this->tags);

        if (0 === $sections) {
            return 0;
        }

        return (int) array_sum(array_map(function (array $section) {
            return count($section);
        }, $this->tags));
    }

    private function hasSection(string $section): bool
    {
        return array_key_exists($section, $this->tags) && $this->tags[$section];
    }
}
