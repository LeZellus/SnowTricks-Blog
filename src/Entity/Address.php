<?php

namespace App\Entity;

use App\Repository\AddressRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddressRepository::class)
 */
class Address
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $postalcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $street;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="address", cascade={"persist", "remove"})
     */
    private $User;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getPostalcode(): ?int
    {
        return $this->postalcode;
    }

    /**
     * @param int|null $postalcode
     * @return $this
     */
    public function setPostalcode(?int $postalcode): self
    {
        $this->postalcode = $postalcode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string $city
     * @return $this
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * @param string|null $street
     * @return $this
     */
    public function setStreet(?string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->User;
    }

    /**
     * @param User|null $User
     * @return $this
     */
    public function setUser(?User $User): self
    {
        $this->User = $User;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->street . ', ' . $this->city . ', ' . $this->postalcode;
    }
}
