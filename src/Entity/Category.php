<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $name;

    #[ORM\OneToOne(mappedBy: 'category', targetEntity: Cours::class, cascade: ['persist', 'remove'])]
    private $cours;

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

    public function getCours(): ?Cours
    {
        return $this->cours;
    }

    public function setCours(Cours $cours): self
    {
        // set the owning side of the relation if necessary
        if ($cours->getCategory() !== $this) {
            $cours->setCategory($this);
        }

        $this->cours = $cours;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
