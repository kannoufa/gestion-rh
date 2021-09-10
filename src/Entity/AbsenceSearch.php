<?php

namespace App\Entity;

class AbsenceSearch
{
    /**
     * @var string|null
     */
    private $ppr;


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

    public function getBlockPrefix()
    {
        return '';
    }
}