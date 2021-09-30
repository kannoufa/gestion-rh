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
        ];
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

        return '<span class="badge bg-' . $color . '">' . $type . '</span>';
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