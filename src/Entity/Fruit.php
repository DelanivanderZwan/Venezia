<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FruitRepository")
 */
class Fruit
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $naam;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $seizoen;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ijsrecept", mappedBy="fruit")
     */
    private $fruit;

    public function __construct()
    {
        $this->fruit = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNaam(): ?string
    {
        return $this->naam;
    }

    public function setNaam(string $naam): self
    {
        $this->naam = $naam;

        return $this;
    }

    public function getSeizoen(): ?string
    {
        return $this->seizoen;
    }

    public function setSeizoen(string $seizoen): self
    {
        $this->seizoen = $seizoen;

        return $this;
    }

    /**
     * @return Collection|ijsrecept[]
     */
    public function getFruit(): Collection
    {
        return $this->fruit;
    }

    public function addFruit(ijsrecept $fruit): self
    {
        if (!$this->fruit->contains($fruit)) {
            $this->fruit[] = $fruit;
            $fruit->setFruit($this);
        }

        return $this;
    }

    public function removeFruit(ijsrecept $fruit): self
    {
        if ($this->fruit->contains($fruit)) {
            $this->fruit->removeElement($fruit);
            // set the owning side to null (unless already changed)
            if ($fruit->getFruit() === $this) {
                $fruit->setFruit(null);
            }
        }

        return $this;
    }
}
