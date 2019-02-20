<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterTwigRendererPass;
use Setono\TagBagBundle\Renderer\TwigRenderer;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RegisterTwigRendererPassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterTwigRendererPass());
    }

    /**
     * @test
     */
    public function service_definitions_should_exist(): void
    {
        $twig = new Definition();
        $this->setDefinition('twig', $twig);

        $this->compile();

        $this->assertContainerBuilderHasService(TwigRenderer::class, TwigRenderer::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(TwigRenderer::class, 'setono_tag_bag.renderer');
    }
}
