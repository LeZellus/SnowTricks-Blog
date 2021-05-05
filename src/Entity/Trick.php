<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TrickRepository::class)
 */
class Trick
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Video::class, mappedBy="trick")
     */
    private $videos;

    /**
     * @ORM\ManyToMany(targetEntity=Category::class, inversedBy="tricks")
     */
    private $categories;

    /**
     * @ORM\OneToMany(targetEntity=Thumb::class, mappedBy="trick")
     */
    private $thumbs;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\OneToOne(targetEntity=Thumb::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $mainThumb;

    public function __construct()
    {
        $this->videos = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->thumbs = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Video[]
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Video $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos[] = $video;
            $video->setTrick($this);
        }

        return $this;
    }

    public function removeVideo(Video $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getTrick() === $this) {
                $video->setTrick(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
        }

        return $this;
    }

    public function removeCategory(Category $category): self
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection|Thumb[]
     */
    public function getThumbs(): Collection
    {
        return $this->thumbs;
    }

    public function addThumb(Thumb $thumb): self
    {
        if (!$this->thumbs->contains($thumb)) {
            $this->thumbs[] = $thumb;
            $thumb->setTrick($this);
        }

        return $this;
    }

    public function removeThumb(Thumb $thumb): self
    {
        if ($this->thumbs->removeElement($thumb)) {
            // set the owning side to null (unless already changed)
            if ($thumb->getTrick() === $this) {
                $thumb->setTrick(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getMainThumb(): ?Thumb
    {
        return $this->mainThumb;
    }

    public function setMainThumb(Thumb $mainThumb): self
    {
        $this->mainThumb = $mainThumb;

        return $this;
    }
}
