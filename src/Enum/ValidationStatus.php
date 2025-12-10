<?php

namespace App\Enum;

enum ValidationStatus: string
{
    case EN_ATTENTE = 'En attente';
    case VALIDE = 'Validé';
    case REFUSE = 'Refusé';

    public function getLabel(): string
    {
        return match ($this) {
            self::EN_ATTENTE => 'En attente',
            self::VALIDE => 'Validé',
            self::REFUSE => 'Refusé',
        };
    }
}
