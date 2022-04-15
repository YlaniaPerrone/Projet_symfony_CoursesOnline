<?php

namespace App\Entity;

use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CategoryRepository::class)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\NotNull()]
    #[Assert\Length(min: 2, max: 150)]
    #[ORM\Column(type: 'string', length: 150, unique: true)]
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
