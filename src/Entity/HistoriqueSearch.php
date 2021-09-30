<?php

namespace App\Entity;

class HistoriqueSearch
{
    const TYPEDEMANDE = [
        'AttestationTravail' => 'Attestation de travail',
        'AttestationSalaire' => 'Attestation de salaire',
        'Absence' => 'demande d\'absence',
        'OrdreMission' => 'Ordre de mission',
    ];

    /**
     * @var string|null
     */
    private $ppr;

    /**
     * @var string|null
     */
    private $typeDemande;



    /**
     * @return string|null
     */
    public function getPpr(): ?string
    {
        return $this->ppr;
    }

    /**
     * @param string|null $ppr
     * @return HistoriqueSearch
     */
    public function setPpr(string $ppr): HistoriqueSearch
    {
        $this->ppr = $ppr;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTypeDemande(): ?string
    {
        return $this->typeDemande;
    }

    /**
     * @param string|null $typeDemande
     * @return HistoriqueSearch
     */
    public function setTypeDemande(string $typeDemande): HistoriqueSearch
    {
        $this->typeDemande = $typeDemande;

        return $this;
    }


    public function getBlockPrefix()
    {
        return '';
    }

    public function getTypeDemandeType(): string
    {
        return self::TYPEDEMANDE[$this->typeDemande];
    }
}