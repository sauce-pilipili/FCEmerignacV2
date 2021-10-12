<?php

namespace App\Entity;

use App\Repository\GaleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GaleryRepository::class)
 */
class Galery
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
     * @ORM\Column(type="datetime")
     */
    private $CreatedDate;

    /**
     * @ORM\OneToMany(targetEntity=SubGalery::class, mappedBy="galery", orphanRemoval=true)
     */
    private $subGaleries;

    public function __construct()
    {
        $this->subGaleries = new ArrayCollection();
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

    public function getCreatedDate(): ?\DateTimeInterface
    {
        return $this->CreatedDate;
    }

    public function setCreatedDate(\DateTimeInterface $CreatedDate): self
    {
        $this->CreatedDate = $CreatedDate;

        return $this;
    }

    /**
     * @return Collection|SubGalery[]
     */
    public function getSubGaleries(): Collection
    {
        return $this->subGaleries;
    }

    public function addSubGalery(SubGalery $subGalery): self
    {
        if (!$this->subGaleries->contains($subGalery)) {
            $this->subGaleries[] = $subGalery;
            $subGalery->setGalery($this);
        }

        return $this;
    }

    public function removeSubGalery(SubGalery $subGalery): self
    {
        if ($this->subGaleries->removeElement($subGalery)) {
            // set the owning side to null (unless already changed)
            if ($subGalery->getGalery() === $this) {
                $subGalery->setGalery(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getName();
    }

}
