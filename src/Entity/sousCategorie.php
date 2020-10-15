<?php

namespace App\Entity;

use App\Repository\SousCategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousCategorieRepository::class)
 */
class sousCategorie
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
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=Article::class, mappedBy="sousCategorie")
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="sousCategories")
     */
    private $categorie;

    /**
     * @ORM\OneToMany(targetEntity=CatalogArticle::class, mappedBy="sousCategorie")
     */
    private $catalogArticles;

    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->catalogArticles = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    public function addArticle(Article $article): self
    {
        if (!$this->articles->contains($article)) {
            $this->articles[] = $article;
            $article->setSousCategorie($this);
        }

        return $this;
    }

    public function removeArticle(Article $article): self
    {
        if ($this->articles->contains($article)) {
            $this->articles->removeElement($article);
            // set the owning side to null (unless already changed)
            if ($article->getSousCategorie() === $this) {
                $article->setSousCategorie(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
    public function __toString()
    {
        return $this->getNom();
    }

    /**
     * @return Collection|CatalogArticle[]
     */
    public function getCatalogArticles(): Collection
    {
        return $this->catalogArticles;
    }

    public function addCatalogArticle(CatalogArticle $catalogArticle): self
    {
        if (!$this->catalogArticles->contains($catalogArticle)) {
            $this->catalogArticles[] = $catalogArticle;
            $catalogArticle->setSousCategorie($this);
        }

        return $this;
    }

    public function removeCatalogArticle(CatalogArticle $catalogArticle): self
    {
        if ($this->catalogArticles->contains($catalogArticle)) {
            $this->catalogArticles->removeElement($catalogArticle);
            // set the owning side to null (unless already changed)
            if ($catalogArticle->getSousCategorie() === $this) {
                $catalogArticle->setSousCategorie(null);
            }
        }

        return $this;
    }
}
