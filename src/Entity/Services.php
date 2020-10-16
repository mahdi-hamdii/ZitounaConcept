<?php

namespace App\Entity;

use App\Repository\ServicesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ServicesRepository::class)
 */
class Services
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
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=SousService::class, mappedBy="service")
     */
    private $sousServices;

    public function __construct()
    {
        $this->sousServices = new ArrayCollection();
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

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|SousService[]
     */
    public function getSousServices(): Collection
    {
        return $this->sousServices;
    }

    public function addSousService(SousService $sousService): self
    {
        if (!$this->sousServices->contains($sousService)) {
            $this->sousServices[] = $sousService;
            $sousService->setService($this);
        }

        return $this;
    }

    public function removeSousService(SousService $sousService): self
    {
        if ($this->sousServices->contains($sousService)) {
            $this->sousServices->removeElement($sousService);
            // set the owning side to null (unless already changed)
            if ($sousService->getService() === $this) {
                $sousService->setService(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->getNom();
    }

}
