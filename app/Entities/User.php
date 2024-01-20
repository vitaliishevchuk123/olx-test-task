<?php

namespace App\Entities;

class User
{
    public function __construct(
        private ?int               $id,
        private ?string            $name,
        private string             $email,
        private \DateTimeImmutable $createdAt
    )
    {
    }

    public static function fill(string $email, \DateTimeImmutable $createdAt = null, string $name = null, int $id = null): static
    {
        return new static($id, $name, $email, $createdAt ?? new \DateTimeImmutable());
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}
