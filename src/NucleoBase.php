<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

enum NucleoBase
{
    case Adenine;

    case Thymine;

    case Guanine;

    case Cytosine;

    public function char() : string
    {
        return match ($this) {
            self::Adenine => 'A',
            self::Thymine => 'T',
            self::Guanine => 'G',
            self::Cytosine => 'C',
        };
    }

    public function random() : self
    {
        return match (rand(0, 3)) {
            0 => self::Adenine,
            1 => self::Thymine,
            2 => self::Guanine,
            3 => self::Cytosine,
        };
    }
}
