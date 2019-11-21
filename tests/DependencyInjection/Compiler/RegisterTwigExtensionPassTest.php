<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use Setono\TagBagBundle\DependencyInjection\Compiler\RegisterTwigExtensionPass;
use Setono\TagBagBundle\TagBag\TagBagInterface;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class RegisterTwigExtensionPassTest extends AbstractCompilerPassTestCase
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
        $this->setDefinition('twig', new Definition());
        $this->setDefinition(TagBagInterface::class, new Definition());

        $this->compile();

        $this->assertContainerBuilderHasService(TagBagExtension::class, TagBagExtension::class);
        $this->assertContainerBuilderHasServiceDefinitionWithTag(TagBagExtension::class, 'twig.extension');
    }
}
