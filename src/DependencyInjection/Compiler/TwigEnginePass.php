<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\Factory\TwigTagFactory;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Setono\TagBagBundle\TypeRenderer\TypeRendererInterface;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class TwigEnginePass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('twig')) {
            return;
        }

        // create the twig tag factory service
        $container->setDefinition(
            'setono.tag_bag.factory.twig_tag',
            new Definition(TwigTagFactory::class, [new Reference('templating.engine.twig')])
        );

        // create the twig extension service
        $definition = new Definition(
            TagBagExtension::class, [
                new Reference(TypeRendererInterface::class),
                new Reference('request_stack', ContainerInterface::NULL_ON_INVALID_REFERENCE),
            ]
        );
        $definition->addTag('twig.extension');
        $container->setDefinition(TagBagExtension::class, $definition);
    }
}
