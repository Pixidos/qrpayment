<?php

namespace Pixidos\QRPayment\Tests\Values;

use Generator;
use PHPUnit\Framework\TestCase;
use Pixidos\QRPayment\Exceptions\InvalidIbanException;
use Pixidos\QRPayment\Values\Iban;

class IbanTest extends TestCase
{
    /**
     * @dataProvider getIbans
     */
    public function testSuccessCreate(string $value, string $expected)
    {
        $iban = new Iban($value);
        $this->assertSame($expected, $iban->toFormattedString());
    }
    
    public function testCountryCode()
    {
        $iban = new Iban('CZ0635000000001000472301');
        $this->assertSame('CZ', $iban->getCountryCode());
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testSetIbanLeghts()
    {
        Iban::setIbanLenghts(['CZ' => 24,]);
        $iban = new Iban('CZ0635000000001000472301');
        $this->assertSame('CZ', $iban->getCountryCode());
        $this->expectException(InvalidIbanException::class);
        $this->expectExceptionMessage("Country 'DE' for Iban is not (yet) supported: 'CZ'");
        new Iban('DE0635000000001000472301');
    }
    
    public function testInvalidFormat()
    {
        $this->expectException(InvalidIbanException::class);
        $this->expectExceptionMessage("Iban: 'C006 3500 0000 0010 0047 2301' has invalid format");
        new Iban('C006 3500 0000 0010 0047 2301');
    }
    
    public function testInvalidLenght()
    {
        $this->expectException(InvalidIbanException::class);
        $this->expectExceptionMessage("Iban not long enough: 'CZ063500000000100047230'");
        new Iban('CZ06 3500 0000 0010 0047 230');
    }
    
    public function testNotSupportedCountryCode()
    {
        $this->expectException(InvalidIbanException::class);
        $this->expectExceptionMessage(
            "Country 'CX' for Iban is not (yet) supported: 'AL, AD, AT, AZ, BH, BE, BA, BR, BG, CR, HR, CY, CZ, DK, DO, EE, FO, FI, FR, GE, DE, GI, GR, GL, GT, HU, IS, IE, IL, IT, JO, KZ, KW, LV, LB, LI, LT, LU, MK, MT, MR, MU, MC, MD, ME, NL, NO, PK, PS, PL, PT, QA, RO, SM, SA, RS, SK, SI, ES, SE, CH, TN, TR, AE, GB, VG'"
        );
        new Iban('CX06 3500 0000 0010 0047 2301');
    }
    
    public function testInvalidIban()
    {
        $this->expectException(InvalidIbanException::class);
        $this->expectExceptionMessage("Iban: 'CZ0435000000001000472301' is invalid");
        new Iban('CZ04 3500 0000 0010 0047 2301');
    }
    
    /**
     * @return Generator
     */
    public function getIbans(): Generator
    {
        $ibans = require __DIR__ . '/_data/ibans.php';
        yield from $ibans;
    }
    
}
