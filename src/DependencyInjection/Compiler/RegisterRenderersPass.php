<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Compiler\PriorityTaggedServiceTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class RegisterRenderersPass implements CompilerPassInterface
{
    use PriorityTaggedServiceTrait;

    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasDefinition('setono_tag_bag.renderer.composite')) {
            return;
        }

        $composite = $container->getDefinition('setono_tag_bag.renderer.composite');

        foreach ($this->findAndSortTaggedServices('setono_tag_bag.renderer', $container) as $service) {
            $composite->addMethodCall('add', [$service]);
        }
    }
}
