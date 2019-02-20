<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Session;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionConfigurator implements SessionConfiguratorInterface
{
    /**
     * @var TagBagInterface
     */
    private $tagBag;

    public function __construct(TagBagInterface $tagBag)
    {
        $this->tagBag = $tagBag;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(SessionInterface $session): void
    {
        $session->registerBag($this->tagBag);
    }
}
