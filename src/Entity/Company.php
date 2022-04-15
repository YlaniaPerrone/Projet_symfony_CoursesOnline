<?php

namespace App\Entity;

use App\Repository\CompanyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CompanyRepository::class)]
class Company
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50, unique: true)]
    private $name;

    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $numTVA;

    #[ORM\OneToMany(mappedBy: 'company', targetEntity: Trainer::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private $trainers;


    public function __construct()
    {
        $this->trainers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getNumTVA(): ?string
    {
        return $this->numTVA;
    }

    public function setNumTVA(string $numTVA): self
    {
        $this->numTVA = $numTVA;

        return $this;
    }



    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return Collection<int, Trainer>
     */
    public function getTrainers(): Collection
    {
        return $this->trainers;
    }

    public function addTrainer(Trainer $trainer): self
    {
        if (!$this->trainers->contains($trainer)) {
            $this->trainers[] = $trainer;
            $trainer->setCompany($this);
        }

        return $this;
    }

    public function removeTrainer(Trainer $trainer): self
    {
        if ($this->trainers->removeElement($trainer)) {
            // set the owning side to null (unless already changed)
            if ($trainer->getCompany() === $this) {
                $trainer->setCompany(null);
            }
        }

        return $this;
    }

}
