<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="users")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Chat::class, inversedBy="users")
     * @ORM\JoinTable(name="users_chats")
     */
    private $chats;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainChat;

    /**
     * @ORM\OneToMany(targetEntity=Chat::class, mappedBy="admin")
     */
    private $administratedChats;

    public function __construct()
    {
        $this->chats = new ArrayCollection();
        $this->administratedChats = new ArrayCollection();
    }

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

    /**
     * @return Collection|Chat[]
     */
    public function getChats(): Collection
    {
        return $this->chats;
    }

    public function addChat(Chat $chat): self
    {
        if (!$this->chats->contains($chat)) {
            $this->chats[] = $chat;
        }

        return $this;
    }

    public function removeChat(Chat $chat): self
    {
        $this->chats->removeElement($chat);

        return $this;
    }

    public function getMainChat(): ?Chat
    {
        return $this->mainChat;
    }

    public function setMainChat(?Chat $mainChat): self
    {
        $this->mainChat = $mainChat;

        return $this;
    }

    /**
     * @return Collection|Chat[]
     */
    public function getAdministratedChats(): Collection
    {
        return $this->administratedChats;
    }

    public function addAdministratedChat(Chat $administratedChat): self
    {
        if (!$this->administratedChats->contains($administratedChat)) {
            $this->administratedChats[] = $administratedChat;
            $administratedChat->setAdmin($this);
        }

        return $this;
    }

    public function removeAdministratedChat(Chat $administratedChat): self
    {
        if ($this->administratedChats->removeElement($administratedChat)) {
            // set the owning side to null (unless already changed)
            if ($administratedChat->getAdmin() === $this) {
                $administratedChat->setAdmin(null);
            }
        }

        return $this;
    }

    public function __toString():string
    {
        return $this->getName() . " : ". $this->getId();
    }
}
