<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Registry;

use Setono\TagBagBundle\TypeRenderer\TypeRendererInterface;

interface TypeRendererRegistryInterface
{
    /**
     * Will register the given type renderer for the given type.
     *
     * @param string                $type
     * @param TypeRendererInterface $typeRenderer
     */
    public function register(string $type, TypeRendererInterface $typeRenderer): void;

    /**
     * Returns true if a type renderer exists for the given type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function has(string $type): bool;

    /**
     * Returns a type renderer for the given type.
     *
     * @param string $type
     *
     * @return TypeRendererInterface
     */
    public function get(string $type): TypeRendererInterface;
}
