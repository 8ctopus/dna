<?php

declare(strict_types=1);

use Oct8pus\DNA\DeoxyriboNucleicAcid;
use Oct8pus\DNA\NucleoBase;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Oct8pus\DNA\DeoxyriboNucleicAcid
 */
final class DeoxyriboNucleicAcidTest extends TestCase
{
    public function test() : void
    {
        $dna = (new DeoxyriboNucleicAcid());

        static::assertSame(0, $dna->length());
        static::assertSame('', (string) $dna);

        $dna
            ->add(NucleoBase::Adenine)
            ->add(NucleoBase::Thymine)
            ->add(NucleoBase::Guanine)
            ->add(NucleoBase::Cytosine);

        static::assertSame(4, $dna->length());
        static::assertSame('ATGC', (string) $dna);

        $dna->truncate();

        static::assertSame(0, $dna->length());
    }
}
