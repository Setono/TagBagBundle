<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Storage;

use Setono\TagBag\Exception\StorageException;
use Setono\TagBag\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionStorage implements StorageInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function store(string $data): void
    {
        $session = $this->getSession();
        if (!$session->isStarted()) {
            return;
        }

        $session->set(self::DATA_KEY, $data);
    }

    public function restore(): ?string
    {
        $session = $this->getSession();
        if (!$session->isStarted()) {
            return null;
        }

        /** @var mixed $data */
        $data = $session->get(self::DATA_KEY);

        return is_string($data) ? $data : null;
    }

    public function remove(): void
    {
        $session = $this->getSession();
        if (!$session->isStarted()) {
            return;
        }

        $session->remove(self::DATA_KEY);
    }

    private function getSession(): SessionInterface
    {
        try {
            return $this->requestStack->getSession();
        } catch (SessionNotFoundException $e) {
            throw new StorageException($e->getMessage(), 0, $e);
        }
    }
}
