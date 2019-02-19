<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\Twig\TagBagExtension;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterTwigExtensionPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('twig')) {
            return;
        }

        $definition = new Definition(
            TagBagExtension::class, [
                new Reference('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE),
            ]
        );
        $definition->addTag('twig.extension');
        $container->setDefinition(TagBagExtension::class, $definition);
    }
}
