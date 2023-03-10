<?php

declare(strict_types=1);

use Oct8pus\DNA\DeoxyriboNucleicAcid;
use Oct8pus\DNA\DeoxyriboNucleicAcidException;
use Oct8pus\DNA\NucleoBase;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @covers \Oct8pus\DNA\DeoxyriboNucleicAcid
 */
final class DeoxyriboNucleicAcidTest extends TestCase
{
    public function testBasic() : void
    {
        $dna = (new DeoxyriboNucleicAcid(0));

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
        static::assertTrue(isset($dna[3]));
        static::assertFalse(isset($dna[4]));

        $dna->truncate();
        static::assertSame(0, $dna->length());
        static::assertFalse(isset($dna[0]));
    }

    public static function offsetGetValues() : array
    {
        return [
            [-1],
            ['a'],
        ];
    }

    /**
     * @dataProvider offsetGetValues
     */
    public function testOffsetGetExceptions(mixed $badValue) : void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid(0));

        $dna[$badValue];
    }

    /**
     * @dataProvider offsetGetValues
     */
    public function testOffsetExistsExceptions(mixed $badValue) : void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid(0));

        isset($dna[$badValue]);
    }

    public static function offsetSetValues() : array
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
    public function testOffsetSetExceptions(mixed $badValue) : void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid(0))
            ->add(NucleoBase::Adenine);

        $dna[$badValue] = 'a';
    }

    public function testOffsetUnsetException() : void
    {
        static::expectException(DeoxyriboNucleicAcidException::class);

        $dna = (new DeoxyriboNucleicAcid(0))
            ->add(NucleoBase::Adenine);

        unset($dna[0]);
    }
}
