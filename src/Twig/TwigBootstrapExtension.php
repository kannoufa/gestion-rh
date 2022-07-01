<?php

namespace App\Twig;

use Twig\TwigFilter;
use Twig\Extension\AbstractExtension;


class TwigBootstrapExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('type', [$this, 'TypeFilter']),
            new TwigFilter('cause', [$this, 'CauseFilter']),
            new TwigFilter('typedemande', [$this, 'TypeDemandeFilter']),
        ];
    }

    public function TypeDemandeFilter($content): string
    {
        if ($content == 'Nouvelle demande') {
            $color = 'danger';
        }

        if ($content == 'en cours de traitement') {
            $color = 'warning';
        }

        if ($content == 'Disponible') {
            $color = 'success';
        }

        if ($content == 'Reçu') {
            $color = 'success';
        }

        if ($content == 'Refusé') {
            $color = 'dark';
        }

        if ($content == 'En attante de validation par le département') {
            $color = 'info';
        }

        if ($content == 'Validé par le département') {
            $color = 'success';
        }

        if ($content == 'Refusé par le département') {
            $color = 'danger';
        }

        if ($content == 'Refusé par l\'administration') {
            $color = 'danger';
        }
   

        return '<span class="badge rounded-pill badge-gradient-' . $color . '">' . $content . '</span>';
    }

    public function TypeFilter($content): string
    {
        if ($content == 'Absence') {
            $type = 'Demande d\'absence';
            $color = 'danger';
        }

        if ($content == 'OrdreMission') {
            $type = 'Ordre de mission';
            $color = 'success';
        }

        if ($content == 'AttestationTravail') {
            $type = 'Attestation de travail';
            $color = 'warning';
        }

        if ($content == 'AttestationSalaire') {
            $type = 'Attestation de salaire';
            $color = 'primary';
        }

        return '<span class="badge badge-gradient-' . $color . '">' . $type . '</span>';
    }

    public function CauseFilter($content): string
    {
        if ($content == 'مرض') {
            $type = 'Congé de maladie';
        }

        if ($content == 'رخصة إستثنائية') {
            $type = 'Autorisation exceptionnelle';
        }

        return '<b>(' . $type . ')</b>';
    }
}