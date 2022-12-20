<?php

namespace App\Entity;


use App\Repository\PriceProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PriceProductRepository::class)]

class PriceProduct
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $base_price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_base_price_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_base_price_end = null;

    #[ORM\Column]
    private ?float $prime_price = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_prime_price_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_prime_price_end = null;

    #[ORM\Column]
    private ?float $solidarity_tax = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_solidarity_tax_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_solidarity_tax_end = null;

    #[ORM\Column]
    private ?float $statistical_tax = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_statistical_tax_start = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $date_statistical_tax_end = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBasePrice(): ?float
    {
        return $this->base_price;
    }

    public function setBasePrice(float $base_price): self
    {
        $this->base_price = $base_price;

        return $this;
    }

    public function getDateBasePriceStart(): ?\DateTimeInterface
    {
        return $this->date_base_price_start;
    }

    public function setDateBasePriceStart(\DateTimeInterface $date_base_price_start): self
    {
        $this->date_base_price_start = $date_base_price_start;

        return $this;
    }

    public function getDateBasePriceEnd(): ?\DateTimeInterface
    {
        return $this->date_base_price_end;
    }

    public function setDateBasePriceEnd(\DateTimeInterface $date_base_price_end): self
    {
        $this->date_base_price_end = $date_base_price_end;

        return $this;
    }

    public function getPrimePrice(): ?float
    {
        return $this->prime_price;
    }

    public function setPrimePrice(float $prime_price): self
    {
        $this->prime_price = $prime_price;

        return $this;
    }

    public function getDatePrimePriceStart(): ?\DateTimeInterface
    {
        return $this->date_prime_price_start;
    }

    public function setDatePrimePriceStart(\DateTimeInterface $date_prime_price_start): self
    {
        $this->date_prime_price_start = $date_prime_price_start;

        return $this;
    }

    public function getDatePrimePriceEnd(): ?\DateTimeInterface
    {
        return $this->date_prime_price_end;
    }

    public function setDatePrimePriceEnd(\DateTimeInterface $date_prime_price_end): self
    {
        $this->date_prime_price_end = $date_prime_price_end;

        return $this;
    }

    public function getSolidarityTax(): ?float
    {
        return $this->solidarity_tax;
    }

    public function setSolidarityTax(float $solidarity_tax): self
    {
        $this->solidarity_tax = $solidarity_tax;

        return $this;
    }

    public function getDateSolidarityTaxStart(): ?\DateTimeInterface
    {
        return $this->date_solidarity_tax_start;
    }

    public function setDateSolidarityTaxStart(\DateTimeInterface $date_solidarity_tax_start): self
    {
        $this->date_solidarity_tax_start = $date_solidarity_tax_start;

        return $this;
    }

    public function getDateSolidarityTaxEnd(): ?\DateTimeInterface
    {
        return $this->date_solidarity_tax_end;
    }

    public function setDateSolidarityTaxEnd(\DateTimeInterface $date_solidarity_tax_end): self
    {
        $this->date_solidarity_tax_end = $date_solidarity_tax_end;

        return $this;
    }

    public function getStatisticalTax(): ?float
    {
        return $this->statistical_tax;
    }

    public function setStatisticalTax(float $statistical_tax): self
    {
        $this->statistical_tax = $statistical_tax;

        return $this;
    }

    public function getDateStatisticalTaxStart(): ?\DateTimeInterface
    {
        return $this->date_statistical_tax_start;
    }

    public function setDateStatisticalTaxStart(\DateTimeInterface $date_statistical_tax_start): self
    {
        $this->date_statistical_tax_start = $date_statistical_tax_start;

        return $this;
    }

    public function getDateStatisticalTaxEnd(): ?\DateTimeInterface
    {
        return $this->date_statistical_tax_end;
    }

    public function setDateStatisticalTaxEnd(\DateTimeInterface $date_statistical_tax_end): self
    {
        $this->date_statistical_tax_end = $date_statistical_tax_end;

        return $this;
    }
}
