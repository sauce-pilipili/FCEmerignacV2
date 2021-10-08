<?php

namespace App\Entity;

use App\Repository\AlbumsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AlbumsRepository::class)
 */
class Albums
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
     * @ORM\ManyToOne(targetEntity=SubGalery::class, inversedBy="albums")
     * @ORM\JoinColumn(nullable=false)
     */
    private $subGalery;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="albums",cascade={"persist","remove"})
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
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

    public function getSubGalery(): ?SubGalery
    {
        return $this->subGalery;
    }

    public function setSubGalery(?SubGalery $subGalery): self
    {
        $this->subGalery = $subGalery;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Photo $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setAlbums($this);
        }

        return $this;
    }

    public function removeImage(Photo $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getAlbums() === $this) {
                $image->setAlbums(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getName();
    }


}
