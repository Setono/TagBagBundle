<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\Registry\TypeRendererRegistry;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class RegisterTypeRenderersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition(TypeRendererRegistry::class)) {
            return;
        }

        $typeRendererRegistry = $container->getDefinition(TypeRendererRegistry::class);

        foreach ($container->findTaggedServiceIds('setono_tag_bag.type_renderer') as $id => $attributes) {
            if (!isset($attributes[0]['type'])) {
                throw new \InvalidArgumentException('Tagged type renderer `'.$id.'` needs to have `type` attribute.');
            }

            $typeRendererRegistry->addMethodCall('register', [$attributes[0]['type'], new Reference($id)]);
        }
    }
}
