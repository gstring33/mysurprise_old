<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $username;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastname;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isSelected;

    /**
     * @ORM\OneToOne(targetEntity=User::class)
     */
    private $selectedUser;

    /**
     * @ORM\OneToOne(targetEntity=GiftsList::class, cascade={"persist", "remove"})
     */
    private $giftsList;

    /**
     * @ORM\Column(type="boolean", options={"default": 0})
     */
    private $isAllowedToSelectUser;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $hash;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFirstConnection;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        return array_unique($this->roles);
    }

    public function setRoles(array $roles): self
    {
        $roles[] = 'ROLE_USER';
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * @see UserInterface
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getIsSelected(): ?bool
    {
        return $this->isSelected;
    }

    public function setIsSelected(bool $isSelected): self
    {
        $this->isSelected = $isSelected;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSelectedUser(): ?self
    {
        return $this->selectedUser;
    }

    public function setSelectedUser(?self $selectedUser): self
    {
        $this->selectedUser = $selectedUser;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getGiftsList(): ?GiftsList
    {
        return $this->giftsList;
    }

    public function setGiftsList(?GiftsList $giftsList): self
    {
        $this->giftsList = $giftsList;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getIsAllowedToSelectUser(): ?bool
    {
        return $this->isAllowedToSelectUser;
    }

    /**
     * @see UserInterface
     */
    public function setIsAllowedToSelectUser(bool $isAllowedToSelectUser): self
    {
        $this->isAllowedToSelectUser = $isAllowedToSelectUser;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function setHash(string $hash): self
    {
        $this->hash = $hash;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @see UserInterface
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getIsFirstConnection(): ?bool
    {
        return $this->isFirstConnection;
    }

    /**
     * @see UserInterface
     */
    public function setIsFirstConnection(bool $isFirstConnection): self
    {
        $this->isFirstConnection = $isFirstConnection;

        return $this;
    }
}
