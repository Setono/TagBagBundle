<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Storage;

use Setono\TagBag\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionStorage implements StorageInterface
{
    /** @var SessionInterface */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function store(string $data): void
    {
        $this->session->set(self::DATA_KEY, $data);
    }

    public function restore(): ?string
    {
        return $this->session->get(self::DATA_KEY);
    }

    public function remove(): void
    {
        $this->session->remove(self::DATA_KEY);
    }
}
