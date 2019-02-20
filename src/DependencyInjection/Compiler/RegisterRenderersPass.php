<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\Renderer\CompositeRenderer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterRenderersPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        $definition = new Definition(CompositeRenderer::class);

        foreach ($container->findTaggedServiceIds('setono_tag_bag.renderer') as $id => $attributes) {
            $definition->addArgument(new Reference($id));
        }

        $container->setDefinition('setono_tag_bag.renderer.composite', $definition);
    }
}
