<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TagBag;

use Countable;
use Setono\TagBagBundle\Tag\TagInterface;

interface TagBagInterface extends Countable
{
    public const SECTION_HEAD = 'head';
    public const SECTION_BODY_BEGIN = 'body_begin';
    public const SECTION_BODY_END = 'body_end';

    /**
     * Adds a tag in the given section.
     *
     * @param TagInterface $tag
     * @param string       $section
     */
    public function add(TagInterface $tag, string $section = self::SECTION_BODY_END): void;

    /**
     * Gets and clears all tags from the stack.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Gets and clears tags from a specific section.
     *
     * @param string $section
     * @param array  $default Default value if $section does not exist
     *
     * @return array
     */
    public function getSection(string $section, array $default = []): array;

    /**
     * Initializes the tag bag.
     *
     * @param array $tags
     */
    public function initialize(array $tags);
}
