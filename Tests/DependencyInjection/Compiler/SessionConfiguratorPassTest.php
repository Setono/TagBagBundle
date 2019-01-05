<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;


use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\SessionConfiguratorPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class SessionConfiguratorPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new SessionConfiguratorPass());
    }
}
