<?php

declare(strict_types=1);

use Oct8pus\DNA\DeoxyriboNucleicAcid;
use Oct8pus\DNA\DeoxyriboNucleicAcidException;
use Oct8pus\DNA\NucleoBase;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Oct8pus\DNA\DeoxyriboNucleicAcid
 */
final class DeoxyriboNucleicAcidTest extends TestCase
{
    public function testBasic() : void
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

        // get offset
        static::assertSame(NucleoBase::Guanine, $dna[2]);

        // set offset
        $dna[2] = NucleoBase::Cytosine;
        static::assertSame('ATCC', (string) $dna);

        // offset exists
        static::assertSame(true, isset($dna[3]));
        static::assertSame(false, isset($dna[4]));

        $dna->truncate();
        static::assertSame(0, $dna->length());
        static::assertSame(false, isset($dna[0]));
    }

    public function offsetGetValues() : array
    {
       return [
           [-1],
           ['a'],
       ];
    }

    /**
     * @dataProvider offsetGetValues
     */
    public function testOffsetGetExceptions(mixed $badValue): void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid());

        $dna[$badValue];
    }

    /**
     * @dataProvider offsetGetValues
     */
    public function testOffsetExistsExceptions(mixed $badValue): void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid());

        isset($dna[$badValue]);
    }

    public function offsetSetValues() : array
    {
       return [
           [-1],
           ['a'],
           [0],
       ];
    }

    /**
     * @dataProvider offsetSetValues
     */
    public function testOffsetSetExceptions(mixed $badValue): void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid())
            ->add(NucleoBase::Adenine);

        $dna[$badValue] = 'a';
    }

    public function testOffsetUnsetException(): void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid())
            ->add(NucleoBase::Adenine);

        unset($dna[0]);
    }
}
