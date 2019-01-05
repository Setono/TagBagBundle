<?php

namespace Setono\TagBagBundle;

use Setono\TagBagBundle\DependencyInjection\Compiler\SessionConfiguratorPass;
use Setono\TagBagBundle\DependencyInjection\Compiler\TwigEnginePass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SetonoTagBagBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SessionConfiguratorPass());
        $container->addCompilerPass(new TwigEnginePass(), PassConfig::TYPE_BEFORE_OPTIMIZATION, 1); // the priority needs to be higher than the pass that extracts the tagged twig extensions
    }
}
