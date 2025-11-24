<?php
namespace App\Enum;

enum validationstatus: string
{
    case EN_ATTENTE = 'En attente';
    case VALIDE = 'Validé';
    case REFUSE = 'Refusé';
}
