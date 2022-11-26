<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AnalyseRequestReceptionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyseRequestReceptionRepository::class)]
#[ApiResource]
class AnalyseRequestReception
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reception $receipt_id = null;

    #[ORM\ManyToOne(inversedBy: 'analyseRequestReceptions')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnalyseRequest $request_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getReceiptId(): ?Reception
    {
        return $this->receipt_id;
    }

    public function setReceiptId(Reception $receipt_id): self
    {
        $this->receipt_id = $receipt_id;

        return $this;
    }

    public function getRequestId(): ?AnalyseRequest
    {
        return $this->request_id;
    }

    public function setRequestId(?AnalyseRequest $request_id): self
    {
        $this->request_id = $request_id;

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
}
