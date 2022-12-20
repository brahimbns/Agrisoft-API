<?php

namespace App\Entity;

use App\Repository\AnalyseRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyseRepository::class)]
#[ORM\Table(name: '`analyse`')]

class Analyse
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_analyse = null;

    #[ORM\ManyToOne(inversedBy: 'analyses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AnalyseRequest $analyse_request_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateAnalyse(): ?\DateTimeInterface
    {
        return $this->date_analyse;
    }

    public function setDateAnalyse(\DateTimeInterface $date_analyse): self
    {
        $this->date_analyse = $date_analyse;

        return $this;
    }

    public function getAnalyseRequestId(): ?AnalyseRequest
    {
        return $this->analyse_request_id;
    }

    public function setAnalyseRequestId(?AnalyseRequest $analyse_request_id): self
    {
        $this->analyse_request_id = $analyse_request_id;

        return $this;
    }
}
