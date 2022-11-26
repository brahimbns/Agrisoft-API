<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ReceptionRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReceptionRepository::class)]
#[ApiResource]
class Reception
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $receipt = null;

    #[ORM\Column(nullable: true)]
    private ?int $ticket_number = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_receipt = null;

    #[ORM\Column]
    private ?float $quantity = null;

    #[ORM\ManyToOne(inversedBy: 'receptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'receptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Farmer $farmer_id = null;

    #[ORM\ManyToOne(inversedBy: 'receptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Center $center_id = null;

    #[ORM\ManyToOne(inversedBy: 'receptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Product $product_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceipt(): ?string
    {
        return $this->receipt;
    }

    public function setReceipt(string $receipt): self
    {
        $this->receipt = $receipt;

        return $this;
    }

    public function getTicketNumber(): ?int
    {
        return $this->ticket_number;
    }

    public function setTicketNumber(?int $ticket_number): self
    {
        $this->ticket_number = $ticket_number;

        return $this;
    }

    public function getDateReceipt(): ?\DateTimeInterface
    {
        return $this->date_receipt;
    }

    public function setDateReceipt(\DateTimeInterface $date_receipt): self
    {
        $this->date_receipt = $date_receipt;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUserId(): ?User
    {
        return $this->user_id;
    }

    public function setUserId(?User $user_id): self
    {
        $this->user_id = $user_id;

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

    public function getCenterId(): ?Center
    {
        return $this->center_id;
    }

    public function setCenterId(?Center $center_id): self
    {
        $this->center_id = $center_id;

        return $this;
    }

    public function getProductId(): ?Product
    {
        return $this->product_id;
    }

    public function setProductId(?Product $product_id): self
    {
        $this->product_id = $product_id;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
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
}
