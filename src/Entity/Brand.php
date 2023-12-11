<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
#[ApiResource]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Groups(['read:allBrandModel'])]
    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'brand', targetEntity: BrandModel::class, cascade: ['persist', 'remove'])]
    private Collection $Models;


    //

    public function __construct()
    {
        $this->Models = new ArrayCollection();
    }

    // to string

    public function __toString()
    {
        return $this->getLabel();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, BrandModel>
     */
    public function getModels(): Collection
    {
        return $this->Models;
    }

    public function addModel(BrandModel $model): static
    {
        if (!$this->Models->contains($model)) {
            $this->Models->add($model);
            $model->setBrand($this);
        }

        return $this;
    }

    public function removeModel(BrandModel $model): static
    {
        if ($this->Models->removeElement($model)) {
            // set the owning side to null (unless already changed)
            if ($model->getBrand() === $this) {
                $model->setBrand(null);
            }
        }

        return $this;
    }
}
