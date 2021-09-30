<?php

namespace App\Entity;

class AbsenceSearch
{
    /**
     * @var string|null
     */
    private $ppr;

    /**
     * @var string|null
     */
    private $annee;


    /**
     * @return string|null
     */
    public function getPpr(): ?string
    {
        return $this->ppr;
    }

    /**
     * @param string|null $ppr
     * @return AbsenceSearch
     */
    public function setPpr(string $ppr): AbsenceSearch
    {
        $this->ppr = $ppr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    /**
     * @param string|null $annee
     * @return AbsenceSearch
     */
    public function setAnnee(string $annee): AbsenceSearch
    {
        $this->annee = $annee;

        return $this;
    }

    public function getBlockPrefix()
    {
        return '';
    }
}