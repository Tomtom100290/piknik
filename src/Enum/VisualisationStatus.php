<?php
namespace App\Enum;

enum VisualisationStatus: string
{
    case ACTIF = 'Actif';
    case DESACTIVE = 'Désactivé';

     public function getLabel(): string
    {
        return match($this) {
            self::ACTIF => 'Actif',
            self::DESACTIVE => 'Désactivé',
        };
    }
}