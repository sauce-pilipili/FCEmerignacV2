<?php

namespace App\Entity;

use App\Repository\SubGaleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SubGaleryRepository::class)
 */
class SubGalery
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
    private $createdDate;

    /**
     * @ORM\ManyToOne(targetEntity=Galery::class, inversedBy="subGaleries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $galery;

    /**
     * @ORM\OneToMany(targetEntity=Albums::class, mappedBy="subGalery", orphanRemoval=true)
     */
    private $albums;

    public function __construct()
    {
        $this->albums = new ArrayCollection();
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
        return $this->createdDate;
    }

    public function setCreatedDate(\DateTimeInterface $createdDate): self
    {
        $this->createdDate = $createdDate;

        return $this;
    }

    public function getGalery(): ?Galery
    {
        return $this->galery;
    }

    public function setGalery(?Galery $galery): self
    {
        $this->galery = $galery;

        return $this;
    }

    /**
     * @return Collection|Albums[]
     */
    public function getAlbums(): Collection
    {
        return $this->albums;
    }

    public function addAlbum(Albums $album): self
    {
        if (!$this->albums->contains($album)) {
            $this->albums[] = $album;
            $album->setSubGalery($this);
        }

        return $this;
    }

    public function removeAlbum(Albums $album): self
    {
        if ($this->albums->removeElement($album)) {
            // set the owning side to null (unless already changed)
            if ($album->getSubGalery() === $this) {
                $album->setSubGalery(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getName();
    }
}
