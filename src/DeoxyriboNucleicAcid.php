<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

use ArrayAccess;
use Exception;
use Stringable;

class DeoxyriboNucleicAcidException extends Exception
{
}

enum MutationType
{
    case Substitution;

    case Insertion;

    case Deletion;
}

/**
 * @implements ArrayAccess<int, NucleoBase>
 */
class DeoxyriboNucleicAcid implements Stringable, ArrayAccess
{
    /**
     * @var NucleoBase[]
     */
    private array $strand;

    public function __construct(int $length)
    {
        $this->strand = [];

        for ($i = 0; $i < $length; ++$i) {
            $this->strand[] = NucleoBase::random();
        }
    }

    public function __toString() : string
    {
        $str = '';

        foreach ($this->strand as $index => $nucleoBase) {
            if ($index && !($index % 6)) {
                $str .= ' ';
            }

            $str .= $nucleoBase->value;
        }

        return $str;
    }

    public function add(NucleoBase $nucleoBase) : self
    {
        $this->strand[] = $nucleoBase;
        return $this;
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

    public function mutate(MutationType $mutationType) : self
    {
        // point mutation
        // frameshift mutation (insert or delete)
        // duplication

        switch ($mutationType) {
            case MutationType::Substitution:
                $this->strand[rand(0, $this->length() - 1)] = NucleoBase::random();
                break;

            case MutationType::Insertion:
                array_splice($this->strand, rand(0, $this->length()), 0, [NucleoBase::random()]);
                break;

            case MutationType::Deletion:
                array_splice($this->strand, rand(0, $this->length() - 1), 1);
                break;
        }

        return $this;
    }

    public function offsetGet(mixed $offset) : NucleoBase
    {
        if (gettype($offset) !== 'integer') {
            throw new DeoxyriboNucleicAcidException('offset must be integer');
        }

        if ($offset >= $this->length() || $offset < 0) {
            throw new DeoxyriboNucleicAcidException('out of range');
        }

        return $this->strand[$offset];
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
