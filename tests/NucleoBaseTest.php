<?php

declare(strict_types=1);

use Oct8pus\DNA\NucleoBase;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 * @covers \Oct8pus\DNA\NucleoBase
 */
final class NucleoBaseAcidTest extends TestCase
{
    public function testName() : void
    {
        static::assertSame('Adenine', NucleoBase::Adenine->name);
        static::assertSame('Thymine', NucleoBase::Thymine->name);
        static::assertSame('Guanine', NucleoBase::Guanine->name);
        static::assertSame('Cytosine', NucleoBase::Cytosine->name);
    }

    public function testChar() : void
    {
        static::assertSame('A', NucleoBase::Adenine->char());
        static::assertSame('T', NucleoBase::Thymine->char());
        static::assertSame('G', NucleoBase::Guanine->char());
        static::assertSame('C', NucleoBase::Cytosine->char());
    }
}
