<?php

namespace App\Entity;


use App\Repository\UserCenterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: UserCenterRepository::class)]

class UserCenter
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userCenters')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["Center"])]
    private ?User $user_id = null;

    #[ORM\ManyToOne(inversedBy: 'userCenters')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["User"])]
    private ?Center $center_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    public function __construct()
    {
        $this->created_at = new \DateTimeImmutable("now");
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCenterId(): ?Center
    {
        return $this->center_id;
    }

    public function setCenterId(?Center $center_id): self
    {
        $this->center_id = $center_id;

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
