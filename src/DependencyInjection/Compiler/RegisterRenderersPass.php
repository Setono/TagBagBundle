<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterRenderersPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_tag_bag.renderer.composite')) {
            return;
        }

        $renderer = $container->getDefinition('setono_tag_bag.renderer.composite');

        foreach ($container->findTaggedServiceIds('setono_tag_bag.renderer') as $id => $tags) {
            foreach ($tags as $tag) {
                $priority = $tag['priority'] ?? 0;

                $renderer->addMethodCall('addRenderer', [new Reference($id), $priority]);
            }
        }
    }
}
