<?php

namespace Pixidos\QRPayment\Tests\Values;

use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\Amount;
use PHPUnit\Framework\TestCase;

class AmountTest extends TestCase
{
    public function testCreated()
    {
        $amount = new Amount(9999.999);
        $this->assertSame('10000.00', $amount->getAmount());
        $this->assertSame('AM:10000.00*', (string)$amount);
    
        $amount = new Amount(9999.99);
        $this->assertSame('9999.99', $amount->getAmount());
        $this->assertSame('AM:9999.99*', (string)$amount);
    
        $amount = new Amount(9999999.99);
        $this->assertSame('9999999.99', $amount->getAmount());
        $this->assertSame('AM:9999999.99*', (string)$amount);
    }
    
    public function testTooBigAmountException()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Amount: "10000000" is invalid. Must be in range: "0.01 - 9999999.99"');
        $amount = new Amount(9999999.999);
    }
}
