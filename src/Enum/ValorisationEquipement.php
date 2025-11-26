<?php
namespace App\Enum;

enum ValorisationEquipement: string
{
    case INTERET_BON = '1';
    case INTERET_TRESBON = '2';
    case INTERET_EXCELLENT = '3';

    public function getLabel(): string
    {
        return match($this) {
            self::INTERET_BON => '1',
            self::INTERET_TRESBON => '2',
            self::INTERET_EXCELLENT => '3',
        };
    }
}