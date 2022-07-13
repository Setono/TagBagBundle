<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterRenderersPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @covers \Setono\TagBagBundle\DependencyInjection\Compiler\RegisterRenderersPass
 */
class RegisterRenderersPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterRenderersPass());
    }

    /**
     * @test
     */
    public function service_definitions_should_exist(): void
    {
        $this->setDefinition('setono_tag_bag.renderer.composite', new Definition());

        $renderer = new Definition();
        $renderer->addTag('setono_tag_bag.renderer');
        $this->setDefinition('renderer', $renderer);

        $this->compile();

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall('setono_tag_bag.renderer.composite', 'add', [new Reference('renderer')]);
    }
}
