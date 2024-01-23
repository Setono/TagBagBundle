<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\Storage;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\TagBag\Storage\StorageInterface;
use Setono\TagBagBundle\Storage\SessionStorage;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * @covers \Setono\TagBagBundle\Storage\SessionStorage
 */
final class SessionStorageTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_stores(): void
    {
        $session = $this->prophesize(SessionInterface::class);
        $session->isStarted()->willReturn(true);
        $session->set(StorageInterface::DATA_KEY, 'data')->shouldBeCalled();

        $requestStack = $this->prophesize(RequestStack::class);
        $requestStack->getSession()->willReturn($session);

        $storage = new SessionStorage($requestStack->reveal());
        $storage->store('data');
    }

    /**
     * @test
     */
    public function it_restores(): void
    {
        $request = $this->prophesize(Request::class);
        $request->hasPreviousSession()->willReturn(true);

        $session = $this->prophesize(SessionInterface::class);
        $session->get(StorageInterface::DATA_KEY)->shouldBeCalled()->willReturn('data');

        $requestStack = $this->prophesize(RequestStack::class);
        $requestStack->getSession()->willReturn($session);
        $requestStack->getCurrentRequest()->willReturn($request);

        $storage = new SessionStorage($requestStack->reveal());
        $storage->restore();
    }

    /**
     * @test
     */
    public function it_removes(): void
    {
        $session = $this->prophesize(SessionInterface::class);
        $session->isStarted()->willReturn(true);
        $session->remove(StorageInterface::DATA_KEY)->shouldBeCalled()->willReturn('data');

        $requestStack = $this->prophesize(RequestStack::class);
        $requestStack->getSession()->willReturn($session);

        $storage = new SessionStorage($requestStack->reveal());
        $storage->remove();
    }
}
