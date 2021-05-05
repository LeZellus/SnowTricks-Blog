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
     * @ORM\ManyToOne(targetEntity=Trick::class, inversedBy="thumbs")
     */
    private $trick;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $path;

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

    public function getTrick(): ?Trick
    {
        return $this->trick;
    }

    public function setTrick(?Trick $trick): self
    {
        $this->trick = $trick;

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
