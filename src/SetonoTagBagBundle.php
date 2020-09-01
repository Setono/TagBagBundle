<?php

declare(strict_types=1);

namespace Setono\TagBagBundle;

use Setono\TagBagBundle\DependencyInjection\Compiler\AddPathsToPhpTemplatesEnginePass;
use Setono\TagBagBundle\DependencyInjection\Compiler\AddPathsToTwigPass;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterRenderersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SetonoTagBagBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterRenderersPass());
        $container->addCompilerPass(new AddPathsToPhpTemplatesEnginePass());
        $container->addCompilerPass(new AddPathsToTwigPass());
    }
}
