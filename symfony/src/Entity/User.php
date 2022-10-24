<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Column;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[Table(name: 'user')]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[Column(type: Types::INTEGER)]
    private int $id;

    #[Column(length: 255)]
    private string $name;

    #[Column(type: Types::INTEGER, name: 'unique_key')]
    private int $uniqueKey;

    #[Column(type: Types::INTEGER, name: 'parent_key')]
    private int $parentKey;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getUnique_key(): int
    {
        return $this->uniqueKey;
    }

    public function setUniqueKey(int $uniqueKey): void
    {
        $this->uniqueKey = $uniqueKey;
    }

    public function getParentKey(): int
    {
        return $this->parentKey;
    }

    public function setParentKey(int $parentKey): void
    {
        $this->parentKey = $parentKey;
    }
}
