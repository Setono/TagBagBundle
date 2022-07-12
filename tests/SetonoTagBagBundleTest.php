<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests;

use Nyholm\BundleTest\TestKernel;
use Setono\TagBag\Generator\ValueBasedFingerprintGenerator;
use Setono\TagBag\Renderer\CompositeRenderer;
use Setono\TagBag\Renderer\ContentRenderer;
use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Renderer\ScriptRenderer;
use Setono\TagBag\Renderer\StyleRenderer;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBag\TagBag;
use Setono\TagBag\TagBagInterface;
use Setono\TagBagBundle\EventListener\RestoreTagBagSubscriber;
use Setono\TagBagBundle\EventListener\StoreTagBagSubscriber;
use Setono\TagBagBundle\Renderer\TwigRenderer;
use Setono\TagBagBundle\SetonoTagBagBundle;
use Setono\TagBagBundle\Storage\SessionStorage;
use Setono\TagBagBundle\Twig\Extension;
use Setono\TagBagBundle\Twig\Runtime;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Bundle\TwigBundle\TwigBundle;
use Symfony\Component\HttpKernel\KernelInterface;

/**
 * @covers \Setono\TagBagBundle\SetonoTagBagBundle
 */
final class SetonoTagBagBundleTest extends KernelTestCase
{
    protected static function getKernelClass(): string
    {
        return TestKernel::class;
    }

    protected static function createKernel(array $options = []): KernelInterface
    {
        /**
         * @var TestKernel $kernel
         */
        $kernel = parent::createKernel($options);
        $kernel->addTestBundle(SetonoTagBagBundle::class);
        $kernel->addTestBundle(TwigBundle::class);
        $kernel->handleOptions($options);

        return $kernel;
    }

    /**
     * @test
     */
    public function it_inits(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        /**
         * @var list<array{id: string, class: class-string}>
         */
        $services = [
            // event listeners
            ['id' => 'setono_tag_bag.event_listener.restore_tag_bag_subscriber', 'class' => RestoreTagBagSubscriber::class],
            ['id' => 'setono_tag_bag.event_listener.store_tag_bag_subscriber', 'class' => StoreTagBagSubscriber::class],

            // generators
            ['id' => 'setono_tag_bag.generator.fingerprint.default', 'class' => ValueBasedFingerprintGenerator::class],
            ['id' => 'setono_tag_bag.generator.value_based_fingerprint', 'class' => ValueBasedFingerprintGenerator::class],

            // renderers
            ['id' => RendererInterface::class, 'class' => CompositeRenderer::class],
            ['id' => 'setono_tag_bag.renderer.default', 'class' => CompositeRenderer::class],
            ['id' => 'setono_tag_bag.renderer.composite', 'class' => CompositeRenderer::class],
            ['id' => 'setono_tag_bag.renderer.content', 'class' => ContentRenderer::class],
            ['id' => 'setono_tag_bag.renderer.script', 'class' => ScriptRenderer::class],
            ['id' => 'setono_tag_bag.renderer.style', 'class' => StyleRenderer::class],
            ['id' => 'setono_tag_bag.renderer.twig', 'class' => TwigRenderer::class],

            // storage
            ['id' => StorageInterface::class, 'class' => SessionStorage::class],
            ['id' => 'setono_tag_bag.storage.default', 'class' => SessionStorage::class],
            ['id' => 'setono_tag_bag.storage.session', 'class' => SessionStorage::class],

            // tag bag
            ['id' => TagBagInterface::class, 'class' => TagBag::class],
            ['id' => 'setono_tag_bag.tag_bag', 'class' => TagBag::class],

            // twig
            ['id' => 'setono_tag_bag.twig.extension', 'class' => Extension::class],
            ['id' => 'setono_tag_bag.twig.runtime', 'class' => Runtime::class],
        ];

        foreach ($services as $service) {
            $this->assertTrue($container->has($service['id']), sprintf('The container does not have a service with id: "%s"', $service['id']));
            $instance = $container->get($service['id']);
            $this->assertInstanceOf($service['class'], $instance);
        }
    }
}
