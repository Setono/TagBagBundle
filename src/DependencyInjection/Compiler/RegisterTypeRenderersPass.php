<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\TypeRenderer\CompositeTypeRenderer;
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
        if (!$container->hasDefinition(CompositeTypeRenderer::class)) {
            return;
        }

        $compositeTypeRenderer = $container->getDefinition(CompositeTypeRenderer::class);

        $typeRenderers = $container->findTaggedServiceIds('setono_tag_bag.type_renderer');

        foreach ($typeRenderers as $id => $typeRenderer) {
            $compositeTypeRenderer->addArgument(new Reference($id));
        }
    }
}
