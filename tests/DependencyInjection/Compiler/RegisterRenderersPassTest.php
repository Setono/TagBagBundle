<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterRenderersPass;
use Setono\TagBagBundle\Renderer\CompositeRenderer;
use Symfony\Component\DependencyInjection\ContainerBuilder;

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
        $this->compile();

        $this->assertContainerBuilderHasService('setono_tag_bag.renderer.composite', CompositeRenderer::class);
    }
}
