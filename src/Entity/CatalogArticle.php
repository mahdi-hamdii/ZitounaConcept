<?php

namespace App\Entity;

use App\Repository\CatalogArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CatalogArticleRepository::class)
 */
class CatalogArticle
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
     * @ORM\ManyToOne(targetEntity=sousCategorie::class, inversedBy="catalogArticles")
     */
    private $sousCategorie;

    /**
     * @ORM\OneToMany(targetEntity=SousArticle::class, mappedBy="catalogArticle")
     */
    private $sousArticles;



    public function __construct()
    {
        $this->articles = new ArrayCollection();
        $this->sousArticles = new ArrayCollection();
    }


    public function getNom(): ?string
    {
        return $this->nom;
    }
    public function getId(): ?int
    {
        return $this->id;
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function __toString()
    {
        return $this->getNom();
    }

    public function getSousCategorie(): ?sousCategorie
    {
        return $this->sousCategorie;
    }

    public function setSousCategorie(?sousCategorie $sousCategorie): self
    {
        $this->sousCategorie = $sousCategorie;

        return $this;
    }

    /**
     * @return Collection|SousArticle[]
     */
    public function getSousArticles(): Collection
    {
        return $this->sousArticles;
    }

    public function addSousArticle(SousArticle $sousArticle): self
    {
        if (!$this->sousArticles->contains($sousArticle)) {
            $this->sousArticles[] = $sousArticle;
            $sousArticle->setCatalogArticle($this);
        }

        return $this;
    }

    public function removeSousArticle(SousArticle $sousArticle): self
    {
        if ($this->sousArticles->contains($sousArticle)) {
            $this->sousArticles->removeElement($sousArticle);
            // set the owning side to null (unless already changed)
            if ($sousArticle->getCatalogArticle() === $this) {
                $sousArticle->setCatalogArticle(null);
            }
        }

        return $this;
    }
}
