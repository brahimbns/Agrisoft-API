<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["User","Center","Reception"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "username no blank")]
    #[Assert\Length(min: 6)]
    #[Groups(["User","Center","Reception"])]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Groups(["User","Center","Reception"])]
    private ?string $email = null;

    #[ORM\Column(type: Types::JSON)]
    private array $roles = [];

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[Assert\NotBlank]
    #[Assert\Expression("this.getPassword() === this.getRetypedPassword()",message: "Password does not match")]
    private ?string $retypedPassword = null;

    #[ORM\Column(length: 255)]
    #[Groups(["User","Center","Reception"])]
    private ?string $Firstname = null;

    #[ORM\Column(length: 255)]
    #[Groups(["User","Center","Reception"])]
    private ?string $Lastname = null;

    #[ORM\Column(options: ['default'=>'CURRENT_TIMESTAMP'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $deletedAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

//    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Center::class)]
//    private Collection $centers;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: Reception::class)]
    private Collection $receptions;

    #[ORM\OneToMany(mappedBy: 'user_id', targetEntity: UserCenter::class, orphanRemoval: true)]
    #[Groups(["User"])]
    private Collection $userCenters;

    public function __construct()
    {
//        $this->centers = new ArrayCollection();
        $this->receptions = new ArrayCollection();
        $this->userCenters = new ArrayCollection();
        $this->createdAt = new \DateTimeImmutable("now");
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;

        if (empty($roles)) {
            $roles[] = 'ROLE_USER';
        }

        return array_unique($roles);
    }

    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

//    public function getRoles(): array
//    {
//        return ['ROLE_USER'];
//    }

    public function eraseCredentials()
    {
        return null;
    }

    public function getUserIdentifier(): string
    {
        return $this->username;
    }

    public function getRetypedPassword(): ?string
    {
        return $this->retypedPassword;
    }

    public function setRetypedPassword(?string $retypedPassword): void
    {
        $this->retypedPassword = $retypedPassword;
    }

    public function getFirstname(): ?string
    {
        return $this->Firstname;
    }

    public function setFirstname(string $Firstname): self
    {
        $this->Firstname = $Firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->Lastname;
    }

    public function setLastname(string $Lastname): self
    {
        $this->Lastname = $Lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deletedAt;
    }

    public function setDeletedAt(?\DateTimeImmutable $deletedAt): self
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

//    /**
//     * @return Collection<int, Center>
//     */
//    public function getCenters(): Collection
//    {
//        return $this->centers;
//    }

//    public function addCenter(Center $center): self
//    {
//        if (!$this->centers->contains($center)) {
//            $this->centers->add($center);
//            $center->setUserId($this);
//        }
//
//        return $this;
//    }
//
//    public function removeCenter(Center $center): self
//    {
//        if ($this->centers->removeElement($center)) {
//            // set the owning side to null (unless already changed)
//            if ($center->getUserId() === $this) {
//                $center->setUserId(null);
//            }
//        }
//
//        return $this;
//    }

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
            $reception->setUserId($this);
        }

        return $this;
    }

    public function removeReception(Reception $reception): self
    {
        if ($this->receptions->removeElement($reception)) {
            // set the owning side to null (unless already changed)
            if ($reception->getUserId() === $this) {
                $reception->setUserId(null);
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
            $userCenter->setUserId($this);
        }

        return $this;
    }

    public function removeUserCenter(UserCenter $userCenter): self
    {
        if ($this->userCenters->removeElement($userCenter)) {
            // set the owning side to null (unless already changed)
            if ($userCenter->getUserId() === $this) {
                $userCenter->setUserId(null);
            }
        }

        return $this;
    }

}
