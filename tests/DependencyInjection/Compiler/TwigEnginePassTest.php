<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\TwigEnginePass;
use Setono\TagBagBundle\Factory\TwigTagFactory;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TwigEnginePassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new TwigEnginePass());
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
        $this->assertContainerBuilderHasService(TagBagExtension::class, TagBagExtension::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(TagBagExtension::class, 'twig.extension');
    }
}
