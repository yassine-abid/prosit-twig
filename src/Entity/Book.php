<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?bool $publicationDate = null;

    #[ORM\Column(length: 255)]
    private ?string $enabled = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?Author $auhtor = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function isPublicationDate(): ?bool
    {
        return $this->publicationDate;
    }

    public function setPublicationDate(bool $publicationDate): static
    {
        $this->publicationDate = $publicationDate;

        return $this;
    }

    public function getEnabled(): ?string
    {
        return $this->enabled;
    }

    public function setEnabled(string $enabled): static
    {
        $this->enabled = $enabled;

        return $this;
    }

    public function getAuhtor(): ?Author
    {
        return $this->auhtor;
    }

    public function setAuhtor(?Author $auhtor): static
    {
        $this->auhtor = $auhtor;

        return $this;
    }
}
