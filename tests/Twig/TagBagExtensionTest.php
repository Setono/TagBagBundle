<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\Twig;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\TagBagInterface;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Twig\TwigFunction;

/**
 * @covers \Setono\TagBagBundle\Twig\TagBagExtension
 */
final class TagBagExtensionTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_renders_head_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->renderSection(TagInterface::SECTION_HEAD)->willReturn('');

        $extension = new TagBagExtension($tagBag->reveal());

        self::assertSame('', $extension->renderHead());
    }

    /**
     * @test
     */
    public function it_renders_body_begin_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->renderSection(TagInterface::SECTION_BODY_BEGIN)->willReturn('');

        $extension = new TagBagExtension($tagBag->reveal());

        self::assertSame('', $extension->renderBodyBegin());
    }

    /**
     * @test
     */
    public function it_returns_body_end_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->renderSection(TagInterface::SECTION_BODY_END)->willReturn('');

        $extension = new TagBagExtension($tagBag->reveal());

        self::assertSame('', $extension->renderBodyEnd());
    }

    /**
     * @test
     */
    public function it_returns_all_tags(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->renderAll()->willReturn('');

        $extension = new TagBagExtension($tagBag->reveal());

        self::assertSame('', $extension->renderAll());
    }

    /**
     * @test
     */
    public function it_registers_functions(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->getAll()->willReturn([]);

        $extension = new TagBagExtension($tagBag->reveal());
        $functions = $extension->getFunctions();

        self::assertCount(5, $functions);
        self::assertContainsOnlyInstancesOf(TwigFunction::class, $functions);
    }
}
