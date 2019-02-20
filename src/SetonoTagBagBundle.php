<?php

declare(strict_types=1);

namespace Setono\TagBagBundle;

use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterRenderersPass;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterTwigRendererPass;
use Setono\TagBagBundle\DependencyInjection\Compiler\SessionConfiguratorPass;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterTwigExtensionPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoTagBagBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SessionConfiguratorPass());
        $container->addCompilerPass(new RegisterTwigRendererPass());
        $container->addCompilerPass(new RegisterRenderersPass());
        $container->addCompilerPass(new RegisterTwigExtensionPass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 1); // the priority needs to be higher than the pass that extracts the tagged twig extensions
    }
}
