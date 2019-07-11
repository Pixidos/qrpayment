<?php

namespace Pixidos\QRPayment\Tests\Values;

use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\VariableSymbol;
use PHPUnit\Framework\TestCase;

class VariableSymbolTest extends TestCase
{
    public function testCreate()
    {
        $symbol = new VariableSymbol('1234567890');
        $this->assertSame('1234567890', $symbol->getSymbol());
        $this->assertSame('X-VS:1234567890*', (string)$symbol);
    }
    
    public function testTooLong()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Invalid symbol ');
        new VariableSymbol('12345678901');
    }
}
