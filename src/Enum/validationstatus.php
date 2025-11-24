<?php
namespace App\Enum;

enum ValidationStatus: string
{
    case EN_ATTENTE = 'En attente';
    case VALIDE = 'Validé';
    case REFUSE = 'Refusé';
}
