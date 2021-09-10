<?php

namespace App\Entity;

use App\Repository\AbsenceRepository;
use App\Entity\Personnel;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AbsenceRepository::class)
 */
class Absence
{
    const FILIERE = [
        0 => 'الرياضيات',
        1 => 'الفيزياء التطبيقية',
        2 => 'البيولوجيا',
        3 => 'الاعلاميات',
        4 => 'علوم الأرض',
        5 => 'الهندسة المدنية',
        6 => 'تقنية التواصل',
        7 => 'العلوم الكيميائية',
        8 => 'مصلحة الموارد البشرية',
    ];

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
     * @ORM\Column(type="string", length=255)
     */
    private $apartir;

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
     * @ORM\Column(type="string",nullable=true)
     */
    private $brochureFilename;

    public function getBrochureFilename()
    {
        return $this->brochureFilename;
    }

    public function setBrochureFilename($brochureFilename)
    {
        $this->brochureFilename = $brochureFilename;

        return $this;
    }

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

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getApartir(): ?string
    {
        return $this->apartir;
    }

    public function setApartir(string $apartir): self
    {
        $this->apartir = $apartir;

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

    public function getFiliereType(): string
    {
        return self::FILIERE[$this->filiere];
    }

    public function getCauseType(): string
    {
        return self::CAUSE[$this->cause];
    }
}