<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\HttpFoundation\Session\Tag;

use Setono\TagBagBundle\Tag\TagInterface;
use Symfony\Component\HttpFoundation\Session\SessionBagInterface;

interface TagBagInterface extends SessionBagInterface
{
    public const SECTION_HEAD = 'head';
    public const SECTION_BODY_BEGIN = 'body_begin';
    public const SECTION_BODY_END = 'body_end';

    /**
     * Adds a tag for a section.
     *
     * @param string|TagInterface $tag
     * @param string              $section
     */
    public function add($tag, string $section): void;

    /**
     * Gets and clears tags from the stack.
     *
     * @param string $section
     * @param array  $default Default value if $type does not exist
     *
     * @return array
     */
    public function get(string $section, array $default = []): array;

    /**
     * Gets and clears tags from the stack.
     *
     * @return array
     */
    public function all(): array;

    /**
     * Has tags for a given section?
     *
     * @param string $section
     *
     * @return bool
     */
    public function has(string $section): bool;

    /**
     * Returns a list of all defined sections.
     *
     * @return array
     */
    public function keys(): array;
}
