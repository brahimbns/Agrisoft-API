<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CreditRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CreditRepository::class)]
#[ApiResource]
class Credit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $credit_total = null;

    #[ORM\Column]
    private ?float $credit_rest = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $treaty_number = [];

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\ManyToOne(inversedBy: 'credits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Farmer $farmer_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreditTotal(): ?float
    {
        return $this->credit_total;
    }

    public function setCreditTotal(float $credit_total): self
    {
        $this->credit_total = $credit_total;

        return $this;
    }

    public function getCreditRest(): ?float
    {
        return $this->credit_rest;
    }

    public function setCreditRest(float $credit_rest): self
    {
        $this->credit_rest = $credit_rest;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getTreatyNumber(): array
    {
        return $this->treaty_number;
    }

    public function setTreatyNumber(array $treaty_number): self
    {
        $this->treaty_number = $treaty_number;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getFarmerId(): ?Farmer
    {
        return $this->farmer_id;
    }

    public function setFarmerId(?Farmer $farmer_id): self
    {
        $this->farmer_id = $farmer_id;

        return $this;
    }
}
