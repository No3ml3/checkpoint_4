<?php

namespace App\Entity;

use App\Repository\MusicRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MusicRepository::class)]
class Music
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'music')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Type $type = null;

    #[ORM\Column(length: 255)]
    private ?string $audio = null;

    #[ORM\ManyToOne(inversedBy: 'music')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favorite')]
    #[ORM\JoinTable(name:'numberFavorie')]
    private Collection $numberFavorie;

    public function __construct()
    {
        $this->numberFavorie = new ArrayCollection();
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

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getAudio(): ?string
    {
        return $this->audio;
    }

    public function setAudio(string $audio): static
    {
        $this->audio = $audio;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getNumberFavorie(): Collection
    {
        return $this->numberFavorie;
    }

    public function addNumberFavorie(User $numberFavorie): static
    {
        if (!$this->numberFavorie->contains($numberFavorie)) {
            $this->numberFavorie->add($numberFavorie);
            $numberFavorie->addFavorite($this);
        }

        return $this;
    }

    public function removeNumberFavorie(User $numberFavorie): static
    {
        if ($this->numberFavorie->removeElement($numberFavorie)) {
            $numberFavorie->removeFavorite($this);
        }

        return $this;
    }
}
