<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Registry;

use Setono\TagBagBundle\Exception\ExistingTypeRendererException;
use Setono\TagBagBundle\Exception\NonExistentTypeRendererException;
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
            throw new ExistingTypeRendererException($type);
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
            throw new NonExistentTypeRendererException($type, array_keys($this->typeRenderers));
        }

        return $this->typeRenderers[$type];
    }
}
