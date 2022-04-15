<?php

namespace App\Entity;

use App\Entity\Trainer;

use App\Repository\CoursRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: CoursRepository::class)]
class Cours
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[Assert\Length(min: 2, max: 255)]
    #[ORM\Column(type: 'string', length: 255, unique: true)]
    private $Title;

    #[Assert\Positive]
    #[ORM\Column(type: 'integer')]
    private $level;

    #[ORM\Column(type: 'float')]
    private $price;

    #[Assert\Positive]
    #[ORM\Column(type: 'integer')]
    private $nbrSession;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'time')]
    private $Duration;

    #[ORM\Column(type: 'string', length: 800)]
    private $Description;

    #[Assert\NotBlank]
    #[ORM\Column(type: 'datetime')]
    private $Date;

    #[ORM\ManyToOne(targetEntity: Language::class, cascade: ['persist', 'remove'], inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: false)]
    private $language;

    #[ORM\ManyToOne(targetEntity: Trainer::class, cascade: ['persist', 'remove'], inversedBy: 'cours')]
    #[ORM\JoinColumn(nullable: true)]
    private $trainer;

    #[ORM\OneToMany(mappedBy: 'cours', targetEntity: Prestation::class, cascade: ['persist', 'remove'])]
    private $prestations;

    #[ORM\OneToOne(inversedBy: 'cours', targetEntity: Category::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'trainer', targetEntity: Cours::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $cours;

    public function __construct()
    {
        $this->prestations = new ArrayCollection();
        $this->cours = new ArrayCollection();

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


    public function getTrainer(): ?Trainer
    {
        return $this->trainer;
    }

    public function setTrainer(?Trainer $trainer): self
    {
        $this->trainer = $trainer;

        return $this;
    }

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

    /**
     * @return Collection<int, Cours>
     */
    public function getCours(): Collection
    {
        return $this->cours;
    }

    public function addCour(Cours $cour): self
    {
        if (!$this->cours->contains($cour)) {
            $this->cours[] = $cour;
            $cour->setTrainer($this);
        }

        return $this;
    }

    public function removeCour(Cours $cour): self
    {
        if ($this->cours->removeElement($cour)) {
            // set the owning side to null (unless already changed)
            if ($cour->getTrainer() === $this) {
                $cour->setTrainer(null);
            }
        }

        return $this;
    }

}
