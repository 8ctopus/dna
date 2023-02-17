<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

enum Protein : string
{
    case EnergyFromLight = 'ATATGGGG';

    case EnergyFromHeat = 'TCGACAAA';

    case EnergyFromHunting = 'TAGACAGA';

    static function fromName(string $name) : self
    {
        foreach (self::cases() as $case) {
            if ($name === $case->name) {
                return $case;
            }
        }
    }
}
