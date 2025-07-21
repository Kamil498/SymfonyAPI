<?php

namespace App\Entity;

use App\Repository\ONasRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ONasRepository::class)]
class ONas
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $tytul = null;

    #[ORM\Column(length: 255)]
    private ?string $opis = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTytul(): ?string
    {
        return $this->tytul;
    }

    public function setTytul(string $tytul): static
    {
        $this->tytul = $tytul;

        return $this;
    }

    public function getOpis(): ?string
    {
        return $this->opis;
    }

    public function setOpis(string $opis): static
    {
        $this->opis = $opis;

        return $this;
    }
}
