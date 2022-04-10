<?php

namespace App\Entity;

use App\Entity\Sujet;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\CandidatRepository;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;


/**
 * @ORM\Entity(repositoryClass=CandidatRepository::class)
 */
class Candidat
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $cin;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=50)
     * @OA\Property(type="string", maxLength=50, description="prenom du candidat" )
     */
    private $prenom;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $motcle;

    /**
     * @var App\Entity\Sujet
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\Sujet")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="idsujet", nullable=true, referencedColumnName="id")
     * })
     * 
     * @OA\Property(ref=@Model(type=Sujet::class))
     * 
     */
    private $idSujet;

    /**
     * @var App\Entity\User
     * 
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumns({
     *      @ORM\JoinColumn(name="iduser", nullable=true, referencedColumnName="id")
     * })
     * 
     * @OA\Property(ref=@Model(type=User::class))
     * 
     */
    private $iduser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
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

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getMotcle(): ?string
    {
        return $this->motcle;
    }

    public function setMotcle(string $motcle): self
    {
        $this->motcle = $motcle;

        return $this;
    }

    /**
     * @return Sujet
     */
    public function getIdSujet() 
    {
        return $this->idSujet;
    }

     /**
     * @param Sujet $idSujet
     */
    public function setIdSujet(Sujet $idSujet): void
    {
        $this->idSujet = $idSujet;

    }
     /**
     * @return User
     */
    public function getIduser() 
    {
        return $this->iduser;
    }

     /**
     * @param User $iduser
     */
    public function setIduser(User $iduser): void
    {
        $this->iduser = $iduser;

    }
}
