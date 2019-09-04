<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DonneurRepository")
 */
class Donneur
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="integer")
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Email(
     *     message = "Ce mail n'est pas valide.",
     *     checkMX = true
     * )
     */
    private $email;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\AmountDonate", mappedBy="IdDonneur")
     */
    private $IdAmount;

    public function __construct()
    {
        $this->IdAmount = new ArrayCollection();
    }

   
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getTelephone(): ?int
    {
        return $this->telephone;
    }

    public function setTelephone(int $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection|AmountDonate[]
     */
    public function getIdAmount(): Collection
    {
        return $this->IdAmount;
    }

    public function addIdAmount(AmountDonate $idAmount): self
    {
        if (!$this->IdAmount->contains($idAmount)) {
            $this->IdAmount[] = $idAmount;
            $idAmount->setIdDonneur($this);
        }

        return $this;
    }

    public function removeIdAmount(AmountDonate $idAmount): self
    {
        if ($this->IdAmount->contains($idAmount)) {
            $this->IdAmount->removeElement($idAmount);
            // set the owning side to null (unless already changed)
            if ($idAmount->getIdDonneur() === $this) {
                $idAmount->setIdDonneur(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return (string)$this->getId();
    }
}
