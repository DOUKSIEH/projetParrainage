<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AmountDonateRepository")
 */
class AmountDonate
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $Somme;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DonnationDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Donneur", inversedBy="IdAmount")
     * @ORM\JoinColumn(nullable=false)
     */
    private $IdDonneur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSomme(): ?int
    {
        return $this->Somme;
    }

    public function setSomme(int $Somme): self
    {
        $this->Somme = $Somme;

        return $this;
    }

    public function getDonnationDate(): ?\DateTimeInterface
    {
        return $this->DonnationDate;
    }

    public function setDonnationDate(\DateTimeInterface $DonnationDate): self
    {
        $this->DonnationDate = $DonnationDate;

        return $this;
    }

    public function getIdDonneur(): ?Donneur
    {
        return $this->IdDonneur;
    }

    public function setIdDonneur(?Donneur $IdDonneur): self
    {
        $this->IdDonneur = $IdDonneur;

        return $this;
    }
}
