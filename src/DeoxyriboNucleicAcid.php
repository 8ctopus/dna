<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

use ArrayAccess;
use Exception;
use Stringable;

class DeoxyriboNucleicAcidException extends Exception
{
}

enum MutationType : int
{
    case Substitution = 0;

    case Insertion = 1;

    case Deletion = 2;

    public static function random() : self
    {
        return self::from(rand(0, 2));
    }
}

/**
 * @implements ArrayAccess<int, NucleoBase>
 */
class DeoxyriboNucleicAcid implements Stringable, ArrayAccess
{
    private string $strand;

    public function __construct(int $length)
    {
        $this->strand = '';

        for ($i = 0; $i < $length; ++$i) {
            $this->strand .= NucleoBase::random()->value;
        }
    }

    public function __toString() : string
    {
        $length = strlen($this->strand);

        return "[{$length}] {$this->strand}";
    }

    public function add(NucleoBase $nucleoBase) : self
    {
        $this->strand[] = $nucleoBase;
        return $this;
    }

    public function length() : int
    {
        return strlen($this->strand);
    }

    public function truncate() : self
    {
        $this->strand = '';
        return $this;
    }

    public function mutate(MutationType $mutationType) : self
    {
        // point mutation
        // frameshift mutation (insert or delete)
        // duplication

        switch ($mutationType) {
            case MutationType::Substitution:
                $this->strand[rand(0, $this->length() - 1)] = NucleoBase::random()->value;
                break;

            case MutationType::Insertion:
                $arr = str_split($this->strand, 1);
                $rnd = rand(0, $this->length());
                array_splice($arr, $rnd, 0, NucleoBase::random()->value);
                $this->strand = implode('', $arr);
                break;

            case MutationType::Deletion:
                $arr = str_split($this->strand, 1);
                $rnd = rand(0, $this->length() - 1);
                array_splice($arr, $rnd, 1);
                $this->strand = implode('', $arr);
                break;
        }

        return $this;
    }

    public function searchPattern(string $pattern) : bool
    {
        return strpos($this->strand, $pattern) !== false;
    }

    public function offsetGet(mixed $offset) : NucleoBase
    {
        if (gettype($offset) !== 'integer') {
            throw new DeoxyriboNucleicAcidException('offset must be integer');
        }

        if ($offset >= $this->length() || $offset < 0) {
            throw new DeoxyriboNucleicAcidException('out of range');
        }

        return NucleoBase::from($this->strand[$offset]);
    }

    public function offsetSet(mixed $offset, mixed $value) : void
    {
        if (gettype($offset) !== 'integer') {
            throw new DeoxyriboNucleicAcidException('offset must be integer');
        }

        if ($offset >= $this->length() || $offset < 0) {
            throw new DeoxyriboNucleicAcidException('out of range');
        }

        if ($value instanceof NucleoBase) {
            $this->strand[$offset] = $value;
        } else {
            throw new DeoxyriboNucleicAcidException('value must be NucleoBase');
        }
    }

    public function offsetExists(mixed $offset) : bool
    {
        if (gettype($offset) !== 'integer') {
            throw new DeoxyriboNucleicAcidException('offset must be integer');
        }

        if ($offset < 0) {
            throw new DeoxyriboNucleicAcidException('offset must be positive');
        }

        if ($offset < $this->length()) {
            return true;
        }

        return false;
    }

    public function offsetUnset(mixed $offset) : void
    {
        throw new DeoxyriboNucleicAcidException('not implemented');
        //unset($this->strand[$offset]);
    }
}
