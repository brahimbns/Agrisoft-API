<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PaymentFarmerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentFarmerRepository::class)]
#[ApiResource]
class PaymentFarmer
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?float $credit = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnalyseRequest $analyse_request_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCredit(): ?float
    {
        return $this->credit;
    }

    public function setCredit(?float $credit): self
    {
        $this->credit = $credit;

        return $this;
    }

    public function getAnalyseRequestId(): ?AnalyseRequest
    {
        return $this->analyse_request_id;
    }

    public function setAnalyseRequestId(AnalyseRequest $analyse_request_id): self
    {
        $this->analyse_request_id = $analyse_request_id;

        return $this;
    }
}
