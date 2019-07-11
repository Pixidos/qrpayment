<?php

namespace Pixidos\QRPayment\Tests\Values;

use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\ReferenceNumber;

class ReferenceNumberTest extends TestCase
{
    /***/
    public function testCreate()
    {
        $refNum = new ReferenceNumber('1234567890123456');
        $this->assertSame('1234567890123456', $refNum->getReferenceNumber());
        $this->assertSame('RF:1234567890123456*', (string)$refNum);
    
        $refNum = new ReferenceNumber('1234567890');
        $this->assertSame('1234567890', $refNum->getReferenceNumber());
        $this->assertSame('RF:1234567890*', (string)$refNum);
    
        $refNum = new ReferenceNumber('1');
        $this->assertSame('1', $refNum->getReferenceNumber());
        $this->assertSame('RF:1*', (string)$refNum);
    }
    
    public function testInvalidReferenceNumberStartWithZero()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Invalid reference number');
        new ReferenceNumber('0234567890123456');
    }
    
    public function testInvalidReferenceNumberContainsNotNumberCharactes()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Invalid reference number');
        new ReferenceNumber('123456789A123456');
    }
    
    
    public function testInvalidReferenceNumberTooLong()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage('Invalid reference number');
        new ReferenceNumber('12345678901234567');
    }
    
}
