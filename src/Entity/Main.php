<?php

namespace App\Entity;

use App\Repository\MainRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MainRepository::class)]
class Main
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $dziedzina_one = null;

    #[ORM\Column(length: 255)]
    private ?string $dziedzina_two = null;

    #[ORM\Column(length: 255)]
    private ?string $wojewodztwo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tlo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDziedzinaOne(): ?string
    {
        return $this->dziedzina_one;
    }

    public function setDziedzinaOne(string $dziedzina_one): static
    {
        $this->dziedzina_one = $dziedzina_one;

        return $this;
    }

    public function getDziedzinaTwo(): ?string
    {
        return $this->dziedzina_two;
    }

    public function setDziedzinaTwo(string $dziedzina_two): static
    {
        $this->dziedzina_two = $dziedzina_two;

        return $this;
    }

    public function getWojewodztwo(): ?string
    {
        return $this->wojewodztwo;
    }

    public function setWojewodztwo(string $wojewodztwo): static
    {
        $this->wojewodztwo = $wojewodztwo;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTlo(): ?string
    {
        return $this->tlo;
    }

    public function setTlo(?string $tlo): static
    {
        $this->tlo = $tlo;

        return $this;
    }
}
