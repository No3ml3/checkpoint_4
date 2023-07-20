<?php

namespace App\Entity;

use App\Repository\MusicRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MusicRepository::class)]
#[Vich\Uploadable]
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

    #[Vich\UploadableField(mapping: 'audio_musics', fileNameProperty: 'audio')]
    #[Assert\File(
        maxSize: '2M',
        extensions: ['mp3', 'mp4'],
    )]
    private ?File $audioMusics = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'music')]
    #[ORM\JoinColumn(nullable: true)]
    private ?User $user = null;

    #[ORM\ManyToMany(targetEntity: User::class, mappedBy: 'favorite')]
    #[ORM\JoinTable(name: 'numberFavorie')]
    private Collection $numberFavorie;

    #[ORM\ManyToMany(targetEntity: Playlist::class, mappedBy: 'musics')]
    private Collection $playlists;

    public function __construct()
    {
        $this->numberFavorie = new ArrayCollection();
        $this->playlists = new ArrayCollection();
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

    public function setAudioMusics(File $audioMusics = null): Music
    {
        $this->audioMusics = $audioMusics;
        if ($audioMusics) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    public function getAudioMusics(): ?File
    {
        return $this->audioMusics;
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

    /**
     * @return Collection<int, Playlist>
     */
    public function getPlaylists(): Collection
    {
        return $this->playlists;
    }

    public function addPlaylist(Playlist $playlist): static
    {
        if (!$this->playlists->contains($playlist)) {
            $this->playlists->add($playlist);
            $playlist->addMusic($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            $playlist->removeMusic($this);
        }

        return $this;
    }
}
