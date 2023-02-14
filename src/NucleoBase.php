<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

enum NucleoBase : string
{
    case Adenine = 'A';

    case Thymine = 'T';

    case Guanine = 'G';

    case Cytosine = 'C';

    public static function random() : self
    {
        return match (rand(0, 3)) {
            0 => self::Adenine,
            1 => self::Thymine,
            2 => self::Guanine,
            3 => self::Cytosine,
        };
    }
}
