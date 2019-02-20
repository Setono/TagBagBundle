<?php

namespace spec\Setono\TagBagBundle\Session;

use Setono\TagBagBundle\Session\SessionConfigurator;
use PhpSpec\ObjectBehavior;
use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionConfiguratorSpec extends ObjectBehavior
{
    public function let(TagBagInterface $tagBag): void
    {
        $this->beConstructedWith($tagBag);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(SessionConfigurator::class);
    }

    public function it_configures(SessionInterface $session, TagBagInterface $tagBag): void
    {
        $session->registerBag($tagBag)->shouldBeCalled();

        $this->configure($session);
    }
}
