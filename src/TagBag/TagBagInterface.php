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
     */
    public function add(TagInterface $tag, string $section = self::SECTION_BODY_END): void;

    /**
     * Gets and clears all tags from the stack.
     */
    public function all(): array;

    /**
     * Gets and clears tags from a specific section.
     *
     * @param array  $default Default value if $section does not exist
     */
    public function getSection(string $section, array $default = []): array;

    /**
     * Initializes the tag bag.
     */
    public function initialize(array $tags): void;
}
