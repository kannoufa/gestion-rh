<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use App\Entity\Personnel;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Integer;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 * @Vich\Uploadable()
 */
class Absence
{
    const CAUSE = [
        0 => 'مرض',
        1 => 'رخصة إستثنائية',
    ];

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Personnel::class, inversedBy="absences")
     */
    private $personnel;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nomar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenomar;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filiere;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $grade;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $cause;

    /**
     * @ORM\Column(type="integer")
     */
    private $duree;

    /**
     * @ORM\Column(type="datetime")
     */
    private $apartir;

    /**
     * @ORM\Column(type="datetime")
     */
    private $jusquA;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ppr;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $statut;

    /**
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;

    /**
     * @var File|null
     * @Vich\UploadableField(mapping="motif_pdf", fileNameProperty="filename")
     */
    private $motifFile;

    public function __construct()
    {
        $this->created_at = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomar(): ?string
    {
        return $this->nomar;
    }

    public function setNomar(string $nomar): self
    {
        $this->nomar = $nomar;

        return $this;
    }

    public function getPrenomar(): ?string
    {
        return $this->prenomar;
    }

    public function setPrenomar(string $prenomar): self
    {
        $this->prenomar = $prenomar;

        return $this;
    }

    public function getFiliere(): ?string
    {
        return $this->filiere;
    }

    public function setFiliere(string $filiere): self
    {
        $this->filiere = $filiere;

        return $this;
    }

    public function getPr(): ?string
    {
        return $this->ppr;
    }

    public function setPpr(string $ppr): self
    {
        $this->ppr = $ppr;

        return $this;
    }

    public function getGrade(): ?string
    {
        return $this->grade;
    }

    public function setGrade(string $grade): self
    {
        $this->grade = $grade;

        return $this;
    }

    public function getCause(): ?string
    {
        return $this->cause;
    }

    public function setCause(string $cause): self
    {
        $this->cause = $cause;

        return $this;
    }

    public function getDuree(): ?int
    {
        return $this->duree;
    }

    public function setDuree(int $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getApartir(): ?\DateTime
    {
        return $this->apartir;
    }

    public function setApartir(\DateTime $apartir): self
    {
        $this->apartir = $apartir;

        return $this;
    }

    public function getJusquA(): ?\DateTime
    {
        return $this->jusquA;
    }

    public function setJusquA(\DateTime $jusquA): self
    {
        $this->jusquA = $jusquA;

        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;

        return $this;
    }

    public function getPersonnel(): ?Personnel
    {
        return $this->personnel;
    }

    public function setPersonnel(?Personnel $personnel): self
    {
        $this->personnel = $personnel;

        return $this;
    }

    public function getCauseType(): string
    {
        return self::CAUSE[$this->cause];
    }

    /**
     * @return null|string
     */
    public function getFilename(): ?string
    {
        return $this->filename;
    }

    /**
     * @param null|string $filename
     * @return Absence
     */
    public function setFilename(?string $filename): self
    {
        $this->filename = $filename;

        return $this;
    }

    /**
     * @return null|File
     */
    public function getMotifFile(): ?File
    {
        return $this->motifFile;
    }

    /**
     * @param null|File $motifFile
     * @return Absence
     */
    public function setMotifFile(?File $motifFile): self
    {
        $this->motifFile = $motifFile;

        return $this;
    }
}