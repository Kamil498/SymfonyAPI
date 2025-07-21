<?php

namespace App\Entity;

use App\Repository\KontaktRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: KontaktRepository::class)]
class Kontakt
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numerTel = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $adres = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumerTel(): ?int
    {
        return $this->numerTel;
    }

    public function setNumerTel(int $numerTel): static
    {
        $this->numerTel = $numerTel;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getAdres(): ?string
    {
        return $this->adres;
    }

    public function setAdres(string $adres): static
    {
        $this->adres = $adres;

        return $this;
    }
}
