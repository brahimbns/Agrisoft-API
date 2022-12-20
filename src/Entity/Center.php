<?php

namespace App\Entity;

use App\Repository\CenterRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CenterRepository::class)]

class Center
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code_center = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\Column(nullable: true)]
    private ?float $capacity = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $governate = null;

    #[ORM\Column(length: 255)]
    private ?string $bank = null;

    #[ORM\Column(length: 255)]
    private ?string $rib = null;

//    #[ORM\ManyToOne(inversedBy: 'centers')]
//    #[ORM\JoinColumn(nullable: false)]
//    private ?User $user_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updated_at = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deleted_at = null;

    #[ORM\OneToMany(mappedBy: 'center_id', targetEntity: Reception::class)]
    private Collection $receptions;

    #[ORM\OneToMany(mappedBy: 'center_id', targetEntity: UserCenter::class, orphanRemoval: true)]
    private Collection $userCenters;

    public function __construct()
    {
        $this->receptions = new ArrayCollection();
        $this->userCenters = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeCenter(): ?string
    {
        return $this->code_center;
    }

    public function setCodeCenter(string $code_center): self
    {
        $this->code_center = $code_center;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function getCapacity(): ?float
    {
        return $this->capacity;
    }

    public function setCapacity(?float $capacity): self
    {
        $this->capacity = $capacity;

        return $this;
    }

    public function getGovernate(): ?string
    {
        return $this->governate;
    }

    public function setGovernate(?string $governate): self
    {
        $this->governate = $governate;

        return $this;
    }

    public function getBank(): ?string
    {
        return $this->bank;
    }

    public function setBank(string $bank): self
    {
        $this->bank = $bank;

        return $this;
    }

    public function getRib(): ?string
    {
        return $this->rib;
    }

    public function setRib(string $rib): self
    {
        $this->rib = $rib;

        return $this;
    }

//    public function getUserId(): ?User
//    {
//        return $this->user_id;
//    }

//    public function setUserId(?User $user_id): self
//    {
//        $this->user_id = $user_id;
//
//        return $this;
//    }

    public function getCreatedAt(): ?DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection<int, Reception>
     */
    public function getReceptions(): Collection
    {
        return $this->receptions;
    }

    public function addReception(Reception $reception): self
    {
        if (!$this->receptions->contains($reception)) {
            $this->receptions->add($reception);
            $reception->setCenterId($this);
        }

        return $this;
    }

    public function removeReception(Reception $reception): self
    {
        if ($this->receptions->removeElement($reception)) {
            // set the owning side to null (unless already changed)
            if ($reception->getCenterId() === $this) {
                $reception->setCenterId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserCenter>
     */
    public function getUserCenters(): Collection
    {
        return $this->userCenters;
    }

    public function addUserCenter(UserCenter $userCenter): self
    {
        if (!$this->userCenters->contains($userCenter)) {
            $this->userCenters->add($userCenter);
            $userCenter->setCenterId($this);
        }

        return $this;
    }

    public function removeUserCenter(UserCenter $userCenter): self
    {
        if ($this->userCenters->removeElement($userCenter)) {
            // set the owning side to null (unless already changed)
            if ($userCenter->getCenterId() === $this) {
                $userCenter->setCenterId(null);
            }
        }

        return $this;
    }
}
