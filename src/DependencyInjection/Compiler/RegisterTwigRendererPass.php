<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\DependencyInjection\Compiler;

use Setono\TagBagBundle\Renderer\TwigRenderer;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

final class RegisterTwigRendererPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->has('twig')) {
            return;
        }

        $twigRenderer = new Definition(TwigRenderer::class, [new Reference('twig')]);
        $twigRenderer->addTag('setono_tag_bag.renderer');
        $container->setDefinition('setono.tag_bag.renderer.twig_tag', $twigRenderer);
    }
}
