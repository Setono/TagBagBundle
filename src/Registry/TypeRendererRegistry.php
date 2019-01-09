<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Registry;

use Setono\TagBagBundle\TypeRenderer\TypeRendererInterface;

final class TypeRendererRegistry implements TypeRendererRegistryInterface
{
    /**
     * @var TypeRendererInterface[]
     */
    private $typeRenderers = [];

    public function register(string $type, TypeRendererInterface $typeRenderer): void
    {
        if ($this->has($type)) {
            throw new \RuntimeException(sprintf('A type renderer for the given type, %s, already exists', $type));
        }

        $this->typeRenderers[$type] = $typeRenderer;
    }

    public function has(string $type): bool
    {
        return array_key_exists($type, $this->typeRenderers);
    }

    public function get(string $type): TypeRendererInterface
    {
        if (!$this->has($type)) {
            throw new \RuntimeException(sprintf('A type renderer for the given type, %s, does not exist', $type));
        }

        return $this->typeRenderers[$type];
    }
}
