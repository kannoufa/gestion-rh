<?php

namespace App\Entity;

class PersonnelSearch
{
    /**
     * @var string|null
     */
    private $ppr;

    /**
     * @var string|null
     */
    private $nom;

    /**
     * @var string|null
     */
    private $prenom;

    /**
     * @var string|null
     */
    private $fonction;

    /**
     * @var string|null
     */
    private $grade;


    /**
     * @return string|null
     */
    public function getPpr(): ?string
    {
        return $this->ppr;
    }

    /**
     * @param string|null $ppr
     * @return PersonnelSearch
     */
    public function setPpr(string $ppr): PersonnelSearch
    {
        $this->ppr = $ppr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getNom(): ?string
    {
        return $this->nom;
    }

    /**
     * @param string|null $nom
     * @return PersonnelSearch
     */
    public function setNom(string $nom): PersonnelSearch
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    /**
     * @param string|null $prenom
     * @return PersonnelSearch
     */
    public function setPrenom(string $prenom): PersonnelSearch
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    /**
     * @param string|null $fonction
     * @return PersonnelSearch
     */
    public function setFonction(string $fonction): PersonnelSearch
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getGrade(): ?string
    {
        return $this->grade;
    }

    /**
     * @param string|null $grade
     * @return PersonnelSearch
     */
    public function setGrade(string $grade): PersonnelSearch
    {
        $this->grade = $grade;

        return $this;
    }

    public function getBlockPrefix()
    {
        return '';
    }
}