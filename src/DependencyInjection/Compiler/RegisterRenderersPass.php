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

        $renderers = array_map(static function ($id) {
            return new Reference($id);
        }, array_keys($container->findTaggedServiceIds('setono_tag_bag.renderer')));

        $renderer = $container->getDefinition('setono_tag_bag.renderer.composite');
        $renderer->setArguments($renderers);
    }
}
