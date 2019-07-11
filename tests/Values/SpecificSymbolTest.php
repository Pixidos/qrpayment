<?php

namespace Pixidos\QRPayment\Tests\Values;

use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\SpecificSymbol;

class SpecificSymbolTest extends TestCase
{
    public function testCreate()
    {
        $symbol = new SpecificSymbol('1234567890');
        $this->assertSame('1234567890', $symbol->getSymbol());
        $this->assertSame('X-SS:1234567890*', (string)$symbol);
    }
    
    public function testTooLong()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Invalid symbol ');
        new SpecificSymbol('12345678901');
    }
}
