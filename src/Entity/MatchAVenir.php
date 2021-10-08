<?php

namespace App\Entity;

use App\Repository\MatchAVenirRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MatchAVenirRepository::class)
 */
class MatchAVenir
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="matchAVenirs")
     */
    private $equipe;

    /**
     * @ORM\Column(type="datetime")
     */
    private $matchDate;

    /**
     * @ORM\ManyToOne(targetEntity=Adversaires::class, inversedBy="matchAVenirs")
     */
    private $adversaire;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        $this->equipe = $equipe;

        return $this;
    }

    public function getMatchDate(): ?\DateTimeInterface
    {
        return $this->matchDate;
    }

    public function setMatchDate(\DateTimeInterface $matchDate): self
    {
        $this->matchDate = $matchDate;

        return $this;
    }

    public function getAdversaire(): ?Adversaires
    {
        return $this->adversaire;
    }

    public function setAdversaire(?Adversaires $adversaire): self
    {
        $this->adversaire = $adversaire;

        return $this;
    }
}
