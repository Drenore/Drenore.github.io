<?php

namespace App\Entity;

use App\Repository\SalleRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SalleRepository::class)
 */
class Salle
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $NumeroSalle;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $ProfSurveillant;

    /**
     * @ORM\Column(type="integer")
     */
    private $DimensionSalle;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroSalle(): ?string
    {
        return $this->NumeroSalle;
    }

    public function setNumeroSalle(string $NumeroSalle): self
    {
        $this->NumeroSalle = $NumeroSalle;

        return $this;
    }

    public function getProfSurveillant(): ?string
    {
        return $this->ProfSurveillant;
    }

    public function setProfSurveillant(string $ProfSurveillant): self
    {
        $this->ProfSurveillant = $ProfSurveillant;

        return $this;
    }

    public function getDimensionSalle(): ?int
    {
        return $this->DimensionSalle;
    }

    public function setDimensionSalle(int $DimensionSalle): self
    {
        $this->DimensionSalle = $DimensionSalle;

        return $this;
    }
}
