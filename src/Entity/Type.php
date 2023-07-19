<?php

namespace App\Entity;

use App\Repository\TypeRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TypeRepository::class)]
#[Vich\Uploadable]
class Type
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Music::class)]
    private Collection $music;

    #[ORM\Column(length: 255)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'images_type', fileNameProperty: 'picture')]
    private ?File $imagesType = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\ManyToMany(targetEntity: User::class, inversedBy: 'favoriteType')]
    private Collection $Favorite;

    public function __construct()
    {
        $this->music = new ArrayCollection();
        $this->Favorite = new ArrayCollection();
    }
    public function setImagesType(File $imagesType = null): Type
    {
        $this->imagesType = $imagesType;
        if ($imagesType) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }
    public function getImageType(): ?File
    {
        return $this->imagesType;
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

    /**
     * @return Collection<int, Music>
     */
    public function getMusic(): Collection
    {
        return $this->music;
    }

    public function addMusic(Music $music): static
    {
        if (!$this->music->contains($music)) {
            $this->music->add($music);
            $music->setType($this);
        }

        return $this;
    }

    public function removeMusic(Music $music): static
    {
        if ($this->music->removeElement($music)) {
            // set the owning side to null (unless already changed)
            if ($music->getType() === $this) {
                $music->setType(null);
            }
        }

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getFavorite(): Collection
    {
        return $this->Favorite;
    }

    public function addFavorite(User $favorite): static
    {
        if (!$this->Favorite->contains($favorite)) {
            $this->Favorite->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(User $favorite): static
    {
        $this->Favorite->removeElement($favorite);

        return $this;
    }
}
