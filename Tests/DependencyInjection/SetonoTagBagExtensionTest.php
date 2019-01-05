<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Setono\TagBagBundle\DependencyInjection\SetonoTagBagExtension;

final class SetonoTagBagExtensionTest extends AbstractExtensionTestCase
{
    protected function getContainerExtensions(): array
    {
        return [
            new SetonoTagBagExtension()
        ];
    }

    /**
     * @test
     */
    public function it_can_load(): void
    {
        $this->load();

        $this->assertTrue(true);
    }
}
