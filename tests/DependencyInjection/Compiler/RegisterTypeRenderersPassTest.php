<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterTypeRenderersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterTypeRenderersPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterTypeRenderersPass());
    }
}
