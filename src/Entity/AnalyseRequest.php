<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AnalyseRequestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnalyseRequestRepository::class)]
#[ApiResource]
class AnalyseRequest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $analyse_request_number = null;

    #[ORM\Column(nullable: true)]
    private ?int $sample_number = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $date_request = null;

    #[ORM\Column]
    private ?int $status = null;

    #[ORM\OneToMany(mappedBy: 'request_id', targetEntity: AnalyseRequestReception::class)]
    private Collection $analyseRequestReceptions;

    #[ORM\OneToMany(mappedBy: 'analyse_request_id', targetEntity: Analyse::class)]
    private Collection $analyses;

    public function __construct()
    {
        $this->analyseRequestReceptions = new ArrayCollection();
        $this->analyses = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAnalyseRequestNumber(): ?string
    {
        return $this->analyse_request_number;
    }

    public function setAnalyseRequestNumber(string $analyse_request_number): self
    {
        $this->analyse_request_number = $analyse_request_number;

        return $this;
    }

    public function getSampleNumber(): ?int
    {
        return $this->sample_number;
    }

    public function setSampleNumber(?int $sample_number): self
    {
        $this->sample_number = $sample_number;

        return $this;
    }

    public function getDateRequest(): ?\DateTimeInterface
    {
        return $this->date_request;
    }

    public function setDateRequest(\DateTimeInterface $date_request): self
    {
        $this->date_request = $date_request;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, AnalyseRequestReception>
     */
    public function getAnalyseRequestReceptions(): Collection
    {
        return $this->analyseRequestReceptions;
    }

    public function addAnalyseRequestReception(AnalyseRequestReception $analyseRequestReception): self
    {
        if (!$this->analyseRequestReceptions->contains($analyseRequestReception)) {
            $this->analyseRequestReceptions->add($analyseRequestReception);
            $analyseRequestReception->setRequestId($this);
        }

        return $this;
    }

    public function removeAnalyseRequestReception(AnalyseRequestReception $analyseRequestReception): self
    {
        if ($this->analyseRequestReceptions->removeElement($analyseRequestReception)) {
            // set the owning side to null (unless already changed)
            if ($analyseRequestReception->getRequestId() === $this) {
                $analyseRequestReception->setRequestId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Analyse>
     */
    public function getAnalyses(): Collection
    {
        return $this->analyses;
    }

    public function addAnalysis(Analyse $analysis): self
    {
        if (!$this->analyses->contains($analysis)) {
            $this->analyses->add($analysis);
            $analysis->setAnalyseRequestId($this);
        }

        return $this;
    }

    public function removeAnalysis(Analyse $analysis): self
    {
        if ($this->analyses->removeElement($analysis)) {
            // set the owning side to null (unless already changed)
            if ($analysis->getAnalyseRequestId() === $this) {
                $analysis->setAnalyseRequestId(null);
            }
        }

        return $this;
    }
}
