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
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $size;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isMain;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="thumbs", cascade={"persist"})
     */
    private $trick;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="thumb", cascade={"persist", "remove"})
     */
    private $user;

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
     * @return int
     */
    public function getSize(): int
    {
        return $this->size;
    }

    /**
     * @param int $size
     * @return $this
     */
    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    /**
     * @return ?boolean
     */
    public function getIsMain(): ?bool
    {
        return $this->isMain;
    }

    /**
     * @param bool $isMain
     * @return $this
     */
    public function setIsMain(bool $isMain): self
    {
        $this->$isMain = $isMain;

        return $this;
    }

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    /**
     * @param Trick|null $trick
     * @return $this
     */
    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

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
}
