<?php

declare(strict_types=1);

namespace Oct8pus\DNA;

use ArrayAccess;
use Exception;
use Stringable;

class DeoxyriboNucleicAcidException extends Exception
{
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

    public function __construct()
    {
        $this->strand = [];
    }

    public function __toString() : string
    {
        $str = '';

        foreach ($this->strand as $nucleoBase) {
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
