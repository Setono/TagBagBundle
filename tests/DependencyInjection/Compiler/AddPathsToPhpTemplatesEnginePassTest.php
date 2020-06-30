<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection\Compiler;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractCompilerPassTestCase;
use ReflectionClass;
use Setono\TagBag\Tag\GtagInterface;
use Setono\TagBagBundle\DependencyInjection\Compiler\AddPathsToPhpTemplatesEnginePass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

/**
 * @covers \Setono\TagBagBundle\DependencyInjection\Compiler\AddPathsToPhpTemplatesEnginePass
 */
class AddPathsToPhpTemplatesEnginePassTest extends AbstractCompilerPassTestCase
{
    protected function registerCompilerPass(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AddPathsToPhpTemplatesEnginePass());
    }

    /**
     * @test
     */
    public function service_definitions_should_exist(): void
    {
        $this->setDefinition('setono_php_templates.engine.default', new Definition());

        $this->compile();

        $filename = (new ReflectionClass(GtagInterface::class))->getFileName();
        $path = dirname($filename, 2) . '/templates';

        $this->assertContainerBuilderHasServiceDefinitionWithMethodCall('setono_php_templates.engine.default', 'addPath', [$path]);
    }
}
