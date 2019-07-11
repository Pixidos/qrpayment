<?php

namespace Pixidos\QRPayment\Tests\Values;

use Pixidos\QRPayment\Exceptions\InvalidValueException;
use Pixidos\QRPayment\Values\CurencyCode;
use PHPUnit\Framework\TestCase;

class CurencyCodeTest extends TestCase
{
    /***/
    public function testCreated()
    {
        $curenceCode = new CurencyCode(CurencyCode::CZK);
        $this->assertSame('CZK', $curenceCode->getCurrencyCode());
        $this->assertSame('CC:CZK*', (string)$curenceCode);
    
        $curenceCode = new CurencyCode('czk');
        $this->assertSame('CZK', $curenceCode->getCurrencyCode());
        $this->assertSame('CC:CZK*', (string)$curenceCode);
    }
    
    /***/
    public function testUnsupportedCurrency()
    {
        $this->expectException(InvalidValueException::class);
        $this->expectExceptionMessage("Code 'CXX'for currency is invalid. Possible codes: 'CZK'");
        $curenceCode = new CurencyCode('cxx');
    }
}
