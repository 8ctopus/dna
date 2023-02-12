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
}
