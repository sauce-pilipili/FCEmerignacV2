<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=ArticlesRepository::class)
 */
class Articles
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
    private $titre;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdDate;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $introduction;

    /**
     * @Gedmo\Slug(fields={"titre"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $metaDescription;

    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $contenu;

    /**
     * @ORM\OneToOne(targetEntity=Photo::class,inversedBy="articlesPhotoEnAvant", cascade={"persist", "remove"})
     */
    private $photoEnAvant;

    /**
     * @ORM\OneToMany(targetEntity=Photo::class, mappedBy="articlePhotoFond",cascade={"persist","remove"})
     */
    private $photoFond;

    /**
     * @ORM\ManyToOne(targetEntity=Equipe::class, inversedBy="articles")
     */
    private $equipe;

    public function __construct()
    {
        $this->photoFond = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

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

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(?string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }



    public function getMetaDescription(): ?string
    {
        return $this->metaDescription;
    }

    public function setMetaDescription(string $metaDescription): self
    {
        $this->metaDescription = $metaDescription;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(?string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getPhotoEnAvant(): ?Photo
    {
        return $this->photoEnAvant;
    }

    public function setPhotoEnAvant(?Photo $photoEnAvant): self
    {
        $this->photoEnAvant = $photoEnAvant;

        return $this;
    }

    /**
     * @return Collection|Photo[]
     */
    public function getPhotoFond(): Collection
    {
        return $this->photoFond;
    }

    public function addPhotoFond(Photo $photoFond): self
    {
        if (!$this->photoFond->contains($photoFond)) {
            $this->photoFond[] = $photoFond;
            $photoFond->setArticlePhotoFond($this);
        }

        return $this;
    }

    public function removePhotoFond(Photo $photoFond): self
    {
        if ($this->photoFond->removeElement($photoFond)) {
            // set the owning side to null (unless already changed)
            if ($photoFond->getArticlePhotoFond() === $this) {
                $photoFond->setArticlePhotoFond(null);
            }
        }

        return $this;
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

}
