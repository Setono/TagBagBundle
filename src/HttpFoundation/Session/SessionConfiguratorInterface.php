<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\HttpFoundation\Session;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

interface SessionConfiguratorInterface
{
    /**
     * @param SessionInterface $session
     */
    public function configure(SessionInterface $session): void;
}
