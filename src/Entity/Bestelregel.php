<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BestelregelRepository")
 */
class Bestelregel
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $aantal;

    /**
     * @ORM\Column(type="date")
     */
    private $afleverdatum;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Ijsrecept", inversedBy="ijrecept")
     */
    private $ijsrecept;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="user")
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAantal(): ?int
    {
        return $this->aantal;
    }

    public function setAantal(int $aantal): self
    {
        $this->aantal = $aantal;

        return $this;
    }

    public function getAfleverdatum(): ?\DateTimeInterface
    {
        return $this->afleverdatum;
    }

    public function setAfleverdatum(\DateTimeInterface $afleverdatum): self
    {
        $this->afleverdatum = $afleverdatum;

        return $this;
    }

    public function getIjsrecept(): ?Ijsrecept
    {
        return $this->ijsrecept;
    }

    public function setIjsrecept(?Ijsrecept $ijsrecept): self
    {
        $this->ijsrecept = $ijsrecept;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
