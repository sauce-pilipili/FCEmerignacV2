<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
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
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="equipes")
     */
    private $category;

    /**
     * @ORM\OneToOne(targetEntity=Photo::class, inversedBy="equipe", cascade={"persist", "remove"})
     */
    private $photoEquipe;

    /**
     * @ORM\OneToMany(targetEntity=MatchAVenir::class, mappedBy="equipe")
     */
    private $matchAVenirs;

    /**
     * @ORM\OneToMany(targetEntity=Joueurs::class, mappedBy="equipe")
     */
    private $joueurs;

    /**
     * @ORM\OneToMany(targetEntity=Articles::class, mappedBy="equipe")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=1000, nullable=true)
     */
    private $scriptResultat;

    public function __construct()
    {
        $this->matchAVenirs = new ArrayCollection();
        $this->joueurs = new ArrayCollection();
        $this->articles = new ArrayCollection();
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

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPhotoEquipe(): ?Photo
    {
        return $this->photoEquipe;
    }

    public function setPhotoEquipe(?Photo $photoEquipe): self
    {
        $this->photoEquipe = $photoEquipe;

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
            $matchAVenir->setEquipe($this);
        }

        return $this;
    }

    public function removeMatchAVenir(MatchAVenir $matchAVenir): self
    {
        if ($this->matchAVenirs->removeElement($matchAVenir)) {
            // set the owning side to null (unless already changed)
            if ($matchAVenir->getEquipe() === $this) {
                $matchAVenir->setEquipe(null);
            }
        }

        return $this;
    }


    /**
     * @return Collection|Joueurs[]
     */
    public function getJoueurs(): Collection
    {
        return $this->joueurs;
    }

    public function addJoueur(Joueurs $joueur): self
    {
        if (!$this->joueurs->contains($joueur)) {
            $this->joueurs[] = $joueur;
            $joueur->setEquipe($this);
        }

        return $this;
    }

    public function removeJoueur(Joueurs $joueur): self
    {
        if ($this->joueurs->removeElement($joueur)) {
            // set the owning side to null (unless already changed)
            if ($joueur->getEquipe() === $this) {
                $joueur->setEquipe(null);
            }
        }

        return $this;
    }
    public function __toString(){
        return $this->getName();
    }

    /**
     * @return Collection|Articles[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Articles $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setEquipe($this);
        }

        return $this;
    }

    public function removeArticle(Articles $article): self
    {
        if ($this->articles->removeElement($article)) {
            // set the owning side to null (unless already changed)
            if ($article->getEquipe() === $this) {
                $article->setEquipe(null);
            }
        }

        return $this;
    }

    public function getScriptResultat(): ?string
    {
        return $this->scriptResultat;
    }

    public function setScriptResultat(?string $scriptResultat): self
    {
        $this->scriptResultat = $scriptResultat;

        return $this;
    }

}
