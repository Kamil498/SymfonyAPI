<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $imie_nazwisko = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column]
    private ?int $numer_tel = null;

    #[ORM\Column(length: 300)]
    private ?string $content = null;

    #[ORM\Column]
    private ?int $status = null;



    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImieNazwisko(): ?string
    {
        return $this->imie_nazwisko;
    }

    public function setImieNazwisko(?string $imie_nazwisko): Order
    {
        $this->imie_nazwisko = $imie_nazwisko;

        return $this;
    }

    public function getNumerTel(): ?int
    {
        return $this->numer_tel;
    }

    public function setNumerTel(int $numer_tel): static
    {
        $this->numer_tel = $numer_tel;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(?int $status): static
    {
        $this->status = $status;

        return $this;
    }
}
