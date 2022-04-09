<?php

namespace App\Entity;

use App\Entity\Company;
use App\Entity\Trainer;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $Title;

    #[ORM\Column(type: 'integer')]
    private $level;

    #[ORM\Column(type: 'float')]
    private $price;

    #[ORM\Column(type: 'integer')]
    private $nbrSession;

    #[ORM\Column(type: 'time')]
    private $Duration;

    #[ORM\Column(type: 'string', length: 800)]
    private $Description;

    #[ORM\Column(type: 'datetime')]
    private $Date;

    #[ORM\ManyToOne(targetEntity: Language::class, inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    private $language;

    #[ORM\ManyToOne(targetEntity: Trainer::class, inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: true)]
    private $trainer;

//    #[ORM\ManyToOne(targetEntity: Company::class, inversedBy: 'cours')]
//    #[ORM\JoinColumn(nullable: false)]
//    private $company;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Prestation::class)]
    private $prestations;

    #[ORM\OneToOne(inversedBy: 'cours', targetEntity: Category::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $category;


    public function __construct()
    {
        $this->prestations = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->Title;
    }

    public function setTitle(string $Title): self
    {
        $this->Title = $Title;

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(int $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getNbrSession(): ?int
    {
        return $this->nbrSession;
    }

    public function setNbrSession(int $nbrSession): self
    {
        $this->nbrSession = $nbrSession;

        return $this;
    }

    public function getDuration(): ?\DateTimeInterface
    {
        return $this->Duration;
    }

    public function setDuration(\DateTimeInterface $Duration): self
    {
        $this->Duration = $Duration;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->Date;
    }

    public function setDate(\DateTimeInterface $Date): self
    {
        $this->Date = $Date;
//       $this->date = new \DateTime('now');

        return $this;
    }

    public function getLanguage(): ?Language
    {
        return $this->language;
    }

    public function setLanguage(?Language $language): self
    {
        $this->language = $language;

        return $this;
    }



//    public function __toString(): string
//    {
//        return  $this->Title;
//    }

    public function getTrainer(): ?Trainer
    {
        return $this->trainer;
    }

    public function setTrainer(?Trainer $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }
//
//public function getCompany(): ?Company
//{
//    return $this->company;
//}
//
//public function setCompany(?Company $company): self
//{
//    $this->company = $company;
//
//    return $this;
//}

    /**
     * @return Collection<int, Prestation>
     */
    public function getPrestations(): Collection
    {
        return $this->prestations;
    }

    public function addPrestation(Prestation $prestation): self
    {
        if (!$this->prestations->contains($prestation)) {
            $this->prestations[] = $prestation;
            $prestation->setCours($this);
        }

        return $this;
    }

    public function removePrestation(Prestation $prestation): self
    {
        if ($this->prestations->removeElement($prestation)) {
            // set the owning side to null (unless already changed)
            if ($prestation->getCours() === $this) {
                $prestation->setCours(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
      return  $this->Title;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }


}
