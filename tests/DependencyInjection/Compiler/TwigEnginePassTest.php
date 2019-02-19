<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterTwigExtensionPass;
use Setono\TagBagBundle\Factory\TwigTagFactory;
use Setono\TagBagBundle\Twig\TagInjectorExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigEnginePassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new RegisterTwigExtensionPass());
    }

    /**
     * @test
     */
    public function service_definitions_should_exist(): void
    {
        $twig = new Definition();
        $this->setDefinition('twig', $twig);

        $this->compile();

        $this->assertContainerBuilderHasService('setono.tag_bag.factory.twig_tag', TwigTagFactory::class);
        $this->assertContainerBuilderHasService(TagInjectorExtension::class, TagInjectorExtension::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(TagInjectorExtension::class, 'twig.extension');
    }
}
