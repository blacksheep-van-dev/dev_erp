<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\ProductCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductCategoryRepository::class)]
#[ApiResource]
class ProductCategory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $label = null;

    #[ORM\OneToMany(mappedBy: 'productCategory', targetEntity: Product::class)]
    private Collection $products;

    #[ORM\OneToMany(mappedBy: 'productCategory', targetEntity: PriceList::class)]
    private Collection $priceLists;


    // Test Swan
    #[ORM\ManyToOne(inversedBy: 'productCategory')]
    private ?Agency $agency = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;



    public function __construct()
    {
        $this->products = new ArrayCollection();
        $this->priceLists = new ArrayCollection();
  
    }

    // to string
    public function __toString(): string
    {
        return $this->label;
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
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setProductCategory($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getProductCategory() === $this) {
                $product->setProductCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, PriceList>
     */
    public function getPriceLists(): Collection
    {
        return $this->priceLists;
    }

    public function addPriceList(PriceList $priceList): static
    {
        if (!$this->priceLists->contains($priceList)) {
            $this->priceLists->add($priceList);
            $priceList->setProductCategory($this);
        }

        return $this;
    }

    public function removePriceList(PriceList $priceList): static
    {
        if ($this->priceLists->removeElement($priceList)) {
            // set the owning side to null (unless already changed)
            if ($priceList->getProductCategory() === $this) {
                $priceList->setProductCategory(null);
            }
        }

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }



    // Test Swan
    public function getAgency(): ?Agency
    {
        return $this->agency;
    }

    public function setAgency(?Agency $agency): static
    {
        $this->agency = $agency;

        return $this;
    }
}
