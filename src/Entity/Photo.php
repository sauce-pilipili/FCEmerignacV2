<?php

namespace App\Entity;

use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PhotoRepository::class)
 */
class Photo
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
     * @ORM\OneToOne(targetEntity=Equipe::class, mappedBy="photoEquipe")
     */
    private $equipe;

    /**
     * @ORM\OneToOne(targetEntity=Articles::class, mappedBy="photoEnAvant",orphanRemoval=true, cascade={"persist", "remove"})
     */
    private $articlesPhotoEnAvant;

    /**
     * @ORM\ManyToOne(targetEntity=Articles::class, inversedBy="photoFond")
     */
    private $articlePhotoFond;

    /**
     * @ORM\ManyToOne(targetEntity=Albums::class, inversedBy="images")
     */
    private $albums;

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

    public function getEquipe(): ?Equipe
    {
        return $this->equipe;
    }

    public function setEquipe(?Equipe $equipe): self
    {
        // unset the owning side of the relation if necessary
        if ($equipe === null && $this->equipe !== null) {
            $this->equipe->setPhotoEquipe(null);
        }

        // set the owning side of the relation if necessary
        if ($equipe !== null && $equipe->getPhotoEquipe() !== $this) {
            $equipe->setPhotoEquipe($this);
        }

        $this->equipe = $equipe;

        return $this;
    }

    public function getArticlesPhotoEnAvant(): ?Articles
    {
        return $this->articlesPhotoEnAvant;
    }

    public function setArticlesPhotoEnAvant(?Articles $articlesPhotoEnAvant): self
    {
        // unset the owning side of the relation if necessary
        if ($articlesPhotoEnAvant === null && $this->articlesPhotoEnAvant !== null) {
            $this->articlesPhotoEnAvant->setPhotoEnAvant(null);
        }

        // set the owning side of the relation if necessary
        if ($articlesPhotoEnAvant !== null && $articlesPhotoEnAvant->getPhotoEnAvant() !== $this) {
            $articlesPhotoEnAvant->setPhotoEnAvant($this);
        }

        $this->articlesPhotoEnAvant = $articlesPhotoEnAvant;

        return $this;
    }

    public function getArticlePhotoFond(): ?Articles
    {
        return $this->articlePhotoFond;
    }

    public function setArticlePhotoFond(?Articles $articlePhotoFond): self
    {
        $this->articlePhotoFond = $articlePhotoFond;

        return $this;
    }

    public function getAlbums(): ?Albums
    {
        return $this->albums;
    }

    public function setAlbums(?Albums $albums): self
    {
        $this->albums = $albums;

        return $this;
    }
    public function __toString(){
        return $this->getName();
    }
}
