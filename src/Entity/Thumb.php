<?php

namespace App\Entity;

use App\Repository\ThumbRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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
    private $newName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isMain;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="thumbs")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="thumbs")
     */
    private $trick;

    /**
     * @var UploadedFile
     */
    private $file;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getNewName(): ?string
    {
        return $this->newName;
    }

    /**
     * @param string $newName
     * @return $this
     */
    public function setNewName(string $newName): self
    {
        $this->newName = $newName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return $this
     */
    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->newName;
    }

    /**
     * @return bool|null
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
        $this->isMain = $isMain;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Trick|null
     */
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

    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param UploadedFile $file
     * @return Thumb
     */
    public function setFile(UploadedFile $file): Thumb
    {
        $this->file = $file;
        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}