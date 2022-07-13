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
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function store(string $data): void
    {
        $this->getSession()->set(self::DATA_KEY, $data);
    }

    public function restore(): ?string
    {
        /** @var mixed $data */
        $data = $this->getSession()->get(self::DATA_KEY);

        return is_string($data) ? $data : null;
    }

    public function remove(): void
    {
        $this->getSession()->remove(self::DATA_KEY);
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
