<?php

namespace App\Entity;

use App\Repository\ThumbRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThumbRepository::class)
 */
class Thumb
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $oldName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $newName;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="thumb", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOldName(): ?string
    {
        return $this->oldName;
    }

    public function setOldName(string $oldName): self
    {
        $this->oldName = $oldName;

        return $this;
    }

    public function getNewName(): ?string
    {
        return $this->newName;
    }

    public function setNewName(string $newName): self
    {
        $this->newName = $newName;

        return $this;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        // unset the owning side of the relation if necessary
        if ($user === null && $this->user !== null) {
            $this->user->setThumb(null);
        }

        // set the owning side of the relation if necessary
        if ($user !== null && $user->getThumb() !== $this) {
            $user->setThumb($this);
        }

        $this->user = $user;

        return $this;
    }

    public function __toString(): string
    {
        return $this->newName;
    }
}