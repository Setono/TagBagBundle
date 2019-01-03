<?php

namespace Setono\TagBagBundle;

use Setono\TagBagBundle\DependencyInjection\Compiler\SessionConfiguratorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class SetonoTagBagBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new SessionConfiguratorPass());
    }
}
