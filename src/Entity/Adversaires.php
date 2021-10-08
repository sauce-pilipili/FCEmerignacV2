<?php

namespace App\Entity;

use App\Repository\AdversairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AdversairesRepository::class)
 */
class Adversaires
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
    private $nom;

    /**
     * @ORM\OneToOne(targetEntity=Photo::class, cascade={"persist", "remove"})
     */
    private $logo;

    /**
     * @ORM\OneToMany(targetEntity=MatchAVenir::class, mappedBy="adversaire")
     */
    private $matchAVenirs;

    public function __construct()
    {
        $this->matchAVenirs = new ArrayCollection();
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

    public function getLogo(): ?photo
    {
        return $this->logo;
    }

    public function setLogo(?photo $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    /**
     * @return Collection|MatchAVenir[]
     */
    public function getMatchAVenirs(): Collection
    {
        return $this->matchAVenirs;
    }

    public function addMatchAVenir(MatchAVenir $matchAVenir): self
    {
        if (!$this->matchAVenirs->contains($matchAVenir)) {
            $this->matchAVenirs[] = $matchAVenir;
            $matchAVenir->setAdversaire($this);
        }

        return $this;
    }

    public function removeMatchAVenir(MatchAVenir $matchAVenir): self
    {
        if ($this->matchAVenirs->removeElement($matchAVenir)) {
            // set the owning side to null (unless already changed)
            if ($matchAVenir->getAdversaire() === $this) {
                $matchAVenir->setAdversaire(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getNom();
    }
}
