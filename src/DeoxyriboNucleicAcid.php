<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

use Oct8pus\DNA\NucleoBase;
use Stringable;

class DeoxyriboNucleicAcid implements Stringable
{
    private array $strand;

    public function __construct()
    {
        $this->strand = [];
    }

    public function add(NucleoBase $nucleoBase) : self
    {
        $this->strand[] = $nucleoBase;
        return $this;
    }

    public function __toString() : string
    {
        $str = '';

        foreach ($this->strand as $nucleoBase) {
            $str .= $nucleoBase->char();
        }

        return $str;
    }

    public function length() : int
    {
        return count($this->strand);
    }

    public function truncate() : self
    {
        $this->strand = [];
        return $this;
    }
}
