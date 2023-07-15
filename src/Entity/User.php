<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email')]
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
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
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

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'favoriteArtists')]
    private Collection $favoriteUser;

    #[ORM\ManyToMany(targetEntity: self::class, mappedBy: 'favoriteUser')]
    private Collection $favoriteArtists;

    public function __construct()
    {
        $this->music = new ArrayCollection();
        $this->favorite = new ArrayCollection();
        $this->favoriteType = new ArrayCollection();
        $this->favoriteUser = new ArrayCollection();
        $this->favoriteArtists = new ArrayCollection();
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
}
