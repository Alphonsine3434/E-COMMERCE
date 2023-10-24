<?php

namespace App\Entity;

use App\Repository\Back_office\Supplier\SupplierRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: SupplierRepository::class)]
#[UniqueEntity('reference')]
class Supplier
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank]
    #[Assert\Length( min: 2 )]
    private ?string $name = null;

    #[ORM\Column(length: 100, unique: true)]
    #[Assert\NotBlank]
    #[Assert\Length( min: 2 )]
    private ?string $reference = null;

    #[ORM\OneToMany(mappedBy: 'supplier', targetEntity: Brands::class, cascade:["persist", "remove"])]
    private Collection $brands;

    public function __construct()
    {
        $this->brands = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): static
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @return Collection<int, Brands>
     */
    public function getBrands(): Collection
    {
        return $this->brands;
    }

    public function addBrand(Brands $brand): static
    {
        if (!$this->brands->contains($brand)) {
            $this->brands->add($brand);
            $brand->setSupplier($this);
        }

        return $this;
    }

    public function removeBrand(Brands $brand): static
    {
        if ($this->brands->removeElement($brand)) {
            // set the owning side to null (unless already changed)
            if ($brand->getSupplier() === $this) {
                $brand->setSupplier(null);
            }
        }

        return $this;
    }
}
