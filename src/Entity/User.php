<?php

namespace App\Entity;

use App\Repository\UserRepository;
use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Il y a déjà un compte avec cette email')]
#[Vich\Uploadable]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\NotBlank]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $lastName = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $birthday = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $country = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Music::class)]
    private Collection $music;

    #[ORM\ManyToMany(targetEntity: Music::class, inversedBy: 'numberFavorie')]
    private Collection $favorite;

    #[ORM\ManyToMany(targetEntity: Type::class, mappedBy: 'Favorite')]
    private Collection $favoriteType;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'images_user', fileNameProperty: 'picture')]
    #[Assert\File(
        maxSize: '2M',
        mimeTypes: ['image/jpeg', 'image/png', 'image/webp', 'image/gif', 'image/jpg'],
    )]
    private ?File $imagesUser = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private ?string $speudo = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'LikeMe')]
    private Collection $likeByMe;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'likeByMe')]
    private Collection $LikeMe;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Playlist::class)]
    private Collection $playlists;

    public function __construct()
    {
        $this->music = new ArrayCollection();
        $this->favorite = new ArrayCollection();
        $this->favoriteType = new ArrayCollection();
        $this->likeByMe = new ArrayCollection();
        $this->LikeMe = new ArrayCollection();
        $this->playlists = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    public function setBirthday(?\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(?string $country): static
    {
        $this->country = $country;

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
            $music->setUser($this);
        }

        return $this;
    }

    public function removeMusic(Music $music): static
    {
        if ($this->music->removeElement($music)) {
            // set the owning side to null (unless already changed)
            if ($music->getUser() === $this) {
                $music->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Music>
     */
    public function getFavorite(): Collection
    {
        return $this->favorite;
    }

    public function addFavorite(Music $favorite): static
    {
        if (!$this->favorite->contains($favorite)) {
            $this->favorite->add($favorite);
        }

        return $this;
    }

    public function removeFavorite(Music $favorite): static
    {
        $this->favorite->removeElement($favorite);

        return $this;
    }
    public function isInFavorite(Music $music): bool
    {
        if (in_array($music, $this->getFavorite()->toArray())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Collection<int, Type>
     */
    public function getFavoriteType(): Collection
    {
        return $this->favoriteType;
    }

    public function addFavoriteType(Type $favoriteType): static
    {
        if (!$this->favoriteType->contains($favoriteType)) {
            $this->favoriteType->add($favoriteType);
            $favoriteType->addFavorite($this);
        }

        return $this;
    }

    public function removeFavoriteType(Type $favoriteType): static
    {
        if ($this->favoriteType->removeElement($favoriteType)) {
            $favoriteType->removeFavorite($this);
        }

        return $this;
    }

    public function isInFavoriteType(Type $type): bool
    {
        if (in_array($type, $this->getFavoriteType()->toArray())) {
            return true;
        } else {
            return false;
        }
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function setImagesUser(File $imagesUser = null): User
    {
        $this->imagesUser = $imagesUser;
        if ($imagesUser) {
          $this->updatedAt = new DateTime('now');
        }
    
        return $this;
    }

    public function getImagesUser(): ?File
    {
        return $this->imagesUser;
    }

    public function getSpeudo(): ?string
    {
        return $this->speudo;
    }

    public function setSpeudo(string $speudo): static
    {
        $this->speudo = $speudo;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getLikeByMe(): Collection
    {
        return $this->likeByMe;
    }

    public function addLikeByMe(self $likeByMe): static
    {
        if (!$this->likeByMe->contains($likeByMe)) {
            $this->likeByMe->add($likeByMe);
        }

        return $this;
    }

    public function removeLikeByMe(self $likeByMe): static
    {
        $this->likeByMe->removeElement($likeByMe);

        return $this;
    }

    public function isInLikeByMe(User $user): bool
    {
        if (in_array($user, $this->getLikeByMe()->toArray())) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return Collection<int, self>
     */
    public function getLikeMe(): Collection
    {
        return $this->LikeMe;
    }

    public function addLikeMe(self $likeMe): static
    {
        if (!$this->LikeMe->contains($likeMe)) {
            $this->LikeMe->add($likeMe);
            $likeMe->addLikeByMe($this);
        }

        return $this;
    }

    public function removeLikeMe(self $likeMe): static
    {
        if ($this->LikeMe->removeElement($likeMe)) {
            $likeMe->removeLikeByMe($this);
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
            $playlist->setUser($this);
        }

        return $this;
    }

    public function removePlaylist(Playlist $playlist): static
    {
        if ($this->playlists->removeElement($playlist)) {
            // set the owning side to null (unless already changed)
            if ($playlist->getUser() === $this) {
                $playlist->setUser(null);
            }
        }

        return $this;
    }
}
