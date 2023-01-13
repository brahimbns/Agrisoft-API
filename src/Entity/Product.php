<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["Product","Reception"])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(["Product","Reception"])]
    private ?string $code_product = null;

    #[ORM\Column(length: 255)]
    #[Groups(["Product","Reception"])]
    private ?string $label = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(["Product","Reception"])]
    private ?PriceProduct $price = null;

    #[ORM\OneToMany(mappedBy: 'product_id', targetEntity: Reception::class)]
    private Collection $receptions;

    public function __construct()
    {
        $this->receptions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodeProduct(): ?string
    {
        return $this->code_product;
    }

    public function setCodeProduct(string $code_product): self
    {
        $this->code_product = $code_product;

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

    public function getPrice(): ?PriceProduct
    {
        return $this->price;
    }

    public function setPrice(?PriceProduct $price): self
    {
        $this->price = $price;

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
            $reception->setProductId($this);
        }

        return $this;
    }

    public function removeReception(Reception $reception): self
    {
        if ($this->receptions->removeElement($reception)) {
            // set the owning side to null (unless already changed)
            if ($reception->getProductId() === $this) {
                $reception->setProductId(null);
            }
        }

        return $this;
    }
}
