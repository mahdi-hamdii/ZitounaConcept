<?php

namespace App\Entity;

use App\Repository\SousArticleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SousArticleRepository::class)
 */
class SousArticle
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
    private $description ;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $images = [];


    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $promotion;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $tabDimension = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sousTitre1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sousTitre2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $sousTitre3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc1SousT1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc2SousT1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc3SousT1;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc1SousT2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc2SousT2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc3SousT2;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc1SousT3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc2SousT3;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $desc3SousT3;

    /**
     * @ORM\ManyToOne(targetEntity=CatalogArticle::class, inversedBy="sousArticles")
     */
    private $catalogArticle;

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

    public function setDescription(string $retour): self
    {
        $this->description = $retour;

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }
    public function addImage(string $image){
        $this->images[]=$image;
    }
    public function addTabDimension(string $string){
        $this->tabDimension[]=$string;
    }
    public function __toString()
    {
        return $this->getNom();
    }

    public function getPromotion(): ?float
    {
        return $this->promotion;
    }

    public function setPromotion(?float $promotion): self
    {
        $this->promotion = $promotion;

        return $this;
    }
    public function __construct()
    {
        $this->promotion=0;
    }

    public function getTabDimension(): ?array
    {
        return $this->tabDimension;
    }

    public function setTabDimension(?array $tabDimension): self
    {
        $this->tabDimension = $tabDimension;

        return $this;
    }

    public function getSousTitre1(): ?string
    {
        return $this->sousTitre1;
    }

    public function setSousTitre1(?string $sousTitre1): self
    {
        $this->sousTitre1 = $sousTitre1;

        return $this;
    }

    public function getSousTitre2(): ?string
    {
        return $this->sousTitre2;
    }

    public function setSousTitre2(?string $sousTitre2): self
    {
        $this->sousTitre2 = $sousTitre2;

        return $this;
    }

    public function getSousTitre3(): ?string
    {
        return $this->sousTitre3;
    }

    public function setSousTitre3(?string $sousTitre3): self
    {
        $this->sousTitre3 = $sousTitre3;

        return $this;
    }

    public function getDesc1SousT1(): ?string
    {
        return $this->desc1SousT1;
    }

    public function setDesc1SousT1(?string $desc1SousT1): self
    {
        $this->desc1SousT1 = $desc1SousT1;

        return $this;
    }

    public function getDesc2SousT1(): ?string
    {
        return $this->desc2SousT1;
    }

    public function setDesc2SousT1(?string $desc2SousT1): self
    {
        $this->desc2SousT1 = $desc2SousT1;

        return $this;
    }

    public function getDesc3SousT1(): ?string
    {
        return $this->desc3SousT1;
    }

    public function setDesc3SousT1(?string $desc3SousT1): self
    {
        $this->desc3SousT1 = $desc3SousT1;

        return $this;
    }

    public function getDesc1SousT2(): ?string
    {
        return $this->desc1SousT2;
    }

    public function setDesc1SousT2(?string $desc1SousT2): self
    {
        $this->desc1SousT2 = $desc1SousT2;

        return $this;
    }

    public function getDesc2SousT2(): ?string
    {
        return $this->desc2SousT2;
    }

    public function setDesc2SousT2(?string $desc2SousT2): self
    {
        $this->desc2SousT2 = $desc2SousT2;

        return $this;
    }

    public function getDesc3SousT2(): ?string
    {
        return $this->desc3SousT2;
    }

    public function setDesc3SousT2(?string $desc3SousT2): self
    {
        $this->desc3SousT2 = $desc3SousT2;

        return $this;
    }

    public function getDesc1SousT3(): ?string
    {
        return $this->desc1SousT3;
    }

    public function setDesc1SousT3(?string $desc1SousT3): self
    {
        $this->desc1SousT3 = $desc1SousT3;

        return $this;
    }

    public function getDesc2SousT3(): ?string
    {
        return $this->desc2SousT3;
    }

    public function setDesc2SousT3(?string $desc2SousT3): self
    {
        $this->desc2SousT3 = $desc2SousT3;

        return $this;
    }

    public function getDesc3SousT3(): ?string
    {
        return $this->desc3SousT3;
    }

    public function setDesc3SousT3(?string $desc3SousT3): self
    {
        $this->desc3SousT3 = $desc3SousT3;

        return $this;
    }

    public function getCatalogArticle(): ?CatalogArticle
    {
        return $this->catalogArticle;
    }

    public function setCatalogArticle(?CatalogArticle $catalogArticle): self
    {
        $this->catalogArticle = $catalogArticle;

        return $this;
    }
}
